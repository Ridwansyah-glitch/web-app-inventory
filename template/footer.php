<footer class="py-4 bg-light mt-auto border">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Aplikasi Inventory <?= date('Y') ?></div>
        </div>
    </div>
</footer>
</div>
</div>

<script script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $main_url ?>sb_admin/js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script src="<?= $main_url ?>sb_admin/js/datatables-simple-demo.js"></script>
<script>
    <?php
    $sqlBm = $koneksi->query("SELECT SUM(jumlah) as jumlah FROM barang_masuk");
    while ($resBM = $sqlBm->fetch_assoc()) {
        $dataBm[] = $resBM['jumlah'];
    }
    $sqlBk = $koneksi->query("SELECT SUM(jumlah) as jumlah FROM barang_keluar");
    while ($resBK = $sqlBk->fetch_assoc()) {
        $dataBk[] = $resBK['jumlah'];
    }
    ?>
    const labels = [
        'Barang Masuk',
        'Barang Keluar'
    ]
    const data = {
        labels: labels,
        datasets: [{
            label: 'My First Dataset',
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(255, 205, 86)'
            ],
            data: [<?= json_encode($dataBm); ?>, <?= json_encode($dataBk); ?>],
            hoverOffset: 4
        }]
    };

    const config = {
        type: 'pie',
        data: data,
        option: {}
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>
</body>
</body>

</html>