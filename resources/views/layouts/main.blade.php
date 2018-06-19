<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CSV Importer</title>
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

</head>
<body>
<div id="app" class="min-h-screen flex flex-no-grow flex-wrap flex-col justify-between bg-grey-lighter">
    <div></div>
    <main>
        @yield('content')
    </main>
    <div></div>
</div>
<script src="{{ mix('/js/manifest.js') }}"></script>
<script src="{{ mix('/js/vendor.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
