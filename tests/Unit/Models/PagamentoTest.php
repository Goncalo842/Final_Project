<?php

namespace Tests\Unit\Models;

use App\Models\Pagamento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagamentoTest extends TestCase
{
    use RefreshDatabase;

    public function test_pagamento_can_be_created(): void
    {
        $user = User::factory()->create();

        $pagamento = Pagamento::create([
            'user_id' => $user->id,
            'mes' => 'Janeiro',
            'pago' => true,
        ]);

        $this->assertDatabaseHas('pagamentos', [
            'user_id' => $user->id,
            'mes' => 'Janeiro',
            'pago' => true,
        ]);
    }

    public function test_pagamento_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $pagamento = Pagamento::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($pagamento->user()->exists());
        $this->assertEquals($user->id, $pagamento->user->id);
    }

}
