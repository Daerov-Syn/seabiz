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
}
