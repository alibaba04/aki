<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}
	a{
		background: blue;
		color: #fff;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>
 
	<?php
	$tanggal = date("Y-m-d h", time());
	$tglJurnal1 = $_GET['tglJurnal1'];
	$tglJurnal2 = $_GET['tglJurnal2'];
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=jurnal_".$tanggal.".xls");
	require_once ("../function/fungsi_formatdate.php");
	
	?>
 
	<center>
		<h1>Export Data Jurnal Umum<br/></h1>
		<h3><?php if (($_GET["tglJurnal1"])!=''){echo 'Periode tanggal '. $tglJurnal1.' sampai '.$tglJurnal2;} ?></h3>
	</center>
 
	<table border="1">
		<tr>
			<th>Tanggal</th>
			<th>Nomor Bukti</th>
			<th>Kode Akun</th>
			<th>Nama Akun</th>
			<th>Keterangan</th>
			<th>Debet</th>
			<th>Kredit</th>
		</tr>
		<?php 
		// koneksi database
		$filter='';
		$tglJurnal1 = $_GET['tglJurnal1'];
		$tglJurnal2 = $_GET['tglJurnal2'];

		$filter = "";
		if ($tglJurnal1 && $tglJurnal2)
			$filter = $filter . " AND t.tanggal_transaksi BETWEEN '" . tgl_mysql($tglJurnal1) . "' AND '" . tgl_mysql($tglJurnal2) . "' ";
		$koneksi = mysqli_connect("localhost","u5514609_can",",S1s6h8+Mrc)","u5514609_dbaki");
 
		$q = "SELECT t.tanggal_transaksi, t.kode_transaksi, t.kode_rekening, m.nama_rekening, t.keterangan_transaksi, t.debet, t.kredit ";
		$q.= "FROM aki_tabel_transaksi t INNER JOIN aki_tabel_master m ON t.kode_rekening=m.kode_rekening ";
		$q.= "WHERE 1=1 " . $filter;
		$q.= " ORDER BY t.tanggal_transaksi, id_transaksi ";
		// menampilkan data pegawai
		$data = mysqli_query($koneksi,$q);
		while($d = mysqli_fetch_array($data)){
		?>
		<tr>
			<td><?php echo $d['tanggal_transaksi']; ?></td>
			<td><?php echo $d['kode_transaksi']; ?></td>
			<td><?php echo "'".$d['kode_rekening']; ?></td>
			<td><?php echo $d['nama_rekening']; ?></td>
			<td><?php echo $d['keterangan_transaksi']; ?></td>
			<td><?php echo $d['debet']; ?></td>
			<td><?php echo $d['kredit']; ?></td>
		</tr>
		<?php 
		}
		?>
	</table>
</body>
</html>




