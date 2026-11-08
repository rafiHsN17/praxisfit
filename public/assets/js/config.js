/**
 * PRAXISFIT GLOBAL CONFIGURATION
 * -------------------------------------------------------------
 * Centralized configuration file for managing API endpoints and environment variables.
 * Loaded globally before any operational scripts to ensure consistency across the application.
 */

const CONFIG = {
    /**
     * =========================================================================
     * API BASE URL CONFIGURATION
     * =========================================================================
     * INSTRUCTIONS FOR DEPLOYMENT (Vercel, Netlify, Shared Hosting):
     * 
     * 1. FOR LOCAL DEVELOPMENT:
     *    Leave the localhost/127.0.0.1 URL uncommented while working locally with `php artisan serve`.
     * 
     * 2. FOR PRODUCTION DEPLOYMENT:
     *    Comment out the local URL and uncomment the Production HTTPS URL below.
     *    Replace 'https://api.namadomainanda.com/api' with your deployed Laravel server API domain.
     * =========================================================================
     */

    // 🟢 LOCAL DEVELOPMENT ENVIRONMENT (Active)
    API_BASE_URL: 'http://127.0.0.1:8000/api',

    // 🚀 PRODUCTION ENVIRONMENT (Uncomment when deploying to live server / Vercel / Netlify)
    // API_BASE_URL: 'https://api.namadomainanda.com/api',


    /**
     * Application Metadata (Optional helpers)
     */
    APP_NAME: 'PraxisFit',
    VERSION: '1.0.0'
};

// Freeze the configuration object to prevent accidental runtime mutations by other scripts
Object.freeze(CONFIG);
