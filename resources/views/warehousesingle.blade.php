<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row">
                        <div class="col-8">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Dodaj pracownika do obiektu</h5>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="{{url('warehouse/add-employee')}}">
                                        @csrf {{ csrf_field() }}
                                        <input type="hidden" name="warehouse_id"
                                               value="{{$warehouse['id']}}"/>
                                        <div class="row mb-3">
                                            <div class="input-group">
                                                <select class="form-select" id="inputGroupSelect02" name="employee_id">
                                                    <option selected="">Choose...</option>
                                                    @foreach ($employees_to_select as $employee)
                                                        <option
                                                            value="{{$employee['id']}}">{{$employee['name']}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="row justify-content-center">
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                    Send
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">{{$warehouse['name']}}</h5>
                                    <div class="card-subtitle text-muted mb-3">Nazwa obiektu</div>
                                    <p class="card-text">
                                    <div class="demo-inline-spacing mt-3">
                                        <div class="list-group list-group-flush">
                                            <p class="list-group-item list-group-item-action waves-effect">Ilość
                                                pracowników : <b>{{count($employees)}}</b></p>
                                            <p class="list-group-item list-group-item-action waves-effect">Start
                                                projektu : <b>21-09-2023</b></p>
                                            <p class="list-group-item list-group-item-action waves-effect">Koniec
                                                projektu : <b>31-12-2023</b></p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card">
                            <h5 class="card-header">Pracownicy obiektu</h5>
                            <div class="table-responsive text-nowrap">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Imię i nazwisko</th>
                                        <th>Status</th>
                                        <th>Akcje</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                    @foreach($employees as $employee)
                                        <tr>
                                            <td>{{$employee['name']}}</td>
                                            <td><span class="badge rounded-pill bg-label-primary me-1">Pracuje</span>
                                            </td>
                                            <td>
                                                <i class="mdi mdi-trash-can text-danger me-3" onclick="remove({{$employee['id']}},{{$warehouse['id']}})"></i>
                                                <i class="mdi mdi-clock text-info me-3" id="{{$employee['id']}}"></i>
                                                <i class="mdi mdi-information text-success me-3" id="{{$employee['id']}}"></i>
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
    <script>
        function remove(employee, warehouse) {
            // Pobieramy wartość csrf-token z meta tagu
            var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            // Wyświetlamy alert z pytaniem
            var confirmation = window.confirm("Czy na pewno chcesz usunąć tego pracownika z obiektu?");

            // Sprawdzamy czy użytkownik potwierdził operację
            if (!confirmation) {
                return; // Anulujemy operację jeśli użytkownik nie potwierdził
            }

            // Tworzymy formularz
            var form = document.createElement("form");
            form.method = "POST";
            form.action = "/warehouse/remove-employee";

            // Dodajemy pole csrf do formularza
            var csrfInput = document.createElement("input");
            csrfInput.type = "hidden";
            csrfInput.name = "_token";
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);

            // Dodajemy pola employee i warehouse do formularza
            var employeeInput = document.createElement("input");
            employeeInput.type = "hidden";
            employeeInput.name = "employee_id";
            employeeInput.value = employee;
            form.appendChild(employeeInput);

            var warehouseInput = document.createElement("input");
            warehouseInput.type = "hidden";
            warehouseInput.name = "warehouse_id";
            warehouseInput.value = warehouse;
            form.appendChild(warehouseInput);

            // Dodajemy formularz do ciała dokumentu
            document.body.appendChild(form);

            // Wysyłamy formularz
            form.submit();

            // Opcjonalnie możemy usunąć formularz po wysłaniu
            document.body.removeChild(form);
        }


    </script>
</x-app-layout>
