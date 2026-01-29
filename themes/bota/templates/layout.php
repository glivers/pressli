<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Seattle-based SaaS SEO marketing agency helping businesses grow through strategic search engine optimization.">
    <title> {{ isset($post) ? $post['title'] . ' | ' . $site['name'] : $site['name'] }}</title>
    @section('styles')
        <link rel="stylesheet" href="{{ Url::assets('themes/bota/css/styles.css')}}">
    @endsection
</head>
<body>
    <!-- Header / Navigation -->
    @include('bota/templates/partials/header')

    <!-- Main Content -->
    @yield('main-content')

    <!-- Call to Action -->
    @include('bota/templates/partials/cta')

    <!-- Footer -->
    @include('bota/templates/partials/footer')

    <!-- JS Scripts -->
    @section('scripts')
        <script src="{{ Url::assets('themes/bota/js/main.js')}}"></script>
    @endsection
</body>
</html>
