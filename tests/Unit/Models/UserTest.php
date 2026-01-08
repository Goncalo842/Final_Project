<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created(): void
    {
        $user = User::create([
            'name' => 'João Silva',
            'email' => 'joao@example.com',
            'password' => bcrypt('password123'),
            'saldo' => 0,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'joao@example.com',
            'name' => 'João Silva',
        ]);
    }

    public function test_password_is_hidden_on_serialization(): void
    {
        $user = User::factory()->create();

        $this->assertNotContains('password', $user->toArray());
    }

    public function test_user_saldo_can_be_set(): void
    {
        $user = User::factory()->create(['saldo' => 100.00]);

        $this->assertEquals(100.00, $user->saldo);
    }
}
