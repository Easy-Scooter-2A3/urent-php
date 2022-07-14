

<link href="{{ public_path('css/tailwindcss.css') }}" rel="stylesheet">
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-3/5 bg-white shadow-lg">
        <div class="flex justify-between p-4">
            <div>
                <h1 class="text-3xl italic font-extrabold tracking-widest">Urent</h1>
                <img width="250" height="250" src="/img/logo4.png" alt="logo">
            </div>
           
        </div>
        <div class="w-full h-0.5 bg-indigo-500"></div>
        <div class="flex justify-between p-4">
            <div>
                <h6 class="font-bold">Date du paiment : <span class="text-sm font-medium"> {{$order->created_at}}</span></h6>
            </div>
            <div class="w-1/2">
                <address class="text-sm">
                    <p>Délivré à : {{Auth::user()->name}}</p>
                    <p>Email : {{Auth::user()->email}}</p>
                    <p>Adresse: {{Auth::user()->location}}</p>
                    <p>N. téléphone : {{Auth::user()->phone}}</p>
                </address>
            </div>
        </div>
        <div class="flex justify-center p-4">
            <div class="border-b border-gray-200 shadow">
                <table class="">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-xs text-gray-500 ">
                                #
                            </th>
                            <th class="px-4 py-2 text-xs text-gray-500 ">
                                Nom du produit :
                            </th>
                            <th class="px-4 py-2 text-xs text-gray-500 ">
                                Prix : 
                            </th>
                            <th class="px-4 py-2 text-xs text-gray-500 ">
                                Total : 
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="whitespace-nowrap">
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{$product->quantity}}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{$product->name}} 
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{$product->price}}
                            </td>
                            <td class="px-6 py-4">
                                {{$order->total_discount}}
                            </td>
                            <td class="px-6 py-4">
                                {{$order->total_tax}}
                            </td>
                            <td class="px-6 py-4">
                                <div>Carte de crédit</div>
                            </td>
                            <td class="px-6 py-4">
                                {{ floatval(($order->total_price + $order->total_tax) - $order->total_discount / 10 - 20 )}} €
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex justify-between p-4">
            <div class="p-4">
                <h3>Signature :</h3>
            </div>
        </div>
        <div class="w-full h-0.5 bg-indigo-500"></div>

    </div>
</div>