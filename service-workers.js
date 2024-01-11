// service-worker.js
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open('linkorto-cache').then((cache) => {
            return cache.addAll([
                './',
                './index.php',
                // Agrega aquí todas las rutas y recursos que deseas cachear
            ]);
        })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});
