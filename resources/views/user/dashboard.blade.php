@include('head')
@include('header')

<body class="bg-gray-100">

    <div class="flex flex-col md:flex-row">
        <div class="flex p-4 bg-white w-full md:w-60">
            <div class="grid grid-cols-1 gap-4 text-center justify-items-center w-full">
                @foreach ($collection as $item)
                    <a class="hover:text-red-600 text-2xl" href="{{ route($item[0]) }}">{{ $item[1] }}</a>
                @endforeach
            </div>
        </div>
    
        <div class="p-4 gap-3 xl:w-5/12 lg:w-4/6 md:w-full flex flex-col mx-auto px-5 bg-white my-5 drop-shadow-md">
            <strong class="text-lg">Personal information</strong>
            <h2>Username: {{ Auth::user()->name }}</h2>
            <h2>Email: {{ Auth::user()->email }}</h2>
            <h2>Phone number: {{ Auth::user()->phone }}</h2>
            <h2>Location: {{ Auth::user()->location }}</h2>
            <h2>MFA: 
                @component('components.switch', [
                    'id' => 'mfa_switch',
                ])
                @endcomponent
                {{-- @if (Auth::user()->mfa_enabled)
                    Enabled
                @else
                    Disabled
                @endif --}}
            </h2>
            <h2>Fidelity points: {{ Auth::user()->fidelity_points }}</h2>
            <h2>Credits: {{ Auth::user()->credit_points }}</h2>
        </div>
        <script src="/js/dashboard.js"></script>
    </div>
    
</body>
@include('footer')