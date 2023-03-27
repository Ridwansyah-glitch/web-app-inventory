<footer class="py-4 bg-light mt-auto border">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Aplikasi Inventory <?= date('Y') ?></div>
        </div>
    </div>
</footer>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.min.js" integrity="sha512-v3ygConQmvH0QehvQa6gSvTE2VdBZ6wkLOlmK7Mcy2mZ0ZF9saNbbk19QeaoTHdWIEiTlWmrwAL4hS8ElnGFbA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="<?= $main_url ?>sb_admin/js/scripts.js"></script>
<script src="<?= $main_url ?>sb_admin/js/datatables-simple-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    $('#addBarang').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('isi')
        var modal = $(this)

        modal.find('.modal-body input').val(recipient)
    });
    $('#editBarang').on('show.bs.modalEdit', function(event) {
        var buttonEdit = $(event.relatedTarget)
        var recipient = button.data('isi')
        var modalEdit = $(this)

        modal.find('.modal-body input').val(recipient)
    });
    // <?php

        $sqlBm = $koneksi->query("SELECT SUM(jumlah_masuk) as jumlah FROM barang_masuk");
        while ($resBM = $sqlBm->fetch_assoc()) {
            $dataBm[] = $resBM['jumlah'];
        }
        $sqlBk = $koneksi->query("SELECT SUM(jumlah_keluar) as jumlah FROM barang_keluar");
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
            data: [<?= json_encode($dataBm) ?>, <?= json_encode($dataBk) ?>],
            hoverOffset: 4
        }]
    };
    const config = {
        type: 'pie',
        data: data,
    };
    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );
</script>
</body>
</body>

</html>