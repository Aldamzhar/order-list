<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $statuses = ['pending', 'processing', 'shipped', 'delivered'];

        return [
            'number' => $this->uniqueNumber(),
            'date' => $this->faker->dateTime(),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'status' => $this->faker->randomElement($statuses),
            'user_id' => User::all()->random()->id
        ];
    }

    private function uniqueNumber()
    {
        do {
            $number = uniqid();
        } while (Order::where('number', $number)->exists());

        return $number;
    }
}
