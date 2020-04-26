<!DOCTYPE html>
<html lang="en" class="has-aside-left has-aside-mobile-transition has-navbar-fixed-top has-aside-expanded">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MixPlay</title>
    <link rel="stylesheet" href="{{ mix('assets/admin/css/app.css') }}">
</head>
<body>
    <div id="app">
        <router-view></router-view>
    </div>

    <script src="{{ mix('assets/admin/js/app.js') }}"></script>
</body>
</html>
