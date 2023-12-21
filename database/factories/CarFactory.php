<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mark' => $this->faker->randomElement(['Toyota', 'Ford', 'Honda', 'Chevrolet', 'BMW']),
            'model' => $this->faker->randomElement(['Camry', 'F-150', 'Civic', 'Malibu', '3 Series']),
            'mileage' => $this->faker->randomNumber(5),
            'available' => $this->faker->randomElement([1,0]),
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
