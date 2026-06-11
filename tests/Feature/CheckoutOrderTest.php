<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_place_order_and_save_it(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('checkout.place-order'), [
            'items' => [
                [
                    'nama' => 'Ikan Kakap Merah',
                    'qty' => 2,
                    'harga' => 20000,
                    'satuan' => 'kg',
                    'img' => '/img/kakap.jpg',
                ],
            ],
            'address' => [
                'nama' => 'Budi Santoso',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Nelayan No. 12',
                'kota' => 'Surabaya',
                'kecamatan' => 'Waru',
                'catatan' => 'Tinggalkan di depan rumah',
            ],
            'payment_method' => 'qris',
            'voucher_code' => 'NELAYAN10',
            'discount_amount' => 10000,
            'shipping_fee' => 15000,
            'subtotal' => 40000,
            'total' => 45000,
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status' => 'belum_dibayar',
            'payment_method' => 'qris',
            'total' => 45000,
        ]);
        $this->assertDatabaseHas('order_items', [
            'name' => 'Ikan Kakap Merah',
            'qty' => 2,
        ]);
    }
}
