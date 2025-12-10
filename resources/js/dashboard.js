// Sidebar
document.getElementById('btnSidebar')?.addEventListener('click', () => {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
});

// Overlay click closes sidebar
document.getElementById('overlay')?.addEventListener('click', () => {
    document.getElementById('sidebar').classList.add('-translate-x-full');
    document.getElementById('overlay').classList.add('hidden');
});

// Profile Dropdown
document.getElementById('profileButton')?.addEventListener('click', (e) => {
    e.stopPropagation();
    document.getElementById('profileDropdownMenu').classList.toggle('hidden');
});

// Close dropdown on body click
document.addEventListener('click', () => {
    const dropdown = document.getElementById('profileDropdownMenu');
    if (!dropdown.classList.contains('hidden')) {
        dropdown.classList.add('hidden');
    }
});

// ChartJS
const ctx = document.getElementById('absensiChart');
if (ctx) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Senin","Selasa","Rabu","Kamis","Jumat"],
            datasets: [
                {
                    label: "Hadir",
                    data: [35, 40, 38, 45, 50],
                    borderColor: "#4f46e5",
                    backgroundColor: "rgba(79,70,229,0.3)",
                    borderWidth: 2,
                    tension: 0.3
                },
                {
                    label: "Tidak Hadir",
                    data: [5, 2, 4, 3, 1],
                    borderColor: "#ef4444",
                    backgroundColor: "rgba(239,68,68,0.3)",
                    borderWidth: 2,
                    tension: 0.3
                }
            ]
        }
    });
}
