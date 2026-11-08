// Register the Service Worker for PWA capability
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        // Use relative path ('./service-worker.js' or 'service-worker.js') 
        // to ensure proper scope registration when served from subfolders (e.g., in XAMPP)
        navigator.serviceWorker.register('service-worker.js', { scope: './' })
            .then((registration) => {
                console.log('✅ [PWA] Service Worker successfully registered with scope:', registration.scope);

                // Optional: Check for updates on subsequent page visits
                registration.onupdatefound = () => {
                    const installingWorker = registration.installing;
                    if (installingWorker) {
                        installingWorker.onstatechange = () => {
                            if (installingWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                console.log('🔄 [PWA] New version available! Refresh to update.');
                            }
                        };
                    }
                };
            })
            .catch((error) => {
                console.error('❌ [PWA] Service Worker registration failed:', error);
            });
    });
}
