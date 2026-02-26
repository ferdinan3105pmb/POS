@include('partials.header')
<main id="main" class="main">
    @if($errors->any())
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'warning',
            title: "You don't have access",
        });
    </script>
    @endif
    @yield('content')
</main>