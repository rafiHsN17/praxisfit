document.addEventListener('DOMContentLoaded', () => {
    // ==========================================
    // 1. NUTRITION DATABASE & CALCULATOR LOGIC
    // ==========================================
    const foodDatabase = {
        "Dada Ayam Non-Fillet / Bone-in": 21,
        "Dada Ayam Fillet / Boneless": 31,
        "Telur Ayam Rebus": 13,
        "Tempe Murni": 19,
        "Whey Protein Concentrate": 80,
        "Daging Sapi Tanpa Lemak": 26,
        "Tahu": 8
    };

    const tableBody = document.getElementById('log-table-body');
    const emptyState = document.getElementById('empty-state');
    const logForm = document.getElementById('log-form');
    const profileWarning = document.getElementById('profile-warning');
    
    // Inputs
    const tanggalInput = document.getElementById('tanggal-input');
    const makananSelect = document.getElementById('makanan-select');
    const beratInput = document.getElementById('berat-input');
    const submitBtn = document.getElementById('submit-btn');
    const calcPreview = document.getElementById('calc-preview');

    // Progress UI
    const todayProteinEl = document.getElementById('today-protein');
    const remainingProteinEl = document.getElementById('remaining-protein');

    let logs = [];

    // Handle Dynamic Target
    const savedTarget = localStorage.getItem('proteinTarget');
    let TARGET_PROTEIN = 0;
    
    if (!savedTarget) {
        // Show Warning
        profileWarning.classList.remove('hidden');
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        document.getElementById('calc-target').textContent = '0';
    } else {
        TARGET_PROTEIN = parseFloat(savedTarget);
        document.getElementById('calc-target').textContent = TARGET_PROTEIN;
    }

    // Populate Select
    function populateDropdown() {
        for (const food in foodDatabase) {
            const option = document.createElement('option');
            option.value = food;
            option.textContent = `${food} (~${foodDatabase[food]}g/100g)`;
            makananSelect.appendChild(option);
        }
        
        // Set default date to today
        const today = new Date().toISOString().split('T')[0];
        tanggalInput.value = today;
    }

    // Calculator Preview
    function updatePreview() {
        const food = makananSelect.value;
        const weight = parseFloat(beratInput.value);
        if (food && weight && weight > 0) {
            const protein = ((weight / 100) * foodDatabase[food]).toFixed(1);
            calcPreview.textContent = `${protein}g Protein`;
        } else {
            calcPreview.textContent = `0g Protein`;
        }
    }

    makananSelect.addEventListener('change', updatePreview);
    beratInput.addEventListener('input', updatePreview);

    // Update Progress
    function updateProgress() {
        // Calculate only for TODAY's logs
        const today = new Date().toISOString().split('T')[0];
        const todayLogs = logs.filter(log => log.tanggal === today);
        
        const totalToday = todayLogs.reduce((sum, log) => {
            const val = parseFloat(log.protein || log.jumlah_protein);
            return sum + (isNaN(val) ? 0 : val);
        }, 0);

        todayProteinEl.textContent = totalToday.toFixed(1);
        
        // Save to localStorage for Dashboard use
        localStorage.setItem('totalProteinToday', totalToday.toFixed(1));

        const remaining = TARGET_PROTEIN - totalToday;
        
        if (remaining <= 0) {
            remainingProteinEl.innerHTML = `Target Tercapai! <span class="text-sm">(+${Math.abs(remaining).toFixed(1)}g)</span>`;
            remainingProteinEl.className = "text-2xl font-extrabold text-green-500 dark:text-lime-400 mt-1";
        } else {
            remainingProteinEl.innerHTML = `${remaining.toFixed(1)}<span class="text-lg font-medium">g</span>`;
            remainingProteinEl.className = "text-3xl font-extrabold text-orange-500 dark:text-orange-400 mt-1";
        }
    }

    // Load logs from API
    async function loadLogs() {
        try {
            const res = await fetchApi('/protein-logs', { method: 'GET' });
            logs = res.data ? res.data : res;
            renderLogs();
            updateProgress();
        } catch (error) {
            console.error("Gagal memuat log protein", error);
            // Non-critical, let it fail silently or show small warning if needed
        }
    }

    function renderLogs() {
        tableBody.innerHTML = '';

        if (logs.length === 0) {
            emptyState.classList.remove('hidden');
        } else {
            emptyState.classList.add('hidden');
            
            // Sort logs by date descending
            const sortedLogs = [...logs].sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal));
            
            sortedLogs.forEach(item => {
                const tr = document.createElement('tr');
                tr.className = 'hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors';
                
                const proteinVal = parseFloat(item.protein || item.jumlah_protein).toFixed(1);
                
                tr.innerHTML = `
                    <td class="p-4 text-gray-600 dark:text-zinc-400">${item.tanggal}</td>
                    <td class="p-4 font-semibold text-gray-800 dark:text-zinc-200">${item.makanan || item.sumber_makanan}</td>
                    <td class="p-4 text-red-600 dark:text-lime-400 font-bold">${proteinVal}g</td>
                    <td class="p-4 text-center">
                        <button onclick="hapusLog(${item.id})" class="text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-bold px-3 py-1 bg-red-50 dark:bg-red-900/20 rounded-lg transition-colors">
                            Hapus
                        </button>
                    </td>
                `;
                tableBody.appendChild(tr);
            });
        }
    }

    // Submit new log
    logForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const food = makananSelect.value;
        const weight = parseFloat(beratInput.value);
        
        if (!food || !weight || weight <= 0) {
            alert("Pilih makanan dan masukkan berat yang valid.");
            return;
        }

        const calculatedProtein = ((weight / 100) * foodDatabase[food]).toFixed(1);

        const payload = {
            tanggal: tanggalInput.value,
            makanan: food,
            protein: calculatedProtein,
            sumber_makanan: food, 
            jumlah_protein: calculatedProtein
        };

        submitBtn.disabled = true;
        submitBtn.textContent = 'Menyimpan...';

        try {
            await fetchApi('/protein-logs', {
                method: 'POST',
                body: JSON.stringify(payload)
            });
            
            // Reset only weight, keep date and food for faster logging
            beratInput.value = '';
            updatePreview();
            
            // Reload data
            loadLogs();
        } catch (error) {
            alert("Gagal menyimpan log nutrisi!");
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Simpan ke Log';
        }
    });

    // Handle delete globally
    window.hapusLog = async function(id) {
        if(confirm('Apakah Anda yakin ingin menghapus catatan ini?')) {
            try {
                await fetchApi(`/protein-logs/${id}`, { method: 'DELETE' });
                loadLogs();
            } catch (error) {
                alert("Gagal menghapus data!");
            }
        }
    };

    // Initialize Calculator
    populateDropdown();
    loadLogs();

    // ==========================================
    // 2. FAQ ACCORDION LOGIC
    // ==========================================
    const faqButtons = document.querySelectorAll('.faq-button');
    
    faqButtons.forEach(button => {
        button.addEventListener('click', () => {
            const content = button.nextElementSibling;
            const icon = button.querySelector('.faq-icon');
            
            // Toggle active state
            const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';
            
            // Close all other FAQs (Accordion style)
            document.querySelectorAll('.faq-content').forEach(c => {
                c.style.maxHeight = '0px';
            });
            document.querySelectorAll('.faq-icon').forEach(i => {
                i.textContent = '+';
                i.classList.remove('rotate-45');
            });

            // Open clicked FAQ if it was closed
            if (!isOpen) {
                content.style.maxHeight = content.scrollHeight + 'px';
                icon.textContent = '+';
                icon.classList.add('rotate-45'); // Adding rotation for a nice x effect
            }
        });
    });
});
