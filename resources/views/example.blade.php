<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Example</title>
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">



</head>
<script>
    window.Laravel = {
        csrfToken: "{{ csrf_token() }}"
    }



</script>
<body>
<div id="app"></div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>