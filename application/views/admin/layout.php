<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ Csrf::token() }}">
    <title>{{ $title }} | {{ $site_title ?? 'Pressli'}} </title>
    @isset($site_favicon)
        <link rel="icon" type="image/x-icon" href="{{ $site_favicon }}">
    @endisset
    <script>
        window.BASE = "{{ Url::base() }}";
    </script>
    @section('styles')
    	<link rel="stylesheet" href="{{Url::assets('admin/css/admin.css')}}">
    @endsection
</head>
<body> 
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h1 class="logo"><a href="{{Url::base()}}" target="_blank">Pressli</a></h1>
        </div>
        <!-- Sidebar Nav -->
        @section('sidebar-nav')
        	@include('admin/partials/sidebar-nav')
        @endsection

	</aside>
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->	
        @section('top-header')
        	@include('admin/partials/top-header')
        @endsection

        <!-- Main Content -->
		@yield('content')

    </div>

<!-- JS Scripts -->
@section('scripts')
	<script src="{{Url::assets('admin/js/admin.js')}}"></script>
@endsection
</body>
</html>
