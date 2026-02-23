/**
 * Service Worker - Rumah Bumbu & Ungkep PWA
 * Scope: /
 * Strategy: Network-first for navigation, cache-first for static assets
 */

const CACHE_NAME = 'rumah-bumbu-v1';

// Static assets to precache (optional - adjust if using Vite build paths)
const PRECACHE_URLS = [
  '/',
  '/manifest.json',
  '/images/rumah-bumbu-ungkep.png',
  '/css/fonts.css',
  '/favicon.ico'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(PRECACHE_URLS).catch(() => {
        // Ignore fail for optional precache (e.g. if path not found)
      });
    }).then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) => {
      return Promise.all(
        keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key))
      );
    }).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', (event) => {
  const { request } = event;
  const url = new URL(request.url);

  // Only GET, same origin (skip API, admin, etc.)
  if (request.method !== 'GET' || url.origin !== self.location.origin) {
    return;
  }

  // Skip admin panel
  if (url.pathname.startsWith('/admin')) {
    return;
  }

  // API and dynamic content: network only
  if (url.pathname.startsWith('/api/') || url.pathname.startsWith('/media/')) {
    return;
  }

  event.respondWith(
    caches.open(CACHE_NAME).then((cache) => {
      return fetch(request)
        .then((response) => {
          if (response && response.status === 200 && response.type === 'basic') {
            cache.put(request, response.clone());
          }
          return response;
        })
        .catch(() => cache.match(request).then((cached) => cached || offlineResponse(request)));
    })
  );
});

function offlineResponse(request) {
  if (request.mode === 'navigate') {
    return new Response(
      `<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Offline - Rumah Bumbu & Ungkep</title><style>body{font-family:system-ui;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;background:#f8f9fa;color:#333;text-align:center;padding:1rem;} .box{max-width:360px;} h1{color:#dc3545;} a{color:#dc3545;}</style></head><body><div class="box"><h1>Anda sedang offline</h1><p>Periksa koneksi internet lalu refresh halaman.</p><p><a href="/">Coba lagi</a></p></div></body></html>`,
      { headers: { 'Content-Type': 'text/html; charset=utf-8' } }
    );
  }
  return new Response('', { status: 503, statusText: 'Service Unavailable' });
}
