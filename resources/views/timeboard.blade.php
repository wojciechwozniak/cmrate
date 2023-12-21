<x-app-layout>
    <style>
        th:first-child, td:first-child {
            position: sticky;
            left: 0px;
            background-color: white;
        }

        [type=time] {
            padding: 0px;
            border: none;
        }

        input[type="time"]::-webkit-calendar-picker-indicator {
            background: none;
            position: relative;
            width: 0px !important;
        }

        .table > :not(caption) > * > * {
            padding: 0.6rem 0.5rem;
        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row">
                        <div class="card">
                            <div class="row">
                                <div class="col-4"><h5 class="card-header">Karta czasu pracy</h5>
                                </div>
                                <div class="col-4 justify-content-center py-3">
                                    {{--                                    <div class="input-group">--}}
                                    {{--                                        <select class="form-select" id="inputGroupSelect02" name="warehouse_id">--}}
                                    {{--                                            <option>Budynek 1</option>--}}
                                    {{--                                            <option>Budynek 2</option>--}}
                                    {{--                                            <option>Budynek 3</option>--}}
                                    {{--                                            <option>Budynek 4</option>--}}
                                    {{--                                        </select>--}}
                                    {{--                                    </div>--}}
                                </div>
                                <div class="col-4 flex py-3 justify-content-end">
                                    <button type="button" class="btn btn-success" onclick="sendPostRequest()">Zapisz
                                        zmiany
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Pracownik</th>
                                        @foreach($dates as $key => $date)
                                            <th>
                                                {{$date[0]}} <br/>
                                                <small>{{$date[1]}}</small>
                                            </th>
                                        @endforeach

                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td>{{$employee['name']}}</td>
                                            @foreach($dates as $key => $date)
                                                @php
                                                    $searchDate = $date[1];
                                                    $index = array_search($date[1], array_column($employee['timesheet']->toArray(), 'date'));
                                                @endphp
                                                <td>
                                                    <input type="time" name="hour_start"
                                                           employee-data="{{$employee['id']}}"
                                                           date-data="{{$date[1]}}"
                                                           @if ($index !== false)
                                                           value={{$employee['timesheet'][$index]['hour_start']}}
                                                           @endif
                                                    >
                                                    <input type="time" name="hour_end"
                                                           employee-data="{{$employee['id']}}"
                                                           date-data="{{$date[1]}}"
                                                           @if ($index !== false)
                                                           value={{$employee['timesheet'][$index]['hour_end']}}
                                                        @endif>
                                                </td>
                                            @endforeach

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


    <script>
        // Inicjalizuj pustą tablicę wynikową
        let resultArray = [];

        // Pobierz wszystkie pola czasu
        const timeInputs = document.querySelectorAll('input[type="time"]');

        // Dodaj nasłuchiwanie zdarzenia zmiany wartości do każdego pola czasu
        timeInputs.forEach(timeInput => {
            timeInput.addEventListener('change', handleInputChange);
        });

        // Funkcja obsługująca zmianę wartości
        function handleInputChange(event) {
            const input = event.target;

            // Pobierz wartości z aktualnego pola czasu
            const inputValue = input.value;

            // Pobierz dodatkowe dane z atrybutów data
            const employeeId = input.getAttribute('employee-data');
            const dateData = input.getAttribute('date-data');

            // Zidentyfikuj typ pola na podstawie nazwy
            const inputType = input.name.includes('start') ? 'hourStart' : 'hourEnd';

            // Sprawdź, czy istnieje już wpis z danymi "employeeId" i "dateData" w tablicy
            const existingIndex = resultArray.findIndex(item => item.employeeId === employeeId && item.dateData === dateData);

            if (existingIndex !== -1) {
                // Zaktualizuj wartość odpowiedniego pola, jeśli wpis istnieje
                resultArray[existingIndex][inputType] = inputValue;
            } else {
                // Dodaj nowy wpis do tablicy
                const dataArray = {
                    hourStart: "",
                    hourEnd: "",
                    employeeId: employeeId,
                    dateData: dateData,
                    userSign: {{Auth::user()->id}}
                };

                // Ustaw wartość odpowiedniego pola
                dataArray[inputType] = inputValue;

                resultArray.push(dataArray);
            }

            // Wyświetl wynikową tablicę w konsoli (do testów)
            console.log(resultArray);
        }

        function sendPostRequest() {
            const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

            fetch('/timeboard/change', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(resultArray),
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    // Opcjonalnie: zresetuj tablicę po udanej wysyłce
                    resultArray = [];
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }
    </script>
</x-app-layout>
