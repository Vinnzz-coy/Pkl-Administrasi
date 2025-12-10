document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById('absensiChart');

    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Senin", "Selasa", "Rabu", "Kamis", "Jumat"],
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
});
