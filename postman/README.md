# Paxel API - Postman Collection

## Import ke Postman

1. Buka Postman
2. Klik **Import** → pilih file `Paxel-API.postman_collection.json`
3. Collection **Paxel eCommerce API** akan muncul

## Konfigurasi

1. Klik collection **Paxel eCommerce API**
2. Buka tab **Variables**
3. Isi:
   - `api_key` — API Key dari Paxel
   - `api_secret` — API Secret dari Paxel
   - `base_url` — Sudah default `https://stage-commerce-api.paxel.co`

## Request yang Tersedia

### Rates
- **Get Rate - REGULAR** — Cek ongkir layanan REGULAR
- **Get Rate - NEXTDAY** — Cek ongkir layanan NEXTDAY

### Shipments
- **Create Shipment** — Buat pengiriman (generate resi). Signature dihitung otomatis via pre-request script.
- **Track Shipment** — Tracking pengiriman. Isi variable `airwaybill_code` dengan nomor resi sebelum kirim.

## Catatan

- **Create Shipment** memakai pre-request script untuk generate X-Paxel-Signature. Pastikan `api_secret` sudah diisi.
- Untuk **Track Shipment**, isi `airwaybill_code` di collection variables dengan nomor resi yang ingin dicek.
- Sesuaikan origin/destination di body request dengan data Anda.
