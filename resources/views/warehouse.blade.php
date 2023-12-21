<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row">
                        @foreach($warehouses as $warehouse)
                            <div class="col-md-4 mb-2">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <div class="tab-content p-0">
                                            <div class="tab-pane fade active show" id="navs-pills-tab-home-{{$warehouse['id']}}"
                                                 role="tabpanel">
                                                <h5 class="card-title">{{$warehouse['name']}}</h5>
                                                <p class="card-text">
                                                    Dodatkowe informacje o obiekcie
                                                </p>
                                                <a href="/warehouse/{{$warehouse['id']}}"
                                                   class="btn btn-primary waves-effect waves-light">Szczegóły obiektu</a>
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
    </div>
</x-app-layout>
