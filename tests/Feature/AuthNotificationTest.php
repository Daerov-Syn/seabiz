<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthNotificationTest extends TestCase
{
    public function test_login_page_shows_error_message_from_session(): void
    {
        $response = $this->withSession([
            'status' => 'error',
            'message' => 'Username atau password salah.',
        ])->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Username atau password salah.');
    }
}
