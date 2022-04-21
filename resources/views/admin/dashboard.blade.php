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
        <div class="relative overflow-x-auto lg:w-full mx-10 my-10">
            <table class="w-full lg-5/6 text-sm text-left">
                <thead class="uppercase bg-white gap-3 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        @foreach ($cols as $col)
                            <th scope="col" class="p-4">{{ $col }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr userId class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input userid="{{ $user->id }}" id="{{$user->id}}" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="{{$user->id}}-label" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $user->email_verified_at }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->created_at }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->updated_at }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $user->id }}
                        </td>
                        <td class="px-6 py-4">
                            @if ($user->isAdmin == 1)
                                <i class="material-icons mdc-text-field__icon mdc-text-field__icon--leading text-green-500">done</i>
                            @else
                                <i class="material-icons mdc-text-fieldfield__icon mdc-text-field__icon--leading text-red-600">clear</i>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="gap-3 lg-5/6 md:w-full m-5 mx-auto flex bg-white drop-shadow-md">
                    @component('components.inputfield', [
                        'text' => 'Search',
                        'icon' => 'search',
                        'name' => 'search',
                        'type' => 'search',
                        'id' => 'searchList',
                    ])
                    @endcomponent
                <button id="viewDetailsBtn" class="mdc-button mdc-button--raised mt-4 mb-5 ml-5">
                    <span class="mdc-button__label">View details</span>
                </button>
                <button class="mdc-button mdc-button--raised mt-4 mb-5 ml-5">
                    <span class="mdc-button__label">Change Admin</span>
                </button>
            </div>
        </div>
    <script src="/js/dashboardAdmin.js"></script>

    </div>

    {{-- @endforeach  --}}
    {{-- <form id="mfa_form" hidden action="/user/two-factor-authentication" method="post"></form> --}}
</body>
@include('footer')
