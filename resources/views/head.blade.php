<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>

    <!-- Material Design -->
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    {{-- <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


    <!-- Styles -->
    <link href="/css/tailwindcss.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">  

    {!! htmlScriptTagJsApi([
        'action' => 'homepage',
    ]) !!}

    <title>Document</title>
</head>