@php
    use Carbon\Carbon;
@endphp
<x-app-layout>
    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row mb-3">
                        <div class="card">
                            <h5 class="card-header">Obiekty do których jesteś przypisany</h5>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($warehouses as $warehouse)
                                        <div class="col-md-4 mb-2">
                                            <div class="card text-center">
                                                <div class="card-body">
                                                    <div class="tab-content p-0">
                                                        <div class="tab-pane fade active show"
                                                             id="navs-pills-tab-home-{{$warehouse['id']}}"
                                                             role="tabpanel">
                                                            <h5 class="card-title">{{$warehouse['name']}}</h5>
                                                            @if(Auth::user()->role !== 'employee')
                                                                <p class="card-text">
                                                                    Dodatkowe informacje o obiekcie
                                                                </p>
                                                                <a href="/warehouse/{{$warehouse['id']}}"
                                                                   class="btn btn-primary waves-effect waves-light">Szczegóły
                                                                    obiektu</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <div class="card">
                            <h5 class="card-header">Ostatnie czasówki</h5>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="card-body">
                                        <div class="table-responsive text-nowrap">
                                            <table class="table col-12">
                                                <thead>
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Dzień tygodnia</th>
                                                    <th>Od</th>
                                                    <th>Do</th>
                                                    <th>Ilość godzin</th>
                                                </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                @foreach($employees as $employee)
                                                    @foreach($employee['timesheet'] as $time)
                                                        <tr>
                                                            <td>
                                                                {{$time['date']}}
                                                            </td>
                                                            @php
                                                                $inputDate = $time['date'];
                                                                \Carbon\Carbon::setLocale('pl');
                                                                $carbonDate = \Carbon\Carbon::parse($inputDate);
                                                                $dayOfWeek = $carbonDate->format('l');
                                                                $days = ['Monday'    => 'Poniedziałek',
                                                                         'Tuesday'   => 'Wtorek',
                                                                         'Wednesday' => 'Środa',
                                                                         'Thursday'  => 'Czwartek',
                                                                         'Friday'    => 'Piątek',
                                                                         'Saturday'  => 'Sobota',
                                                                         'Sunday'    => 'Niedziela']
                                                            @endphp
                                                            <td>{{$days[$dayOfWeek]}}</td>
                                                            <td>
                                                                {{$time['hour_start']}}
                                                            </td>
                                                            <td> {{$time['hour_end']}}
                                                            </td>
                                                            <td>
                                                                {{$time['diff']}}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card">
                            <h5 class="card-header">Samochody do których jesteś przypisany</h5>
                            <div class="card-body">
                                <div class="table-responsive text-nowrap">
                                    <table class="table col-12">
                                        <thead>
                                        <tr>
                                            <th>Samochód</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                        @foreach($cars as $car)
                                            <tr>
                                                <td>
                                                    {{$car['mark']}} {{$car['model']}}
                                                </td>
                                                <td>
                                                    @if($car['available'] === 1)
                                                        <span class="badge rounded-pill bg-label-success me-1">Zwrócony -
                                                            {{ Carbon::parse($car['updated_at'])->format('Y-m-d H:i') }}
</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-label-warning me-1">W użyciu - od  {{ Carbon::parse($car['updated_at'])->format('Y-m-d H:i') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
