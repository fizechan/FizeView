<html lang="ch">
<head>
    <title>App Name - @yield('title')</title>
</head>
<body>
@section('sidebar')
    This is the master sidebar.
@endsection

<div class="container">
    @yield('content')
</div>
</body>
</html>