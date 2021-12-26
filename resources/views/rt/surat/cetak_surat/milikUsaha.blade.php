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
		<u><b>SURAT KETERANGAN MEMILIKI USAHA</b></u><br>
		Nomor:{{ $no }}/{{ $rt->nama }}.{{ $rw->nama }}/SKMU/{{ date('m') }}/{{ date('Y') }}
	</center>
	<br><br>
	<p>
		Saya yang bertanda tangan dibawah ini :
	</p>
	<table style="margin-left: 50px">
		<tbody>
			<tr>
				<td>Nama</td>
				<td>: {{ $user->nama }}</td>
			</tr>
			<tr><?php 
				$lahir = explode('-', $data['tanggal_lahir']);
				$b = (int)$lahir[1] - 1;
				 ?>
				<td>Tempat/Tgl Lahir</td>
				<td>: {{ $data['tempat_lahir'].', '.$lahir[0].' '.$bulan[$b].' '.$lahir[2] }}</td>
			</tr>
			<tr>
				<td>Pekerjaan</td>
				<td>: {{ $data['pekerjaan'] }}</td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>: {{ $user->warga->alamat }}</td>
			</tr>
		</tbody>
	</table><br>
	<p align="justify">
		Dengan ini menyatakan bahwa saya pada saat ini mempunyai usaha {{ $data['nama_usaha'] }} yang berdomisili di {{ $data['alamat_usaha'] }} RT {{ $rt->nama }}, RW {{ $rw->nama }} dan berdomisili dilingkungan
		RT {{ $rt->nama }}, RW {{ $rw->nama }}, Kelurahan {{ $lurah->nama }}, Kecamatan {{ $kecamatan->nama }}, Kota {{ $kabupaten->nama }}
	</p>
	<p align="justify">
		Demikian Surat Pernyataan ini saya buat dengan sebenarnya dan apabila Pernyataan saya ini tidak benar / palsu,
        saya bersedia dituntut dimuka pengadilan sesuai peraturan perundangan yang berlaku dan tidak melibatkan pihak kelurahan.
	</p>
	<table>
		<tbody>
            <tr>
                <td></td>
                <td></td>
				<td><?php $b = (int)date('m') ?>
					<center>
						Pekanbaru, {{ date('d').' '.$bulan[$b-1].' '.date('Y') }} <br>
						Yang Membuat Pernyataan
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
				</td>
				<td></td>
				<td>
					<center>
						{{ $user->nama }}
					</center>
				</td>
			</tr>
			<tr>
				<td>
					<center><br>
						<b>RUKUN WARGA (RW) {{ $rw->nama }}</b><br>
						Ketua
					</center>
				</td>
				<td style="width: 250px"></td>
				<td>
					<center>
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