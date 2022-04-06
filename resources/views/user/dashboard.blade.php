@include('head')
@include('header')

<body class="bg-gray-100">

    <div class="flex flex-col md:flex-row">
        <div class="flex p-4 bg-white w-full md:w-1/12">
            <ul class="text-xl text-center">
                <a class="hover:text-red-600" href="{{ route('dashboard') }}">Account</a>
                <a class="hover:text-red-600" href="{{ route('dashboard') }}">History</a>
                <a class="hover:text-red-600" href="{{ route('dashboard') }}">Fidelity</a>
                <a class="hover:text-red-600" href="{{ route('dashboard') }}">Invoices</a>
                <a class="hover:text-red-600" href="{{ route('dashboard') }}">Statistics</a>
                <a class="hover:text-red-600" href="{{ route('dashboard') }}">Weather</a>
                <a class="hover:text-red-600" href="{{ route('dashboard') }}">Packages</a>
                <a class="hover:text-red-600" href="{{ route('dashboard') }}">Travels</a>
            </ul>
        </div>
    
        <div class="xl:w-5/12 lg:w-4/6 md:w-full flex flex-col sm:flex-row justify-between mx-auto px-5 bg-white my-5 drop-shadow-md">
        gros dashboard
        </div>
    </div>
    
</body>
@include('footer')