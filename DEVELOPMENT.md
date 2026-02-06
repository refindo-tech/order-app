# Panduan Development – Order App (Rumah Bumbu & Ungkep)

Website pemesanan online dengan integrasi Paxel dan notifikasi WhatsApp.

---

## Requirements

- **PHP** 8.2+
- **Composer** 2.x
- **Node.js** 18+ dan **npm**
- **SQLite** (dev) atau **MySQL 8** / **MariaDB** (production)

---

## Setup Awal

### 1. Clone & dependency

```bash
composer install
cp .env.example .env
php artisan key:generate
```

### 2. Database

**SQLite (default untuk development):**

```bash
# Buat file database (jika belum ada)
# Windows:
New-Item -Path database\database.sqlite -ItemType File -Force

# Linux/macOS:
touch database/database.sqlite
```

Pastikan di `.env`:

```
DB_CONNECTION=sqlite
# DB_DATABASE=database/database.sqlite  # optional, default sudah benar
```

**MySQL (jika dipakai):**

Edit `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=order_app
DB_USERNAME=root
DB_PASSWORD=
```

Lalu:

```bash
php artisan migrate
```

### 3. Frontend (Vite)

```bash
npm install
npm run dev
```

Jalankan di terminal terpisah agar asset terus di-build.

### 4. Menjalankan aplikasi

**Opsi A – `artisan serve`**

```bash
php artisan serve
```

Buka: http://localhost:8000

**Opsi B – Laragon**

1. Pastikan folder project di `C:\laragon\www\order-app`
2. Virtual host: document root = `C:\laragon\www\order-app\public`
3. (Opsional) Buat `order-app.test` via Laragon
4. Set di `.env`: `APP_URL=http://order-app.test` atau `http://localhost`

---

## Struktur Project

```
app/
├── Http/Controllers/
│   ├── Admin/           # Controller panel admin
│   │   └── Controller.php
│   └── Controller.php   # Controller untuk customer/landing
├── Models/
├── Services/            # Paxel, WhatsApp, dll (Phase 4–5)
└── Providers/

config/                  # Konfigurasi
database/migrations/     # Migrasi
resources/views/         # Blade (customer & admin)
routes/
├── web.php              # Rute web
└── console.php

Business App Document/   # BRD, FSD, SRS, dev-roadmap
```

---

## Perintah Berguna

| Perintah | Keterangan |
|----------|------------|
| `php artisan migrate` | Jalankan migrasi |
| `php artisan migrate:fresh` | Ulang dari awal (hapus + migrate) |
| `php artisan make:model Nama -m` | Buat model + migrasi |
| `php artisan make:controller Admin/NamaController` | Buat controller Admin |
| `npm run dev` | Build Vite (development) |
| `npm run build` | Build Vite (production) |

---

## Environment (`.env`)

Variabel penting:

- `APP_NAME`, `APP_URL`, `APP_DEBUG`, `APP_KEY`
- `DB_*` – koneksi database
- `SESSION_DRIVER` – default `database`

Placeholder untuk fase berikutnya:

- **Phase 4 – Paxel:** `PAXEL_API_URL`, `PAXEL_API_KEY`, `PAXEL_API_SECRET`, `PAXEL_ORIGIN_*`
- **Phase 5 – WhatsApp:** `WHATSAPP_API_URL`, `WHATSAPP_API_KEY`

### Webhook Paxel

Untuk menerima update status dari Paxel, daftarkan URL webhook di dashboard Paxel:

```
https://yourdomain.com/api/paxel/webhook
```

---

## Roadmap

Mengacu pada `Business App Document/dev-roadmap.md`:

- **Phase 1:** Setup project, env, DB, auth Admin
- **Phase 2:** UI/UX, katalog, cart, checkout
- **Phase 3:** Manajemen produk & order, upload bukti pembayaran
- **Phase 4:** Integrasi Paxel (ongkir, create shipment, resi, webhook, tracking) ✅
- **Phase 5:** Notifikasi WhatsApp & tracking
- **Phase 6:** PWA
- **Phase 7–8:** Testing & deployment
