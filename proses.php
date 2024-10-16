<?php
session_start();
error_reporting(0);
include 'koneksi.php';
$income = 0;
$outcome = 0;
$tanggal = $_POST['tanggal'];
$user = $_SESSION['id'];
$keterangan = $_POST['keterangan'];

if (empty($_POST["saldo"])) {
  $saldo = 0;
}else{
  $saldo = $_POST["saldo"];
}
if (empty($_POST["income"])) {
  $income = 0;
}else{
  $income = $_POST["income"];
}
if (empty($_POST["outcome"])) {
  $outcome = 0;
}else{
  $outcome = $_POST["outcome"];
}

$inout = $income - $outcome;
$saldo = $saldo + $inout;

mysqli_query($koneksi, "INSERT INTO dompet (user_id, tanggal, saldo, income, outcome, keterangan) VALUES ('".$_SESSION['id']."', '$tanggal', '$saldo', '$income', '$outcome', '$keterangan')");

header("location:index.php?pesan=input");
exit();
?>