@include('head')
@include('header')

<body class="bg-gray-100">

    <div class="flex flex-col md:flex-row">
        <div class=" p-4 bg-white w-full md:w-60">
            <div class="grid grid-cols-1 gap-4 text-center justify-items-center w-full">
                @foreach ($collection as $item)
                    <a class="hover:text-red-600 text-2xl" href="{{ route($item[0]) }}">{{ $item[1] }}</a>
                @endforeach
            </div>
        </div>
                    
        <div class="flex flex-col w-full p-4">
            <table>
                <thead class="justify-around gap-3 lg-5/6 md:w-full m-5 mx-auto bg-white drop-shadow-md">
                    <tr>
                        <th><input type="checkbox" style="margin: 7px;"></th>
                        <th colspan="2">Status</th>
                        <th colspan="2">Name</th>
                        <th colspan="2">Date</th>
                        <th colspan="2">Dern. Connection</th>
                        <th colspan="2">ID</th>
                        <th colspan="2">Admin</th>
                    </tr>
                </thead>                
                <tbody class="justify-around gap-3 lg md:w-full bg-white drop-shadow-md">
                    @foreach ($users as $user)
                    <tr class="">
                        <td ><input type="checkbox" style="margin: 7px;"></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>{{ $user->id }}</td>
                        <td>
                            @if ($user->isAdmin == 1)
                                <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-green-500">done</i>
                            @else
                                <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-red-600">clear</i>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- @endforeach  --}}
    {{-- <form id="mfa_form" hidden action="/user/two-factor-authentication" method="post"></form> --}}
    
</body>
@include('footer')
