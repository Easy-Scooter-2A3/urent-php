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
            @foreach ($orders as $order)
            <tr orderidParent class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input orderid="{{ $order->id }}" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="{{$order->id}}-label" class="sr-only">checkbox</label>
                    </div>
                </td>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    {{ $order->status }}
                </th>
                <td class="px-6 py-4">
                    {{ $order->transporter }}
                </td>
                <td class="px-6 py-4">
                    {{ $order->total_price }}
                </td>
                <td class="px-6 py-4">
                    {{ $order->created_at }}
                </td>
                <td class="px-6 py-4">
                    {{ $order->delivery_date }}
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
            'text' => 'Download order',
            'type' => 'button',
            'id' => 'getOrdersBtn',
            'modal' => 'modal-details',
        ])
        @endcomponent
    </div>
</div>
@include('modal-details')

<template id="modal-details-body-template">
    <div>
        <h2>ID : </h2>
        <h2>Status : </h2>
        <h2>Lieu de livraison : </h2>
        <h2>Date de livraison : </h2>
        <h2>Transporteur : </h2>
        <h2>Tracking : </h2>
        <h2>Date de création : </h2>
        <h2>Date de dernière modification : </h2>
        <h2>Total : </h2>
        <h2>Moyen de paiment : </h2>
        <h2>Fidelity points : </h2>
        <h2>Recu : </h2>
        <h2>

        </h2>
    </div>
</template>

@csrf
<script src="/js/user.orders.js"></script>
