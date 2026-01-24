<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - {{ config('app.name') }}</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }
        .header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 0.875rem;
        }
        .btn-danger {
            background-color: #ef4444;
            color: white;
        }
        .btn-danger:hover {
            background-color: #dc2626;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .card h3 {
            margin: 0 0 1rem 0;
            color: #374151;
        }
        .card p {
            color: #6b7280;
            margin: 0;
        }
        .welcome {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            text-align: center;
            margin-bottom: 2rem;
        }
        .welcome h1 {
            margin: 0;
            font-size: 2rem;
        }
        .welcome p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
        }
    </style>
</head>
<body style="background-color: #f9fafb; min-height: 100vh;">
    <div class="header">
        <div class="container">
            <div class="header-content">
                <h2 style="margin: 0; color: #374151;">Admin Panel</h2>
                <div>
                    <span style="margin-right: 1rem; color: #6b7280;">
                        Welcome, {{ Auth::user()->name }}
                    </span>
                    <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card welcome">
            <h1>🎉 Setup Authentication Berhasil!</h1>
            <p>Selamat datang di Admin Panel Order App - Rumah Bumbu & Ungkep</p>
        </div>

        <div class="dashboard-grid">
            <div class="card">
                <h3>📦 Manajemen Produk</h3>
                <p>Kelola katalog produk bumbu dan ungkep</p>
                <p><small><em>Akan tersedia di Phase 3</em></small></p>
            </div>

            <div class="card">
                <h3>📋 Manajemen Order</h3>
                <p>Kelola pesanan dan verifikasi pembayaran</p>
                <p><small><em>Akan tersedia di Phase 3</em></small></p>
            </div>

            <div class="card">
                <h3>🚚 Integrasi Paxel</h3>
                <p>Kelola pengiriman dan tracking</p>
                <p><small><em>Akan tersedia di Phase 4</em></small></p>
            </div>

            <div class="card">
                <h3>💬 Notifikasi WhatsApp</h3>
                <p>Setting notifikasi otomatis</p>
                <p><small><em>Akan tersedia di Phase 5</em></small></p>
            </div>
        </div>

        <div class="card">
            <h3>📊 Status Development</h3>
            <div style="margin-top: 1rem;">
                <div style="margin-bottom: 0.5rem;">
                    <strong>✅ Phase 1:</strong> Project Setup & Foundation <span style="color: #10b981;">(Complete)</span>
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <strong>⏳ Phase 2:</strong> UI/UX & Frontend Core <span style="color: #f59e0b;">(Next)</span>
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <strong>⏳ Phase 3:</strong> Backend Core & Order Management
                </div>
                <div style="margin-bottom: 0.5rem;">
                    <strong>⏳ Phase 4:</strong> Integrasi Paxel API
                </div>
                <div>
                    <strong>⏳ Phase 5:</strong> Notifikasi WhatsApp & Tracking
                </div>
            </div>
        </div>
    </div>
</body>
</html>