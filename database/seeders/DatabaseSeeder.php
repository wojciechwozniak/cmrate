<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Car;
use App\Models\Timeboard;
use App\Models\User;
use App\Models\UserWarehouse;
use App\Models\Warehouse;
use Database\Factories\UserWarehouseFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Utwórz rekordy dla User
        $users = User::factory(15)->create();

        // Utwórz rekordy dla Warehouse
        $warehouses = Warehouse::factory(3)->create();

        // Utwórz rekordy dla Car
        $cars = Car::factory(6)->create();

        // Utwórz rekordy dla Timeboard
        $timeboards = Timeboard::factory(100)->create();

        // Utwórz rekordy dla UserWarehouse
        UserWarehouse::factory(10)->create();
    }
}
