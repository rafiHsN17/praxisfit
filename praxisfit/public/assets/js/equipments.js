document.addEventListener('DOMContentLoaded', () => {
    // ==========================================
    // 1. EQUIPMENTS DATA LOGIC
    // ==========================================
    const grid = document.getElementById('equipment-grid');
    const loadingState = document.getElementById('loading-state');

    async function loadData() {
        try {
            const res = await fetchApi('/equipments', { method: 'GET' });
            const data = res.data ? res.data : res;
            
            loadingState.remove();
            
            if (data.length === 0) {
                grid.innerHTML = `<div class="col-span-full text-center py-10 text-gray-500 bg-white dark:bg-zinc-950 rounded-2xl border border-gray-100 dark:border-zinc-800">Belum ada jadwal latihan yang tersedia saat ini.</div>`;
            } else {
                renderEquipments(data);
            }
        } catch (error) {
            loadingState.innerHTML = "Gagal memuat data jadwal latihan.";
            loadingState.classList.add('text-red-500');
        }
    }

    function renderEquipments(items) {
        grid.innerHTML = '';
        
        items.forEach(item => {
            const card = document.createElement('div');
            card.className = 'bg-white dark:bg-zinc-950 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-zinc-800 border-l-4 border-l-red-500 dark:border-l-lime-400 hover:shadow-md hover:-translate-y-1 transition-all duration-300';
            
            card.innerHTML = `
                <div class="flex items-start justify-between mb-4">
                    <span class="text-4xl bg-red-50 dark:bg-zinc-900 p-3 rounded-xl">${item.icon || '🏋️'}</span>
                </div>
                <h3 class="font-bold text-xl mb-1">${item.nama}</h3>
                <div class="space-y-1 mt-4">
                    <p class="text-sm text-gray-500 dark:text-zinc-400">
                        🎯 Fokus: <span class="font-semibold text-gray-800 dark:text-zinc-200">${item.fokus}</span>
                    </p>
                    <p class="text-sm text-gray-500 dark:text-zinc-400">
                        ⏱️ Reps: <span class="font-semibold text-red-600 dark:text-lime-400">${item.durasi}</span>
                    </p>
                </div>
            `;
            
            grid.appendChild(card);
        });
    }

    // Initial load
    loadData();

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
                icon.classList.add('rotate-45');
            }
        });
    });
});
