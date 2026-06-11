<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $orders = $user
            ->orders()
            ->with('items')
            ->latest()
            ->get()
            ->map(function (Order $order) {
                return [
                    'id' => $order->order_number,
                    'store' => $order->store_name ?: 'SeaBiz',
                    'storeCity' => $order->store_city ?: 'Indonesia',
                    'status' => $order->status,
                    'date' => $order->created_at->translatedFormat('d M Y'),
                    'createdAt' => $order->created_at->toIso8601String(),
                    'items' => $order->items->map(function ($item) {
                        return [
                            'nama' => $item->name,
                            'qty' => (int) $item->qty,
                            'harga' => (int) $item->price,
                            'satuan' => $item->unit,
                            'img' => $item->image,
                        ];
                    })->values(),
                    'alamat' => [
                        'nama' => $order->shipping_name,
                        'telepon' => $order->shipping_phone,
                        'alamat' => $order->shipping_address,
                        'kota' => $order->shipping_city,
                        'kecamatan' => $order->shipping_district,
                        'catatan' => $order->shipping_note,
                    ],
                    'pembayaran' => $order->payment_method,
                    'voucher' => $order->voucher_code,
                    'diskon' => (int) $order->discount_amount,
                    'ongkir' => (int) $order->shipping_fee,
                    'subtotal' => (int) $order->subtotal,
                    'total' => (int) $order->total,
                ];
            })
            ->values();

        return view('home.pesanan', compact('orders', 'user'));
    }

    public function store(Request $request)
    {
        $payload = $request->validate([
            'items' => ['required', 'array'],
            'items.*.nama' => ['required', 'string'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.harga' => ['required', 'integer', 'min:0'],
            'items.*.satuan' => ['nullable', 'string'],
            'items.*.img' => ['nullable', 'string'],
            'address' => ['required', 'array'],
            'address.nama' => ['required', 'string'],
            'address.telepon' => ['required', 'string'],
            'address.alamat' => ['required', 'string'],
            'address.kota' => ['required', 'string'],
            'address.kecamatan' => ['nullable', 'string'],
            'address.catatan' => ['nullable', 'string'],
            'payment_method' => ['required', 'string'],
            'voucher_code' => ['nullable', 'string'],
            'discount_amount' => ['nullable', 'integer', 'min:0'],
            'shipping_fee' => ['nullable', 'integer', 'min:0'],
            'subtotal' => ['required', 'integer', 'min:0'],
            'total' => ['required', 'integer', 'min:0'],
        ]);

        $order = Auth::user()->orders()->create([
            'order_number' => 'ORD-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4)),
            'store_name' => 'SeaBiz',
            'store_city' => $payload['address']['kota'] ?? 'Indonesia',
            'status' => 'belum_dibayar',
            'payment_method' => $payload['payment_method'],
            'voucher_code' => $payload['voucher_code'] ?? null,
            'discount_amount' => (int) ($payload['discount_amount'] ?? 0),
            'shipping_fee' => (int) ($payload['shipping_fee'] ?? 0),
            'subtotal' => (int) $payload['subtotal'],
            'total' => (int) $payload['total'],
            'shipping_name' => $payload['address']['nama'],
            'shipping_phone' => $payload['address']['telepon'],
            'shipping_address' => $payload['address']['alamat'],
            'shipping_city' => $payload['address']['kota'],
            'shipping_district' => $payload['address']['kecamatan'] ?? null,
            'shipping_note' => $payload['address']['catatan'] ?? null,
        ]);

        foreach ($payload['items'] as $item) {
            $order->items()->create([
                'name' => $item['nama'],
                'qty' => (int) $item['qty'],
                'price' => (int) $item['harga'],
                'unit' => $item['satuan'] ?? 'pcs',
                'image' => $item['img'] ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'order_id' => $order->order_number,
            'payment_method' => $payload['payment_method'],
            'payment_code' => $this->buildPaymentCode($payload['payment_method'], $order->order_number),
        ]);
    }

    public function confirmPayment(Request $request)
    {
        $payload = $request->validate([
            'order_id' => ['required', 'string'],
        ]);

        $order = Order::where('order_number', $payload['order_id'])->where('user_id', Auth::id())->firstOrFail();
        $order->status = 'dikemas';
        $order->save();

        return response()->json([
            'success' => true,
            'status' => $order->status,
        ]);
    }

    private function buildPaymentCode(string $paymentMethod, string $orderNumber): string
    {
        if ($paymentMethod === 'qris') {
            return 'QRIS-' . strtoupper(substr($orderNumber, -6));
        }

        if ($paymentMethod === 'bank') {
            return 'BANK-' . strtoupper(substr($orderNumber, -6));
        }

        return 'COD';
    }
}
