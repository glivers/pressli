<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}} - Pressli CMS</title>
    <link rel="stylesheet" href="{{Url::assets('admin/css/admin.css')}}">
</head>
<body class="auth-page">
    <div class="auth-container">
        <!-- Main Content -->
        @yield('content')

    </div>

    <!-- Auth JS Scripts -->
    @yield('scripts')
</body>
</html>
