<?php
$title = 'Selamat Datang di Aplikasi Izzi Laundry';

require 'koneksi.php';
require 'header.php';

setlocale(LC_ALL, 'id_id');
setlocale(LC_TIME, 'id_ID.utf8');

// Mengambil data dari database
$query = mysqli_query($conn, "SELECT COUNT(id_transaksi) as jumlah_transaksi FROM transaksi");
$jumlah_transaksi = mysqli_fetch_assoc($query);

$query2 = mysqli_query($conn, "SELECT COUNT(id_pelanggan) as jumlah_pelanggan FROM pelanggan");
$jumlah_pelanggan = mysqli_fetch_assoc($query2);

$query3 = mysqli_query($conn, "SELECT COUNT(id_outlet) as jumlah_outlet FROM outlet");
$jumlah_outlet = mysqli_fetch_assoc($query3);

$query4 = mysqli_query($conn, "SELECT SUM(total_harga) as total_penghasilan FROM detail_transaksi INNER JOIN transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi WHERE status_bayar = 'dibayar'");
$total_penghasilan = mysqli_fetch_assoc($query4);

$query5 = mysqli_query($conn, "SELECT SUM(total_harga) as penghasilan_tahun FROM detail_transaksi INNER JOIN transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi WHERE status_bayar = 'dibayar' AND YEAR(tgl_pembayaran) = YEAR(NOW())");
$penghasilan_tahun = mysqli_fetch_assoc($query5);

$query6 = mysqli_query($conn, "SELECT SUM(total_harga) as penghasilan_bulan FROM detail_transaksi INNER JOIN transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi WHERE status_bayar = 'dibayar' AND MONTH(tgl_pembayaran) = MONTH(NOW())");
$penghasilan_bulan = mysqli_fetch_assoc($query6);

$query7 = mysqli_query($conn, "SELECT SUM(total_harga) as penghasilan_minggu FROM detail_transaksi INNER JOIN transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi WHERE status_bayar = 'dibayar' AND WEEK(tgl_pembayaran) = WEEK(NOW())");
$penghasilan_minggu = mysqli_fetch_assoc($query7);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18"><?= $title; ?></h4>
            </div>
        </div>
    </div>

    <!-- Kartu Statistik Utama -->
    <div class="row">
        <?php
        // Array untuk menyimpan informasi kartu
        $cards = [
            ["Jumlah Outlet", $jumlah_outlet['jumlah_outlet'], "fas fa-store", "primary"],
            ["Jumlah Pelanggan", $jumlah_pelanggan['jumlah_pelanggan'], "fas fa-users", "warning"],
            ["Jumlah Transaksi", $jumlah_transaksi['jumlah_transaksi'], "fas fa-exchange-alt", "success"],
            ["Total Penghasilan", 'Rp ' . number_format($total_penghasilan['total_penghasilan']), "fas fa-money-bill-wave", "info"]
        ];

        // Loop untuk menampilkan kartu utama
        foreach ($cards as $card) {
            echo '
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">' . $card[0] . '</p>
                                <h4 class="mb-0">' . $card[1] . '</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-' . $card[3] . '">
                                    <span class="avatar-title">
                                        <i class="' . $card[2] . ' font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>

    <!-- Kartu Penghasilan Mingguan, Bulanan, dan Tahunan -->
    <div class="row">
        <?php
        // Array untuk menyimpan informasi kartu penghasilan
        $incomeCards = [
            ["Penghasilan Minggu Ini", 'Rp ' . number_format($penghasilan_minggu['penghasilan_minggu']), "fas fa-calendar-week", "secondary"],
            ["Penghasilan Bulan Ini", 'Rp ' . number_format($penghasilan_bulan['penghasilan_bulan']), "fas fa-calendar-alt", "secondary"],
            ["Penghasilan Tahun Ini", 'Rp ' . number_format($penghasilan_tahun['penghasilan_tahun']), "fas fa-calendar", "secondary"]
        ];

        // Loop untuk menampilkan kartu penghasilan
        foreach ($incomeCards as $incomeCard) {
            echo '
            <div class="col-xl-4 col-md-6">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-muted fw-medium">' . $incomeCard[0] . '</p>
                                <h4 class="mb-0">' . $incomeCard[1] . '</h4>
                            </div>
                            <div class="flex-shrink-0 align-self-center">
                                <div class="mini-stat-icon avatar-sm rounded-circle bg-' . $incomeCard[3] . '">
                                    <span class="avatar-title">
                                        <i class="' . $incomeCard[2] . ' font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>

    <!-- Diagram Statistik -->
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Perbandingan Data Statistik</h4>
                    <canvas id="barChart" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Proporsi Data</h4>
                    <canvas id="pieChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data untuk Bar Chart
    var barChartData = {
        labels: ['Jumlah Outlet', 'Jumlah Pelanggan', 'Jumlah Transaksi'],
        datasets: [{
            label: 'Jumlah',
            backgroundColor: ['#3498db', '#f1c40f', '#2ecc71'],
            borderColor: '#34495e',
            borderWidth: 1,
            data: [<?= $jumlah_outlet['jumlah_outlet']; ?>, <?= $jumlah_pelanggan['jumlah_pelanggan']; ?>, <?= $jumlah_transaksi['jumlah_transaksi']; ?>]
        }]
    };

    // Konfigurasi Bar Chart
    var ctx1 = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctx1, {
        type: 'bar',
        data: barChartData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    enabled: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#ecf0f1'
                    }
                },
                x: {
                    grid: {
                        color: '#ecf0f1'
                    }
                }
            }
        }
    });

    // Data untuk Pie Chart
    var pieChartData = {
        labels: ['Jumlah Outlet', 'Jumlah Pelanggan', 'Jumlah Transaksi'],
        datasets: [{
            label: 'Proporsi',
            backgroundColor: ['#3498db', '#f1c40f', '#2ecc71'],
            hoverBackgroundColor: ['#2980b9', '#f39c12', '#27ae60'],
            data: [<?= $jumlah_outlet['jumlah_outlet']; ?>, <?= $jumlah_pelanggan['jumlah_pelanggan']; ?>, <?= $jumlah_transaksi['jumlah_transaksi']; ?>]
        }]
    };

    // Konfigurasi Pie Chart
    var ctx2 = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(ctx2, {
        type: 'pie',
        data: pieChartData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });
</script>

<?php
require 'footer.php';
?>
