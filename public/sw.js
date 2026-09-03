const CACHE_NAME = 'lpk-sji-pwa-v1';
const PRECACHE_ASSETS = [
    '/',
    '/manifest.json',
    '/css/style.css',
    '/js/app.js',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-512x512.png',
    '/images/og-share-banner.jpg',
    '/brosur',
    '/simulasi-ujian',
    '/sebaran-alumni'
];

// Install Event: Pre-cache critical core shell
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(PRECACHE_ASSETS).catch((err) => {
                console.warn('PWA Precache partial fail:', err);
            });
        }).then(() => self.skipWaiting())
    );
});

// Activate Event: Clear obsolete old caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((name) => {
                    if (name !== CACHE_NAME) {
                        return caches.delete(name);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch Event: Network-First with Cache Fallback strategy
self.addEventListener('fetch', (event) => {
    const request = event.request;

    // Ignore non-GET, chrome-extension, and API/Admin routes
    if (request.method !== 'GET' || !request.url.startsWith('http')) return;
    if (request.url.includes('/admin') || request.url.includes('/api/realtime-sync')) return;

    event.respondWith(
        fetch(request)
            .then((networkResponse) => {
                if (networkResponse && networkResponse.status === 200) {
                    const responseClone = networkResponse.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(request, responseClone);
                    });
                }
                return networkResponse;
            })
            .catch(() => {
                // If network fails (offline), try cache
                return caches.match(request).then((cachedResponse) => {
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    // Return home cache if navigates page offline
                    if (request.mode === 'navigate') {
                        return caches.match('/');
                    }
                });
            })
    );
});
