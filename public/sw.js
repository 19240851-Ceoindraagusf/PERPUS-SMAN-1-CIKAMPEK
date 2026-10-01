const CACHE_NAME = 'perpus-sman1-static-v2';
const STATIC_FILES = ['/', '/manifest.webmanifest', '/images/logo-perpus-sman-1-cikampek.jpeg'];

self.addEventListener('install', (event) => {
  event.waitUntil(caches.open(CACHE_NAME).then((cache) => cache.addAll(STATIC_FILES)));
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(caches.keys().then((keys) => Promise.all(keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key)))));
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  if (event.request.method !== 'GET' || event.request.destination === 'document') return;
  const url = new URL(event.request.url);
  // Search results, e-books, and other application routes must always use fresh data.
  if (url.origin !== self.location.origin || url.pathname === '/saran-pencarian' || url.pathname.startsWith('/ebook') || url.pathname.startsWith('/storage/')) return;
  const isStaticAsset = /\.(?:css|js|png|jpe?g|svg|webp|woff2?)$/i.test(url.pathname);
  if (!isStaticAsset) return;
  event.respondWith(caches.match(event.request).then((cached) => cached || fetch(event.request).then((response) => {
    if (response.ok) {
      const copy = response.clone(); caches.open(CACHE_NAME).then((cache) => cache.put(event.request, copy));
    }
    return response;
  })));
});
