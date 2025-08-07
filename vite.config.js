import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { VitePWA } from "vite-plugin-pwa";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        VitePWA({
            registerType: "prompt",
            includeAssets: [
                "favicon.ico",
                "apple-touch-icon.png",
                "masked-icon.svg",
            ],
            manifest: {
                name: "Edukasi UKM",
                short_name: "Edu_UKM",
                description: "This is the app to Helpdesk",
                icons: [
                    {
                        src: "/PWA/android-chrome-192x192.png",
                        sizes: "192x192",
                        type: "image/png",
                        purpose: "any",
                    },
                    {
                        src: "/PWA/android-chrome-512x512.png",
                        sizes: "512x512",
                        type: "image/png",
                        purpose: "any ",
                    },
                    {
                        src: "/PWA/apple-touch-icon.png",
                        sizes: "180x180",
                        type: "image/png",
                        purpose: "any",
                    },
                ],
                theme_color: "#181818",
                background_color: "#fffefd",
                display: "standalone",
                scope: "/",
                start_url: "/",
                orientation: "portrait",
            },
            workbox: {
                maximumFileSizeToCacheInBytes: 50 * 1024 * 1024, // Tingkatkan batas file hingga 10 MB
                runtimeCaching: [
                    {
                        urlPattern: ({ request }) =>
                            request.destination === "document" ||
                            request.destination === "script",
                        handler: "NetworkFirst",
                        options: {
                            cacheName: "documents-cache",
                        },
                    },
                    {
                        urlPattern: ({ request }) =>
                            request.destination === "style",
                        handler: "StaleWhileRevalidate",
                        options: {
                            cacheName: "styles-cache",
                        },
                    },
                    {
                        urlPattern: ({ request }) =>
                            request.destination === "image",
                        handler: "CacheFirst",
                        options: {
                            cacheName: "images-cache",
                            expiration: {
                                maxEntries: 20,
                                maxAgeSeconds: 20 * 24 * 60 * 60,
                            },
                        },
                    },
                ],
                offlineGoogleAnalytics: true,
            },
        }),
    ],
});
