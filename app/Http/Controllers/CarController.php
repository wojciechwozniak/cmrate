<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::with('user')->get()->toArray();
        return view('cars')->with(['cars' => $cars]);
    }

    public function change(Request $request)
    {

        $car = Car::find($request->get('car_id'));
        if ($car->available === 0) {
            $car->mileage = $request->get('odometer_value');
        }
        $car->available = !$car->available;
        $car->user_id = $request->user_id;
        $car->save();
        return redirect('/cars');
    }
}
