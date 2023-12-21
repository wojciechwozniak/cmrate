<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="card">

                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Pracownik</th>
                                    <th>Stanowisko</th>
                                    <th>Adres email</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{$user['name']}}</td>
                                        <td>
                                            {{$user['position']}}
                                        </td>
                                        <td><a href="mailto:{{$user['email']}}">{{$user['email']}}</a></td>

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
</x-app-layout>
