# Fonts – Order App

Font aplikasi: definisi di `public/css/fonts.css`, file font local di sini (`public/fonts/`).

## Struktur

```
public/
├── css/
│   └── fonts.css          # @font-face + variabel (--font-heading, --font-body)
└── fonts/
    ├── README.md          # File ini
    └── akaya-telivigala/  # Heading (h1–h6)
            ├── AkayaTelivigala-Regular.ttf
            └── OFL.txt    # Lisensi (SIL Open Font License)
```

## Pemakaian

| Pemakaian | Font | Sumber |
|-----------|------|--------|
| **Heading** (h1–h6, .section-title, .font-heading) | Akaya Telivigala | Local: `fonts/akaya-telivigala/` |
| **Body & lainnya** (body, p, tombol, input, link, dll.) | Klee One | Google Fonts (di-load di layout) |

## Menambah font lokal

1. Buat folder di `public/fonts/<nama-font>/` (nama folder pakai kebab-case).
2. Taruh file `.ttf`/`.woff2` dan file lisensi (mis. OFL.txt) di dalamnya.
3. Tambah `@font-face` di `public/css/fonts.css` dengan path `/fonts/<nama-font>/...`.
4. Set variabel `:root` atau selector yang dipakai di `fonts.css` bila perlu.

## Lisensi

- **Akaya Telivigala**: SIL Open Font License (OFL). Lihat `akaya-telivigala/OFL.txt`.
- **Klee One**: Google Fonts (OFL). Di-load dari Google; tidak disimpan di repo.
