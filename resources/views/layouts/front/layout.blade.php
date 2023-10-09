<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layouts.front.head')
    <title>@yield('title')</title>
    @stack('head')
    <link rel="icon" href="https://ikonicsolution.com/assets/img/favicon.png" type="image/png" sizes="16x16">


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</head>
<body>
@include('layouts.front.nav')
@if (session('success'))
<script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    Toast.fire({
        icon: 'success',
        title: '{{ session('success') }}'
    });
</script>
@endif
@if ($errors->any())
<script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    Toast.fire({
        icon: 'error',
        title: '{{ $errors->first() }}'
    });
</script>
@endif


@yield('content')
@include('layouts.front.footer')
</body>
</html>
