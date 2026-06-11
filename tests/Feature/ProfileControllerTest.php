<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile_and_password(): void
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'user@example.com',
            'password' => Hash::make('old-password'),
        ]);

        $this->actingAs($user)->postJson(route('profile.update'), [
            'name' => 'New Name',
            'email' => 'new@example.com',
            'phone' => '08111111111',
            'username' => 'newuser',
            'bio' => 'Updated bio',
        ]);

        $this->actingAs($user)->postJson(route('profile.password'), [
            'current_password' => 'old-password',
            'password' => 'NewPassword123!',
            'password_confirmation' => 'NewPassword123!',
        ]);

        $user->refresh();

        $this->assertSame('New Name', $user->name);
        $this->assertSame('new@example.com', $user->email);
        $this->assertTrue(Hash::check('NewPassword123!', $user->password));
    }

    public function test_seller_can_be_registered_and_create_product(): void
    {
        $user = User::factory()->create([
            'name' => 'Seller Name',
            'email' => 'seller@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->actingAs($user)->post(route('seller.upgrade'), [
            'seller_name' => 'Toko SeaBiz',
            'seller_description' => 'Produk segar terbaik',
            'seller_phone' => '081234567890',
            'seller_address' => 'Jakarta',
        ]);

        $user->refresh();

        $this->assertSame('penjual', $user->role);
        $this->assertSame('Toko SeaBiz', $user->seller_name);

        $this->actingAs($user)->post(route('seller.products.store'), [
            'name' => 'Ikan Segar',
            'description' => 'Fresh fish',
            'price' => 50000,
            'stock' => 10,
            'unit' => 'kg',
        ]);

        $this->assertDatabaseHas('products', [
            'user_id' => $user->id,
            'name' => 'Ikan Segar',
            'price' => 50000,
        ]);
    }
}
