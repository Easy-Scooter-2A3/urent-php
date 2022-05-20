<div>
    <h1>Destinaraire : {{Auth::user()->name}}</h1>
    <div class="flex col">
        <p>Email : {{Auth::user()->email}}</p>
        <p>Adresse: {{Auth::user()->location}}</p>
        <p>N. téléphone : {{Auth::user()->phone}}</p>
        <p>Order id : {{$order->id}}</p>
    </div>
</div>
<div>
    <h2>Commandé le : {{$order->created_at}}</h2>
    <p>Délivré à : {{$order->delivery_place}}</p>
    <p>Transporteur : {{$order->transporter}}</p>
    <p>Produit : {{$product->name}}</p>
    <p>Id : {{$product->id}}</p>
    <p>Prix : {{$product->price}}</p>
    <p>Quantity : {{$product->quantity}}</p>
    
</div>