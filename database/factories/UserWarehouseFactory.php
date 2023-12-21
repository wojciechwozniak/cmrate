<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserWarehouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                // Utwórz nowego użytkownika, jeśli nie ma jeszcze przypisanego do magazynu
                $userIdsAssigned = \App\Models\UserWarehouse::pluck('user_id')->toArray();
                $availableUserIds = \App\Models\User::whereNotIn('id', $userIdsAssigned)->pluck('id')->toArray();

                if (empty($availableUserIds)) {
                    // Jeśli nie ma dostępnych użytkowników, utwórz nowego
                    return \App\Models\User::factory()->create()->id;
                }

                return $this->faker->randomElement($availableUserIds);
            },
            'warehouse_id' => function () {
                $availableWarehouseIds = \App\Models\Warehouse::pluck('id')->toArray();
                return $this->faker->randomElement($availableWarehouseIds);

            },
            'created_at' => now(),
            'updated_at' => now(),
        ];

    }
}
