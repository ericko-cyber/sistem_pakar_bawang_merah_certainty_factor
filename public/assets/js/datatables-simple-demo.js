window.addEventListener('DOMContentLoaded', event => {
    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple, {
            columns: [
                // index 0 adalah kolom "Kode Penyakit"
                { select: 0, sort: "asc" }
            ]
        });
    }
});

