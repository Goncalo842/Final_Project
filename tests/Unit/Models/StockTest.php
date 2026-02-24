<?php

namespace Tests\Unit\Models;

use App\Models\Stock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_can_be_created(): void
    {
        $stock = Stock::create([
            'nome' => 'Produto Teste',
            'descricao' => 'Descrição do produto',
            'preco' => 29.99,
            'imagem' => 'produto.jpg',
        ]);

        $this->assertDatabaseHas('stock', [
            'nome' => 'Produto Teste',
            'preco' => 29.99,
        ]);
    }

    public function test_stock_preco_is_numeric(): void
    {
        $stock = Stock::factory()->create(['preco' => 49.99]);

        $this->assertTrue(is_numeric($stock->preco));
    }
}
