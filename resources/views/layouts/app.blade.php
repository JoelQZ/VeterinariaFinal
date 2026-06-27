<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VeterinariaLife</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, #1e2a3a 0%, #0f1724 100%);
            box-shadow: 4px 0 12px rgba(0, 0, 0, 0.08);
            z-index: 1000;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        .sidebar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: -0.5px;
            color: #ffffff;
            text-decoration: none;
        }

        .sidebar-link {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-weight: 500;
            padding: 10px 16px;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .sidebar-link:hover {
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(3px);
        }

        .sidebar-link.active {
            color: #ffffff;
            background: #0d6efd;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
        }

        h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: #1e2a3a;
            margin-bottom: 1.2rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid #0d6efd;
            display: inline-block;
        }

        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .btn {
            border-radius: 10px;
            font-weight: 500;
            padding: 8px 20px;
            transition: all 0.2s ease;
        }

        .btn-sm {
            border-radius: 8px;
            padding: 5px 12px;
        }

        .btn-primary { background: #0d6efd; border: none; }
        .btn-primary:hover { background: #0b5ed7; transform: translateY(-1px); }
        .btn-success { background: #198754; border: none; }
        .btn-success:hover { background: #157347; transform: translateY(-1px); }
        .btn-warning { background: #ffc107; border: none; color: #1e2a3a; }
        .btn-warning:hover { background: #e0a800; transform: translateY(-1px); }
        .btn-danger { background: #dc3545; border: none; }
        .btn-danger:hover { background: #bb2d3b; transform: translateY(-1px); }

        .table { border-radius: 12px; overflow: hidden; }
        .table thead th {
            background: #f8f9fc;
            color: #1e2a3a;
            font-weight: 600;
            border-bottom: 2px solid #e9ecef;
            padding: 14px 12px;
        }
        .table tbody tr:hover {
            background: #f8f9ff;
            transition: background 0.2s ease;
        }

        .form-control {
            border-radius: 10px;
            border: 1px solid #dee2e6;
            padding: 10px 14px;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
        }
        .form-label { font-weight: 600; color: #2c3e50; margin-bottom: 6px; }
        
        .foto-fija {
            width: 50px !important;
            height: 50px !important;
            object-fit: cover !important;
            border-radius: 50% !important;
        }
    </style>
</head>
<body>
    <div class="sidebar d-flex flex-column justify-content-between p-3 text-white">
        <div>
            <div class="py-3 px-2 mb-4 border-bottom border-secondary border-opacity-25 text-center">
                <a class="sidebar-brand" href="/dashboard">
                    <i class="bi bi-heart-pulse-fill text-danger me-2"></i>Veterinaria<span class="text-info">Life</span>
                </a>
            </div>
            <div class="nav flex-column gap-1">
                <a href="/dashboard" class="sidebar-link d-flex align-items-center gap-3 {{ Request::is('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 fs-5"></i> Panel de Control
                </a>
                
                <a href="/pets" class="sidebar-link d-flex align-items-center gap-3 {{ Request::is('pets*') ? 'active' : '' }}">
                    <i class="bi bi-gitlab fs-5"></i> Mascotas
                </a>
                <a href="/owners" class="sidebar-link d-flex align-items-center gap-3 {{ Request::is('owners*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill fs-5"></i> Dueños
                </a>
                <a href="/appointments" class="sidebar-link d-flex align-items-center gap-3 {{ Request::is('appointments*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-event fs-5"></i> Citas
                </a>
                <a href="/products" class="sidebar-link d-flex align-items-center gap-3 {{ Request::is('products*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam fs-5"></i> Inventario
                </a>
                <a href="/sales" class="sidebar-link d-flex align-items-center gap-3 {{ Request::is('sales*') ? 'active' : '' }}">
                    <i class="bi bi-cash-coin fs-5"></i> Ventas / Caja
                </a>
            </div>
        </div>
        <div class="border-top border-secondary border-opacity-25 pt-3 px-2">
            <div class="small text-white-50 mb-3 text-truncate">
                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-box-arrow-left"></i> Salir
                </button>
            </form>
        </div>
    </div>
    <div class="main-content">
        <div class="container py-4">
            @if(session('Exito'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>¡Logrado!:</strong> {{ session('Exito') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error:</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>