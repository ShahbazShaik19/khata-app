self.addEventListener('fetch', function(event) {
  event.respondWith(
      caches.match(event.request).then(function(response) {
          return response || fetch(event.request);
      })
  );
});

//for pwa update
// const x=Math.floor((Math.random() * 10));