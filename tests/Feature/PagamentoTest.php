<?php

namespace Tests\Feature;

use App\Models\Pagamento;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PagamentoTest extends TestCase
{
    use RefreshDatabase;

    public function test_pagamento_list_can_be_created(): void
    {
        $user = User::factory()->create();
        Pagamento::factory(3)->create(['user_id' => $user->id]);

        $this->assertDatabaseCount('pagamentos', 3);
    }

    public function test_pagamento_can_be_marked_as_paid_directly(): void
    {
        $user = User::factory()->create();
        $pagamento = Pagamento::factory()->create([
            'user_id' => $user->id,
            'pago' => false,
        ]);

        $pagamento->update(['pago' => true]);

        $this->assertDatabaseHas('pagamentos', [
            'id' => $pagamento->id,
            'pago' => true,
        ]);
    }

    public function test_user_pagamentos_relationship(): void
    {
        $user = User::factory()->create();
        Pagamento::factory(5)->create(['user_id' => $user->id]);

        $this->assertEquals(5, $user->pagamentos()->count());
    }
}
