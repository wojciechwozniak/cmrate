<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="table-responsive text-nowrap">
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Samochód</th>
                                        <th>Ostatni użytkownik</th>
                                        <th>Przebieg</th>
                                        <th>Dostępność</th>
                                        <th>Akcje</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                    @foreach ($cars as $car)
                                        <tr>
                                            <td>
                                                <i class="mdi mdi-car mdi-20px me-3"></i><span
                                                    class="fw-medium">{{$car['mark']}} {{$car['model']}}</span>
                                            </td>
                                            <td>{{$car['user']['name']}}</td>
                                            <td>
                                                {{$car['mileage']}} km
                                            </td>
                                            <td>@if($car['available'] === 1)
                                                    <span
                                                        class="badge rounded-pill bg-label-success me-1">Dostępny</span>
                                                @else
                                                    <span class="badge rounded-pill bg-label-danger me-1">Zajęty</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($car['available'] === 1)
                                                    <button type="button" id="reserve" data-car="{{$car['id']}}"
                                                            class="btn btn-success waves-effect waves-light">Zarezerwuj
                                                    </button>
                                                @else
                                                    @if ($car['user_id'] === Auth::user()->id || Auth::user()->role === 'admin')
                                                        <button type="button" id="return" data-car="{{$car['id']}}"
                                                                class="btn btn-primary waves-effect waves-light"
                                                                >Zwróć
                                                        </button>
                                                    @else
                                                        <button type="button"
                                                                id="return"
                                                                data-car="{{$car['id']}}"
                                                                class="btn btn-success waves-effect waves-light"
                                                                disabled>Zwróć
                                                        </button>
                                                    @endif
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
    <!-- Dodaj ten kod w sekcji head lub przed zamknięciem tagu body -->
    <script>
        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

        document.addEventListener('DOMContentLoaded', function () {
            // Pobierz przyciski
            var reserveButton = document.getElementById('reserve');
            var returnButton = document.getElementById('return');

            // Dodaj obsługę zdarzenia dla przycisku "Zarezerwuj"
            reserveButton.addEventListener('click', function () {
                // Stwórz formularz
                var carId = reserveButton.getAttribute('data-car');

                var form = document.createElement('form');
                form.action = 'cars/change';
                form.method = 'POST';

                var csrfTokenInput = document.createElement('input');
                csrfTokenInput.type = 'hidden';
                csrfTokenInput.name = '_token';
                csrfTokenInput.value = csrfToken;
                form.appendChild(csrfTokenInput);

                // Dodaj pole "user_id"
                var userIdInput = document.createElement('input');
                userIdInput.type = 'hidden';
                userIdInput.name = 'user_id';
                userIdInput.value = {{Auth::user()->id}}; // Tutaj ustaw odpowiednią wartość user_id
                form.appendChild(userIdInput);

                var carIdInput = document.createElement('input');
                carIdInput.type = 'hidden';
                carIdInput.name = 'car_id';
                carIdInput.value = carId;
                form.appendChild(carIdInput);

                // Dodaj formularz do dokumentu
                document.body.appendChild(form);

                // Wyślij formularz
                form.submit();
            });

            // Dodaj obsługę zdarzenia dla przycisku "Zwróć"
            returnButton.addEventListener('click', function () {
                // Poproś użytkownika o podanie wartości licznika
                var odometerValue = prompt('Podaj wartość licznika:');

                var carId = returnButton.getAttribute('data-car');

                // Sprawdź, czy użytkownik podał wartość
                if (odometerValue !== null) {
                    // Stwórz formularz
                    var form = document.createElement('form');
                    form.action = 'cars/change';
                    form.method = 'POST';

                    var csrfTokenInput = document.createElement('input');
                    csrfTokenInput.type = 'hidden';
                    csrfTokenInput.name = '_token';
                    csrfTokenInput.value = csrfToken;
                    form.appendChild(csrfTokenInput);

                    var userIdInput = document.createElement('input');
                    userIdInput.type = 'hidden';
                    userIdInput.name = 'user_id';
                    userIdInput.value = {{Auth::user()->id}}; // Tutaj ustaw odpowiednią wartość user_id
                    form.appendChild(userIdInput);

                    // Dodaj pole "odometer_value"
                    var odometerValueInput = document.createElement('input');
                    odometerValueInput.type = 'hidden';
                    odometerValueInput.name = 'odometer_value';
                    odometerValueInput.value = odometerValue;
                    form.appendChild(odometerValueInput);

                    var carIdInput = document.createElement('input');
                    carIdInput.type = 'hidden';
                    carIdInput.name = 'car_id';
                    carIdInput.value = carId;
                    form.appendChild(carIdInput);

                    // Dodaj formularz do dokumentu
                    document.body.appendChild(form);

                    // Wyślij formularz
                    form.submit();
                }
            });
        });
    </script>

</x-app-layout>
