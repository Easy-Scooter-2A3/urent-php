<div class="relative overflow-x-auto lg:w-full mx-10 my-10">
    <table id="modal-main" class="w-full lg-5/6 text-sm text-left">
        <thead class="uppercase bg-white gap-3 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="p-4">
                    <div class="flex items-center">
                        <input id="checkbox-all-main" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 bpartnership-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:bpartnership-gray-600">
                        <label for="checkbox-all-main" class="sr-only">checkbox</label>
                    </div>
                </th>
                @foreach ($cols as $col)
                    <th scope="col" class="p-4">{{ $col }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($partnerships as $partnership)
            <tr partnershipidParent class="bg-white bpartnership-b dark:bg-gray-800 dark:bpartnership-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="w-4 p-4">
                    <div class="flex items-center">
                        <input partnershipid="{{ $partnership->id }}" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 bpartnership-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:bpartnership-gray-600">
                        <label for="{{$partnership->id}}-label" class="sr-only">checkbox</label>
                    </div>
                </td>
                <th  class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    {{ $partnership->name }}
                </th>
                <td class="px-6 py-4">
                    {{ $partnership->from_date }}
                </td>
                <td class="px-6 py-4">
                    {{ $partnership->to_date }}
                </td>
                <td class="px-6 py-4">
                    {{ $partnership->voucher }}
                </td>
                <td class="px-6 py-4">
                    {{ $partnership->max_people }}
                </td>
                <td class="px-6 py-4">
                    {{ $partnership->active }}
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
            'text' => 'Edit',
            'type' => 'button',
            'id' => 'editBtn',
            'modal' => 'modal-edit',
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

@include('modal-edit-partnerships')
@include('modal-creation-partnerships')

@csrf
<script src="/js/admin.partnerships.js"></script>
