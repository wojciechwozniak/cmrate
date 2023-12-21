<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timeboard>
 */
class TimeboardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTimeBetween('2023-12-01', '2023-12-23')->format('Y-m-d'),
            'hour_start' => $this->faker->dateTimeBetween('06:00', '09:00')->format('H:i'),
            'hour_end' => $this->faker->dateTimeBetween('15:00', '20:00')->format('H:i'),
            'user_id' => function () {
                // Pobierz istniejące identyfikatory użytkowników z bazy danych
                $existingUserIds = \App\Models\User::pluck('id')->toArray();

                // Wybierz losowego istniejącego użytkownika
                return $this->faker->randomElement($existingUserIds);
            },
            'user_id_sign' => function () {
                // Pobierz istniejące identyfikatory użytkowników z bazy danych
                $existingUserIds = \App\Models\User::pluck('id')->toArray();

                // Wybierz losowego istniejącego użytkownika
                return $this->faker->randomElement($existingUserIds);
            },
            'warehouse_id' => function () {
                // Pobierz istniejące identyfikatory użytkowników z bazy danych
                $existingUserIds = \App\Models\Warehouse::pluck('id')->toArray();

                // Wybierz losowego istniejącego użytkownika
                return $this->faker->randomElement($existingUserIds);
            },
            'created_at' => now(),
            'updated_at' => now(),
        ];

    }
}
