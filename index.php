<?php
session_start();
if ($_SESSION['status'] != "login") {
    header("location:login/login.php?pesan=belum_login");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>DOMPETKU</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/2f7c7772c6.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="container pt-4">
    <div class="card">
    <div class="card-header" style="background-color: #243ab3; color: white;">
        <b><a href="index.php" class="text-white">DOMPETKU (<?= htmlspecialchars($_SESSION['user']); ?>)</a></b>
        <?php
            include 'koneksi.php';
            $saldoTerbaru = mysqli_query($koneksi, "select saldo from dompet where user_id = '".$_SESSION['id']."' order by tanggal desc limit 1");
            $dataSaldo = mysqli_fetch_array($saldoTerbaru);
            $cek = mysqli_num_rows($saldoTerbaru);
            if ($cek > 0) {
                echo "<span class='float-right'><i class='fa fa-money-bill-wave-alt'> Rp ".$dataSaldo['saldo']."</i></span>";
            } else {
                echo "<span class='float-right'><i class='fa fa-money-bill-wave-alt'> Rp 0</i></span>";
            }
            ?>
        </div>
        <div class="card-body">
            <?php
            if (isset($_GET['pesan'])) {
                $pesan = $_GET['pesan'];
                if ($pesan == "input") {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><i class='fa fa-check'></i> Input data berhasil!
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                          </button>
                          </div>";
                } else if ($pesan == "hapus") {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><i class='fa fa-trash'></i> Data berhasil dihapus!
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                          </button>
                          </div>";
                } else if ($pesan == "login") {
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><i class='fa fa-sign-in'></i> Login berhasil! Selamat datang <i>".$_SESSION['user']."</i>
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                          </button>
                          </div>";
                }
            }
            ?>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                <i class="fa fa-plus"></i> Tambah Data
            </button>

            <a href="logout.php" class="btn btn-danger float-right" onclick="return confirm('Anda yakin ingin logout?')">
                <i class="fa fa-sign-out"></i> Log out
            </a>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="proses.php" method="post">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal & Waktu</label>
                                    <input type="datetime-local" class="form-control" name="tanggal" required>
                                </div>
                                <?php
                                $saldoTerbaru = mysqli_query($koneksi, "select saldo from dompet where user_id = '".$_SESSION['id']."' order by tanggal desc limit 1");
                                $dataSaldo = mysqli_fetch_array($saldoTerbaru);
                                ?>
                                <div class="form-group">
                                    <label for="saldo">Saldo saat ini</label>
                                    <input type="number" class="form-control" name="saldo" readonly value="<?=$dataSaldo['saldo']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="income">Income/Pemasukan</label>
                                    <input type="number" class="form-control" name="income">
                                </div>
                                <div class="form-group">
                                    <label for="outcome">Outcome/Pengeluaran</label>
                                    <input type="number" class="form-control" name="outcome">
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" rows="3" placeholder="Masukkan keterangan..."></textarea>
                                </div>
                                <div class="form-group float-right">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <br><br>
            <table class="table table-bordered table-striped" id="example">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Saldo</th>
                        <th scope="col">Income</th>
                        <th scope="col">Outcome</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = mysqli_query($koneksi, "select * from dompet WHERE user_id = '".$_SESSION['id']."'");
                    while ($d = mysqli_fetch_array($data)) {
                        $originalDate = $d['tanggal'];
                        $newDate = date("d-m-Y H:i", strtotime($originalDate));
                        ?>
                        <tr>
                            <td><?= $newDate; ?></td>
                            <td><b>Rp <?=$d['saldo']; ?></b></td>
                            <td class="text-success">+ Rp <?=$d['income']; ?></td>
                            <td class="text-danger">- Rp <?=$d['outcome']; ?></td>
                            <td><?= $d['keterangan']; ?></td>
                            <td align="center" class="align-middle">
                                <a href="hapus.php?id=<?php echo $d['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data?')"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer text-secondary text-center">
            <h6>Ojo boros ya <?= htmlspecialchars($_SESSION['user']); ?></h6>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 2000);
        
        $('#example').DataTable({
            "order": [[0, "desc"]]
        });
    });
</script>
</body>
</html>
