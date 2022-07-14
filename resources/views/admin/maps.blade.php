<div class="relative overflow-x-auto lg:w-full mx-10 my-10">
    <div class="w-full h-96" id="map">
    </div>

    <div class="w-full p-4 flex border shadow-lg">
        @component('components.inputfield', [
            'text' => 'Search',
            'icon' => 'search',
            'name' => 'search',
            'type' => 'search',
            'id' => 'searchField',
        ])
        @endcomponent
        <h2 class="p-4 font-bold"><span id="scootersAmount">X</span> scooters</h2>
    </div>
    {{-- <div class="gap-3 lg-5/6 md:w-full p-4 m-5 mx-auto flex items-center bg-white drop-shadow-md"> --}}
        {{-- @component('components.inputfield', [
            'text' => 'Search',
            'icon' => 'search',
            'name' => 'search',
            'type' => 'search',
            'id' => 'searchField',
        ])
        @endcomponent
        @component('components.button', [
            'text' => 'View details',
            'type' => 'button',
            'id' => 'viewDetailsBtn',
            'modal' => 'modal-details',
        ])
        @endcomponent
        @component('components.button', [
            'text' => 'Delete',
            'type' => 'button',
            'id' => 'deleteBtn',
        ])
        @endcomponent
        @component('components.button', [
            'text' => 'Create',
            'type' => 'button',
            'id' => 'createBtn',
            'modal' => 'modal-creation',
        ])
        @endcomponent
        @component('components.button', [
            'text' => 'Edit',
            'type' => 'button',
            'id' => 'editBtn',
            'modal' => 'modal-edit',
        ])
        @endcomponent --}}
    {{-- </div> --}}
</div>

@csrf
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="/js/admin.maps.js"></script>

{{-- <script async
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyATtyjZ7k1VD5NLIaJ-pKjcJ-QFoic_nh4&callback=initMap">
</script> --}}