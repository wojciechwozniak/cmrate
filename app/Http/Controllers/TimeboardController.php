<?php

namespace App\Http\Controllers;

use App\Models\Timeboard;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimeboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $dates = $this->getDaysAndDatesForWeek($now->year, $now->weekOfYear);
        $employees = User::with('timesheet')->get();
        return view('timeboard')->with(['employees' => $employees, 'dates' => $dates]);
    }

    public function getDaysAndDatesForWeek($year, $weekNumber)
    {
        Carbon::setLocale('pl');
        // Ustawiamy pierwszy dzień roku
        $startDate = Carbon::createFromDate($year, 1, 1);

        // Dodajemy odpowiednią liczbę tygodni
        $startDate->addWeeks($weekNumber - 1);

        // Pobieramy datę początkową pierwszego dnia tygodnia
        $startOfWeek = $startDate->startOfWeek();

        // Inicjalizujemy pustą tablicę na dni tygodnia i daty
        $daysOfWeek = [];
        $datesOfWeek = [];

        // Pobieramy dni tygodnia i dokładne daty dla danego tygodnia
        for ($i = 0; $i < 7; $i++) {
            $daysOfWeek[$i][] = $startOfWeek->dayName;
            $daysOfWeek[$i][] = $startOfWeek->toDateString();
            $startOfWeek->addDay();
        }

        return $daysOfWeek;
    }

    public function change(Request $request)
    {
        foreach ($request->all() as $key => $item){
            $timeboard = new Timeboard();
            $timeboard->date = $item['dateData'];
            $timeboard->hour_start = $item['hourStart'];
            $timeboard->hour_end = $item['hourEnd'];
            $timeboard->user_id = $item['employeeId'];
            $timeboard->warehouse_id = 1;
            $timeboard->user_id_sign = $item['userSign'];
            $timeboard->save();
        }
        return redirect('/timeboard')->with('status','Zapisano czasy pracy');
    }
}
