<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ mix('css/style.css') }}">
    <title>Products</title>
</head>
<body>
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('main') }}">Main</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('products') }}">Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('contacts') }}">Contacts</a>
        </li>
    </ul>
    <div>
        @yield('content')
    </div>
</body>
</html>
