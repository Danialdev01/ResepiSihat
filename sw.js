
//@ Cache resource
const staticCacheName = 'site-static'; // Change version to force update
const assets = [
    './node_modules/flowbite/dist/flowbite.min.css',
    './src/assets/css/output.css',
    'https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js',
    'https://code.jquery.com/jquery-3.7.1.min.js',
    'https://cdn.datatables.net/2.1.4/js/dataTables.js',
    './src/assets/js/selectoption.js',
    './src/assets/images/logo.png',
    './fallback.php'
];

self.addEventListener('install', (evt) => {
  evt.waitUntil(
    caches.open(staticCacheName).then(async (cache) => {
      console.log('Caching assets one by one...');
      for (const asset of assets) {
        try {
          await cache.add(asset);
          console.log('✅ Cached:', asset);
        } catch (err) {
          console.error('❌ Failed to cache:', asset, err);
        }
      }
    })
  );
});

self.addEventListener('fetch', (evt) => {
  evt.respondWith(
    caches.match(evt.request).then((cacheRes) => {
      return cacheRes || fetch(evt.request);
    })
    .catch(() => caches.match('./fallback.php'))
  )
});

//@ Push notification
self.addEventListener("push", (event) => {

    const notif = event.data.json().notification;

    event.waitUntil(self.registration.showNotification(notif.title , {
        body: notif.body,
        icon: notif.image,
        data: {
            url: notif.click_action
        }
    }));

});

self.addEventListener("notificationclick", (event) => {

    event.waitUntil(clients.openWindow(event.notification.data.url));

});