// Function to check if user is logged in
function checkAuth() {
    const isLoggedIn = localStorage.getItem('isLoggedIn');
    const token = localStorage.getItem('token');
    
    if (!isLoggedIn || !token) {
        window.location.href = 'login.html';
    }
}

// Global logout function
function logout() {
    if(confirm('Apakah Anda yakin ingin keluar?')) {
        localStorage.removeItem('isLoggedIn');
        localStorage.removeItem('token');
        alert("Anda telah berhasil logout.");
        window.location.href = 'login.html';
    }
}
