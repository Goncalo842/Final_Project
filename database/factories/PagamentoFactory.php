<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PagamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'mes' => $this->faker->month(),
            'pago' => $this->faker->boolean(),
        ];
    }
}
