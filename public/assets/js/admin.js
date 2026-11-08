document.addEventListener('DOMContentLoaded', () => {
    // Proteksi Halaman Admin
    if (!localStorage.getItem('token')) {
        window.location.href = 'login.html';
    }

    const API_URL = 'http://127.0.0.1:8000/api/equipments';

    // Elemen DOM
    const form = document.getElementById('admin-form');
    const tableBody = document.getElementById('table-body');
    const emptyState = document.getElementById('empty-state');
    const btnCancel = document.getElementById('btn-cancel');
    const btnSubmit = document.getElementById('btn-submit');
    const formTitle = document.getElementById('form-title');

    let isEditMode = false;

    // Load Data dari API
    async function fetchEquipments() {
        try {
            const response = await fetch(API_URL);
            const result = await response.json();
            renderTable(result.data);
        } catch (error) {
            console.error("Gagal mengambil data:", error);
            alert("Gagal terhubung ke server.");
        }
    }

    // Gambar Tabel ke Layar
    function renderTable(data) {
        tableBody.innerHTML = '';

        if (data.length === 0) {
            emptyState.classList.remove('hidden');
            return;
        }

        emptyState.classList.add('hidden');

        data.forEach(item => {
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50 dark:hover:bg-zinc-900/50 transition';
            tr.innerHTML = `
                <td class="p-4 flex items-center gap-3">
                    <span class="text-2xl bg-gray-100 dark:bg-zinc-800 p-2 rounded-lg">${item.icon}</span>
                    <span class="font-bold">${item.nama}</span>
                </td>
                <td class="p-4 text-gray-600 dark:text-zinc-400">${item.fokus}</td>
                <td class="p-4 font-medium">${item.durasi}</td>
                <td class="p-4 text-right">
                    <button onclick="editData(${item.id}, '${item.nama}', '${item.fokus}', '${item.durasi}', '${item.icon}')" 
                        class="text-blue-500 hover:text-blue-700 px-3 py-1 bg-blue-50 dark:bg-blue-900/30 rounded-lg mr-2 font-medium transition">
                        Edit
                    </button>
                    <button onclick="deleteData(${item.id})" 
                        class="text-red-500 hover:text-red-700 px-3 py-1 bg-red-50 dark:bg-red-900/30 rounded-lg font-medium transition">
                        Hapus
                    </button>
                </td>
            `;
            tableBody.appendChild(tr);
        });
    }

    // Submit Form (Tambah / Update)
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const payload = {
            nama: document.getElementById('input-nama').value,
            fokus: document.getElementById('input-fokus').value,
            durasi: document.getElementById('input-durasi').value,
            icon: document.getElementById('input-icon').value
        };

        const editId = document.getElementById('edit-id').value;
        const method = isEditMode ? 'PUT' : 'POST';
        const url = isEditMode ? `${API_URL}/${editId}` : API_URL;

        try {
            const response = await fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (response.ok) {
                form.reset();
                resetFormState();
                fetchEquipments();
            }
        } catch (error) {
            alert("Gagal menyimpan data!");
        }
    });

    // Masuk Mode Edit (Fungsi Global agar bisa dipanggil dari HTML)
    window.editData = (id, nama, fokus, durasi, icon) => {
        isEditMode = true;
        document.getElementById('edit-id').value = id;
        document.getElementById('input-nama').value = nama;
        document.getElementById('input-fokus').value = fokus;
        document.getElementById('input-durasi').value = durasi;
        document.getElementById('input-icon').value = icon;

        formTitle.innerHTML = '⚠️ Edit Jadwal Latihan';
        btnSubmit.innerHTML = 'Update Data';
        btnCancel.classList.remove('hidden');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // Hapus Data
    window.deleteData = async (id) => {
        if (confirm("Yakin ingin menghapus jadwal ini?")) {
            await fetch(`${API_URL}/${id}`, { method: 'DELETE' });
            fetchEquipments();
        }
    };

    // Batal Edit
    btnCancel.addEventListener('click', () => {
        form.reset();
        resetFormState();
    });

    function resetFormState() {
        isEditMode = false;
        document.getElementById('edit-id').value = '';
        formTitle.innerHTML = '➕ Tambah Jadwal Baru';
        btnSubmit.innerHTML = 'Simpan Data';
        btnCancel.classList.add('hidden');
    }

    // Logout
    document.getElementById('btn-logout').addEventListener('click', () => {
        localStorage.removeItem('token');
        localStorage.removeItem('isLoggedIn');
        window.location.href = 'login.html';
    });

    // Inisialisasi awal
    fetchEquipments();
});