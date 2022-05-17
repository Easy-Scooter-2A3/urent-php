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
            @foreach ($products as $product)
            <tr productidParent class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input productid="{{ $product->id }}" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="{{$product->id}}-label" class="sr-only">checkbox</label>
                    </div>
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    {{ $product->name }}
                </th>
                <td class="px-6 py-4">
                    {{ $product->price }}
                </td>
                <td class="px-6 py-4">
                    {{ -1 }}
                </td>
                <td class="px-6 py-4">
                    {{ $product->description }}
                </td>
                <td class="px-6 py-4">
                    {{ $product->stock }}
                </td>
                <td class="px-6 py-4">
                    {{ -1 }}
                </td>
                <td class="px-6 py-4">
                    {{ $product->available ? 'Yes' : 'No' }}
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
        @component('components.button', [
            'text' => 'Edit',
            'type' => 'button',
            'id' => 'editBtn',
            'modal' => 'modal-edit',
        ])
        @endcomponent
    </div>
</div>

@include('modal-details')
@include('modal-creation-product')
@include('modal-edit-product')

<template id="modal-details-body-template">
    <div>
        <h2>ID : </h2>
        <h2>Name : </h2>
        <h2>Price : </h2>
        <h2>Description : </h2>
        <h2>Stock : </h2>
        <h2>Nb. Achats : </h2>
        <h2>Available : </h2>
    </div>
</template>

@csrf
<script src="/js/admin.products.js"></script>
