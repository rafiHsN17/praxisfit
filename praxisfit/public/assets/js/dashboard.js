document.addEventListener('DOMContentLoaded', () => {
    // ==========================================
    // 1. DAILY SNAPSHOT WIDGET LOGIC
    // ==========================================
    const savedTarget = localStorage.getItem('proteinTarget');
    const targetProtein = savedTarget ? parseFloat(savedTarget) : 150;
    
    document.getElementById('widget-target').textContent = targetProtein;

    const widgetProteinEl = document.getElementById('widget-protein');
    const widgetProgressBar = document.getElementById('widget-progress-bar');
    const widgetMessage = document.getElementById('widget-message');

    // Read today's protein from localStorage (saved by calculator.js)
    const savedProtein = localStorage.getItem('totalProteinToday');
    
    // Parse it, default to 0 if not found or invalid
    const currentProtein = savedProtein ? parseFloat(savedProtein) : 0;
    
    // Update the UI Number
    widgetProteinEl.textContent = currentProtein.toFixed(1);
    
    // Calculate Progress Percentage (Max 100% so bar doesn't overflow)
    let percentage = (currentProtein / targetProtein) * 100;
    if (percentage > 100) percentage = 100;
    
    // Animate the progress bar width
    // Use a small timeout to allow the browser to render 0% first, then animate
    setTimeout(() => {
        widgetProgressBar.style.width = `${percentage}%`;
    }, 100);

    // Update Message based on progress
    if (currentProtein === 0) {
        widgetMessage.textContent = "Belum ada data hari ini. Ayo catat makananmu!";
    } else if (currentProtein >= targetProtein) {
        widgetMessage.innerHTML = `<span class="text-green-500 dark:text-lime-400 font-bold">Luar biasa!</span> Target harianmu sudah tercapai.`;
    } else {
        const remaining = (targetProtein - currentProtein).toFixed(1);
        widgetMessage.textContent = `Sisa ${remaining}g protein untuk mencapai target hari ini.`;
    }

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

    // ==========================================
    // 3. WEEKLY PROGRESS CHART LOGIC
    // ==========================================
    let weeklyChart = null;

    async function initWeeklyChart() {
        const ctx = document.getElementById('weekly-chart').getContext('2d');
        if (!ctx) return;

        // Generate last 7 days labels
        const dates = [];
        const labels = [];
        for (let i = 6; i >= 0; i--) {
            const d = new Date();
            d.setDate(d.getDate() - i);
            const dateStr = d.toISOString().split('T')[0];
            dates.push(dateStr);
            
            // Format label as DD/MM
            const day = String(d.getDate()).padStart(2, '0');
            const month = String(d.getMonth() + 1).padStart(2, '0');
            labels.push(`${day}/${month}`);
        }

        let logs = [];
        try {
            const res = await fetchApi('/protein-logs', { method: 'GET' });
            logs = res.data ? res.data : res;
        } catch (error) {
            console.error("Gagal memuat log protein untuk grafik", error);
        }

        // Calculate totals for each day
        const dataPoints = dates.map(dateStr => {
            const dayLogs = logs.filter(log => log.tanggal === dateStr);
            const total = dayLogs.reduce((sum, log) => {
                const val = parseFloat(log.protein || log.jumlah_protein);
                return sum + (isNaN(val) ? 0 : val);
            }, 0);
            return parseFloat(total.toFixed(1));
        });

        // Setup Chart Colors based on Theme
        const isDark = document.documentElement.classList.contains('dark');
        const barColor = isDark ? '#a3e635' : '#dc2626'; // Lime-400 or Red-600
        const gridColor = isDark ? '#27272a' : '#f3f4f6'; // Zinc-800 or Gray-100
        const tickColor = isDark ? '#a1a1aa' : '#6b7280'; // Zinc-400 or Gray-500

        weeklyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Protein (g)',
                    data: dataPoints,
                    backgroundColor: barColor,
                    borderRadius: 4,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + 'g';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor },
                        ticks: { color: tickColor }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: tickColor }
                    }
                }
            }
        });
    }

    initWeeklyChart();

    // Listen for Theme Changes to dynamically update Chart colors
    window.addEventListener('themeChanged', () => {
        if (weeklyChart) {
            const isDark = document.documentElement.classList.contains('dark');
            const barColor = isDark ? '#a3e635' : '#dc2626';
            const gridColor = isDark ? '#27272a' : '#f3f4f6';
            const tickColor = isDark ? '#a1a1aa' : '#6b7280';

            weeklyChart.data.datasets[0].backgroundColor = barColor;
            weeklyChart.options.scales.y.grid.color = gridColor;
            weeklyChart.options.scales.y.ticks.color = tickColor;
            weeklyChart.options.scales.x.ticks.color = tickColor;
            weeklyChart.update();
        }
    });

});
