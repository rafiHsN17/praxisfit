document.addEventListener('DOMContentLoaded', () => {
    // If already logged in, redirect away from register page
    if (localStorage.getItem('isAdminLoggedIn') === 'true') {
        window.location.href = 'admin.html';
        return;
    } else if (localStorage.getItem('isLoggedIn') && localStorage.getItem('token')) {
        window.location.href = 'index.html';
        return;
    }

    const registerForm = document.getElementById('register-form');
    const nameInput = document.getElementById('name-input');
    const emailInput = document.getElementById('email-input');
    const passwordInput = document.getElementById('password-input');
    const confirmPasswordInput = document.getElementById('confirm-password-input');
    const submitBtn = document.getElementById('submit-btn');

    // UI Alert containers
    const errorAlert = document.getElementById('error-alert');
    const errorMessage = document.getElementById('error-message');
    const successAlert = document.getElementById('success-alert');
    const successMessage = document.getElementById('success-message');

    /**
     * Display error alert in the UI
     * @param {string|string[]} msg 
     */
    function showError(msg) {
        hideAlerts();
        if (Array.isArray(msg)) {
            errorMessage.innerHTML = msg.map(m => `<div>• ${m}</div>`).join('');
        } else {
            errorMessage.textContent = msg;
        }
        errorAlert.classList.remove('hidden');
        // Smooth scroll to alert if needed
        errorAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    /**
     * Display success alert in the UI
     * @param {string} msg 
     */
    function showSuccess(msg) {
        hideAlerts();
        successMessage.textContent = msg;
        successAlert.classList.remove('hidden');
        successAlert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    /**
     * Hide all alert containers
     */
    function hideAlerts() {
        errorAlert.classList.add('hidden');
        errorMessage.textContent = '';
        successAlert.classList.add('hidden');
        successMessage.textContent = '';
    }

    /**
     * Set button loading state
     * @param {boolean} isLoading 
     */
    function setButtonLoading(isLoading) {
        if (isLoading) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Memproses... <span class="animate-pulse">⏳</span>';
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
        } else {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Buat Akun';
            submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
        }
    }

    registerForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        hideAlerts();

        const name = nameInput.value.trim();
        const email = emailInput.value.trim();
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        // 1. Frontend Validation
        if (!name || !email || !password || !confirmPassword) {
            showError("Harap isi seluruh kolom yang tersedia.");
            return;
        }

        // Basic Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showError("Format alamat email tidak valid.");
            return;
        }

        if (password.length < 8) {
            showError("Password minimal harus terdiri dari 8 karakter.");
            return;
        }

        if (password !== confirmPassword) {
            showError("Konfirmasi password tidak cocok dengan password yang Anda masukkan.");
            return;
        }

        // 2. Prepare API Request
        const payload = {
            name: name,
            email: email,
            password: password,
            password_confirmation: confirmPassword
        };

        setButtonLoading(true);

        try {
            // 3. Perform fetch call to Laravel API
            const response = await fetch('http://127.0.0.1:8000/api/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json().catch(() => null);

            // 4. Handle HTTP status responses
            if (response.ok || response.status === 200 || response.status === 201) {
                // Success
                showSuccess("Akun Anda berhasil dibuat! Mengalihkan ke halaman login...");
                
                // Keep button disabled during redirection
                submitBtn.disabled = true;
                submitBtn.textContent = 'Mengalihkan...';
                
                setTimeout(() => {
                    window.location.href = 'login.html';
                }, 1500);
                
            } else if (response.status === 422) {
                // Unprocessable Entity / Validation Error from Laravel
                if (data && data.errors) {
                    // Extract all validation errors from Laravel array structure
                    const errorMessages = [];
                    Object.values(data.errors).forEach(errArray => {
                        if (Array.isArray(errArray)) {
                            errorMessages.push(...errArray);
                        } else {
                            errorMessages.push(errArray);
                        }
                    });
                    showError(errorMessages.length > 0 ? errorMessages : "Terjadi kesalahan validasi data.");
                } else {
                    showError(data?.message || "Data yang Anda masukkan tidak valid atau email sudah terdaftar.");
                }
                setButtonLoading(false);
            } else if (response.status === 409) {
                showError("Email sudah terdaftar. Silakan gunakan alamat email lain atau login.");
                setButtonLoading(false);
            } else {
                // Other server errors
                showError(data?.message || "Terjadi kesalahan pada server (Error " + response.status + "). Silakan coba lagi nanti.");
                setButtonLoading(false);
            }
        } catch (error) {
            console.error("Network or API Error:", error);
            showError("Gagal terhubung ke server. Pastikan server backend Laravel beroperasi pada http://127.0.0.1:8000.");
            setButtonLoading(false);
        }
    });
});
