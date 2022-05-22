@include('head')
@include('header')

<body class="bg-gray-100">

    <div class="flex flex-col md:flex-row">
        @include('collections')

        @include( $view )
    </div>

</body>
<script src="/js/dialog.js"></script>
