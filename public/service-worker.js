const CACHE_NAME = 'praxisfit-cache-v2';

// Use relative paths (without leading slash) so it functions seamlessly in XAMPP sub-directories
const STATIC_ASSETS = [
    './',
    'index.html',
    'login.html',
    'register.html',
    'calculator.html',
    'equipments.html',
    'profile.html',
    'admin.html',
    'assets/css/style.css',
    'assets/js/theme.js',
    'assets/js/api.js',
    'assets/js/auth.js',
    'assets/js/dashboard.js',
    'assets/js/calculator.js',
    'assets/js/equipments.js',
    'assets/js/profile.js',
    'assets/js/register.js',
    'assets/js/admin.js',
    'assets/js/pwa.js',
    'manifest.json'
];

// 1. Install Event: Precache Core Static Assets
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(async (cache) => {
            console.log('⚡ [Service Worker] Pre-caching Core Static Assets...');
            // Fetch and cache individually to prevent a single missing file from breaking the entire installation
            for (const asset of STATIC_ASSETS) {
                try {
                    await cache.add(asset);
                } catch (error) {
                    console.warn(`⚠️ [Service Worker] Could not cache asset during install: ${asset}`, error);
                }
            }
        })
    );
    // Force the waiting service worker to become active immediately
    self.skipWaiting();
});

// 2. Activate Event: Cleanup Old Cache Versions
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        console.log('🧹 [Service Worker] Purging obsolete cache:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
    // Claim control immediately over all open clients/tabs without reloading
    self.clients.claim();
});

// 3. Fetch Event: Stale-While-Revalidate Strategy for UI Assets
self.addEventListener('fetch', (event) => {
    const { request } = event;

    // Ignore non-GET requests and external API endpoints (e.g. Laravel API running on port 8000)
    if (request.method !== 'GET' || request.url.includes('/api/')) {
        return;
    }

    // Only intercept HTTP/HTTPS schemes (ignore chrome-extension://, data:, etc.)
    if (!request.url.startsWith('http')) {
        return;
    }

    event.respondWith(
        caches.match(request).then((cachedResponse) => {
            // Background network revalidation fetch
            const fetchPromise = fetch(request).then((networkResponse) => {
                // Ensure the response is valid before caching
                if (networkResponse && networkResponse.status === 200 && networkResponse.type === 'basic') {
                    const responseToCache = networkResponse.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(request, responseToCache);
                    });
                }
                return networkResponse;
            }).catch((error) => {
                console.warn('📶 [Service Worker] Network offline or request failed:', request.url);
                return cachedResponse;
            });

            // Return cache immediately if present (fast boot), while updating cache asynchronously in the background.
            // If cache misses, wait for network fetch.
            return cachedResponse || fetchPromise;
        })
    );
});
