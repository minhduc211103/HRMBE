<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @stack('css')
    <style>
        /* CSS cho Sidebar Active state */
        .nav-link.active {
            background: linear-gradient(45deg, #4e73df, #224abe);
            color: white !important;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
        }
        /* CSS cho Sidebar thường */
        .nav-link:not(.active) {
            color: #333;
        }
        .nav-link:not(.active):hover {
            background-color: #f8f9fa;
            color: #4e73df !important;
            transform: translateX(5px);
            transition: all 0.3s;
        }
    </style>
</head>
<body>
    <x-layouts.admin.sidebar/>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('js')

</body>
</html>
