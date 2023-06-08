<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
{{--    <link rel="stylesheet" href="{{ mix('css/style.css') }}">--}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Products</title>
</head>
<body>
    <div class="mt-3 container">
        <div class="row">
            <ul class="nav mt-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('main') }}">Main</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('order') }}">Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contacts') }}">Contacts</a>
                </li>
            </ul>
        </div>
        @yield('content')
    </div>
</body>
</html>
