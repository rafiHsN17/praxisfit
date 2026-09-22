const API_BASE_URL = 'http://127.0.0.1:8000/api';

/**
 * Custom fetch wrapper to handle authorization and base URL
 */
async function fetchApi(endpoint, options = {}) {
    const token = localStorage.getItem('token');
    
    const headers = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        ...options.headers,
    };

    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    const config = {
        ...options,
        headers,
    };

    try {
        const response = await fetch(`${API_BASE_URL}${endpoint}`, config);
        
        // Coba parsing JSON (kalau ada)
        let data = null;
        try {
            data = await response.json();
        } catch(e) {}
        
        if (!response.ok) {
            // Handle 401 Unauthorized
            if (response.status === 401) {
                localStorage.removeItem('token');
                localStorage.removeItem('isLoggedIn');
                if (!window.location.pathname.includes('login.html')) {
                    window.location.href = 'login.html';
                }
            }
            throw { status: response.status, data };
        }

        return data;
    } catch (error) {
        console.error('API Error:', error);
        throw error;
    }
}
