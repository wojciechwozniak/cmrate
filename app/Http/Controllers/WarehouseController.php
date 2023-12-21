<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    public function index()
    {
        return view('warehouse')->with(['warehouses' => Warehouse::all()->toArray()]);
    }

    public function single($id)
    {
        $employees = User::whereHas('warehouse', function ($q) use ($id) {
            $q->where('warehouse_id', $id);
            $q->where('active', 1);
        })->get()->toArray();
        $employees_to_select = User::whereNotIn('id',array_column($employees,'id'))->get()->toArray();
        return view('warehousesingle')->with(['warehouse' => Warehouse::find($id)->toArray(), 'employees' => $employees, 'employees_to_select' => $employees_to_select]);

    }

    public function addEmployee(Request $request)
    {
        DB::table('user_warehouse')->insert([
            'user_id' => $request->get('employee_id'),
            'warehouse_id' => $request->get('warehouse_id'),
            'active' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return redirect('warehouse/' . $request->get('warehouse_id'))->with('status', 'Pracownik został dodany');
    }

    public function remove(Request $request)
    {
        // Pobieramy dane z formularza
        $employee = $request->input('employee_id');
        $warehouse = $request->input('warehouse_id');

        DB::table('user_warehouse')->where([
            'user_id' => $employee,
            'warehouse_id' => $warehouse
        ])->update([
            'active' => 0
        ]);

        // Zwracamy odpowiedź (możesz dostosować do swoich potrzeb)
        return redirect('/warehouse/' . $request->get('warehouse_id'))->with('status', 'Pracownik usunięty pomyślnie');
    }
}
