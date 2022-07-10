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
            @foreach ($scooters as $scooter)
            <tr scooteridParent class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input scooterid="{{ $scooter->id }}" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="{{$scooter->id}}-label" class="sr-only">checkbox</label>
                    </div>
                </td>
                <th  class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    {{ $scooter->status }}
                </th>
                <td class="px-6 py-4">
                    {{ $scooter->created_at }}
                </td>
                <td class="px-6 py-4">
                    {{ $scooter->date_last_maintenance }}
                </td>
                <td class="px-6 py-4">
                    {{ $scooter->model }}
                </td>
                <td class="px-6 py-4">
                    {{ $scooter->id }}
                </td>
                <td class="px-6 py-4">
                    {{ $scooter->uuid }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="gap-3 lg-5/6 md:w-full p-4 m-5 mx-auto flex items-center bg-white drop-shadow-md">
        @component('components.inputfield', [
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
    </div>
</div>

@include('modal-details')
@include('modal-creation-scooters')

<template id="modal-details-body-template">
    <div>
        <h2>ID : </h2>
        <h2>Status : </h2>
        <h2>Model : </h2>
        <h2>Date de création : </h2>
        <h2>Date de dernière modification : </h2>
        <h2>Longitude : </h2>
        <h2>Latitude : </h2>
        <h2>UUID : </h2>
    </div>
</template>

@csrf
<script src="/js/admin.scooters.js"></script>
