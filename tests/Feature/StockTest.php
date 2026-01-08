<?php

namespace Tests\Feature;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    public function test_multiple_stock_items_can_be_created(): void
    {
        Stock::factory(3)->create();

        $this->assertDatabaseCount('stock', 3);
    }

    public function test_stock_item_can_be_created_directly(): void
    {
        $stock = Stock::factory()->create([
            'nome' => 'Novo Produto',
        ]);

        $this->assertDatabaseHas('stock', [
            'nome' => 'Novo Produto',
        ]);
    }

    public function test_stock_item_can_be_updated_directly(): void
    {
        $stock = Stock::factory()->create();

        $stock->update([
            'nome' => 'Produto Atualizado',
        ]);

        $this->assertDatabaseHas('stock', [
            'id' => $stock->id,
            'nome' => 'Produto Atualizado',
        ]);
    }

    public function test_stock_item_can_be_deleted_directly(): void
    {
        $stock = Stock::factory()->create();
        $stockId = $stock->id;

        $stock->delete();

        $this->assertDatabaseMissing('stock', [
            'id' => $stockId,
        ]);
    }
}
