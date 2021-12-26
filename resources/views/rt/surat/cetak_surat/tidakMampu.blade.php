<!DOCTYPE html>
<html>
	<?php 
	$rt = $user->warga->detailRt;
	$rw = $rt->detailRW;
	$lurah = $rw->detailKelurahan;
	$kecamatan = $lurah->detailKecamatan;
	$kabupaten = $kecamatan->detailKabKota;
	$provinsi = $kabupaten->detailProvinsi;
    $bulan = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];
	?>
<head>
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<table>
		<tbody>
			<tr>
				<td style="padding: 0px;">
					<img src="{{ public_path('/assets/img/Logo_lambang_kota_pekanbaru.png') }}" alt="logo" style="width:100px">
				</td>
				<td style="margin-left: 0px; padding: 0px;">
					<center>
						<h5 style="height: 10px">RUKUN TETANGGA (RT) {{ $rt->nama }} / RUKUN WARGA (RW) {{ $rw->nama }}</h5>
						<h6 style="height: 25px">KELURAHAN {{ strtoupper($lurah->nama) }} KECAMATAN {{ strtoupper($kecamatan->nama) }} - KOTA {{ strtoupper($kabupaten->nama) }}</h6>
						<p>Alamat : JL. Garuda Sakti Km.3 / JL. UKA, Perum Garuda Permai Tbp 1, Blok A No.12 Pekanbaru - 23298</p>
					</center>
				</td>
			</tr>
		</tbody>
	</table>
	<hr style="height:3px;border:none;color:#333;background-color:#333;"><br><br>
	<center>
		<b>SURAT KETERANGAN</b><br><b><u>KELUARGA TIDAK MAMPU</u></b><br>
		Nomor:{{ $no }}/{{ $rt->nama }}.{{ $rw->nama }}/SKTM/{{ date('m') }}/{{ date('Y') }}
	</center>
	<br><br>
	<p align="justify">
		Yang bertanda tangan dibawah ini Ketua RT {{ $rt->nama }}, RW {{ $rw->nama }}, Kelurahan {{ $lurah->nama }},
		Kecamatan {{ $kecamatan->nama }}, Kota {{ $kabupaten->nama }}, dengan ini menerangkan bahwa :
	</p>
	<table style="margin-left: 50px">
		<tbody>
			<tr>
				<td>Nama</td>
				<td>: {{ $user->nama }}</td>
			</tr>
			<tr>
				<td>JenisKelamin</td>
				<td>: {{ $data['jenis_kelamin'] }}</td>
			</tr>
			<tr><?php 
				$lahir = explode('-', $data['tanggal_lahir']);
				$b = (int)$lahir[1] - 1;
				 ?>
				<td>Tempat/Tgl Lahir</td>
				<td>: {{ $data['tempat_lahir'].', '.$lahir[0].' '.$bulan[$b].' '.$lahir[2] }}</td>
			</tr>
			<tr>
				<td>Agama</td>
				<td>: {{ $data['agama'] }}</td>
			</tr>
			<tr>
				<td>Pekerjaan</td>
				<td>: {{ $data['pekerjaan'] }}</td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>: {{ $user->warga->alamat }}</td>
			</tr>
			<tr>
				<td>No KK</td>
				<td>: {{ $user->warga->no_kk }}</td>
			</tr>
			<tr>
				<td>No KTP</td>
				<td>: {{ $data['ktp'] }}</td>
			</tr>
		</tbody>
	</table>
	<p align="justify">
		Nama tersebut diatas adalah benar Warga RT {{ $rt->nama }}, RW {{ $rw->nama }} dan berdomisili dilingkungan
		RT {{ $rt->nama }}, RW {{ $rw->nama }}, Kelurahan {{ $lurah->nama }}, Kecamatan {{ $kecamatan->nama }}, Kota {{ $kabupaten->nama }},
        dan yang bersangkutan adalah benar :
	</p>
    <center><b>Keluarga Tidak Mampu / Miskin</b></center><br>
	<p>
		Demikian Surat Keterangan Domisili ini dibuat untuk dapat dipergunakan sebagaimana mestinya.
	</p>
	<table>
		<tbody>
			<tr>
				<td>
					<center><br>
						<b>RUKUN WARGA (RW) {{ $rw->nama }}</b><br>
						Ketua
					</center>
				</td>
				<td style="width: 250px"></td>
				<td><?php $b = (int)date('m') ?>
					<center>
						Pekanbaru, {{ date('d').' '.$bulan[$b-1].' '.date('Y') }} <br>
						<b>RUKUN TETANGGA (RT) {{ $rt->nama }}</b><br>
						Ketua
					</center>
				</td>
			</tr>
			<tr style="height: 300px">
				<td><br><br><br></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>
					<center>
						_______________
					</center>
				</td>
				<td></td>
				<td>
					<center>
						_______________
					</center>
				</td>
			</tr>
		</tbody>
	</table>
 
</body>
</html>