<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $data_to_view = $this->getDataForUser(Auth::user()->role);
//        dd($data_to_view);
        return view('dashboard')->with(['warehouses' => $data_to_view[0], 'employees' => $data_to_view[1], 'cars' => $data_to_view[2]]);
    }

    public function getDataForUser($role)
    {
        $id = Auth::user()->id;
        $employees = User::with(['timesheet' => function ($q) use ($id) {
            $q->where('user_id', $id);
            $q->orderBy('date','DESC');
        }])->get()->toArray();
        $warehouses = Warehouse::with(['employees' => function ($q) use ($id) {
            $q->where('user_id', $id);
        }])->get()->toArray();
        $cars = Car::where('user_id', $id)->get()->toArray();
        return [$warehouses, $employees, $cars];

    }
}
