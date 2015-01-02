<?php
include "../../../../bin/koneksi.php";

$filehtml = '<h2>DigTuts Daily Report</h2>';
$filehtml .= '<table class=table table-striped table-bordered>
					<thead>
						<tr>
							<th width=10%>Code</th>
							<th width=35%>Judul</th>
							<th width=15%>Pinjam</th>
							<th width=10%>Status</th>
						</tr>
					</thead>
					<tbody>';
							

$hariini = date("Y-m-d");
$sql 	= "SELECT * FROM view_trspeminjaman WHERE tgl_pinjam='$hariini' OR tgl_kembali='$hariini'";
$hasil 	= $konek->query($sql);
while($row = $hasil->fetch_assoc()){
	$filehtml .= '
		<tr>
			<td>'.$row[code_buku].'</td>
			<td>'.$row[judul].'</td>
			<td>'.$row[tgl_pinjam].'</td>
			<td>'.$row[statusbuku].'</td>
		</tr>';
}

$css = file_get_contents('../../../../lib/css/reportTable.css');        		
$filehtml .= '</tbody></table>';

include "../../../../lib/mpdf/mpdf.php";
$namaFile = "Laporan-Harian-".date("d-m-Y");
$mpdf = new mPDF('utf-8','A4','0','',10,10,5,1,1,1,'');
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($filehtml);
$mpdf->Output('files/'.$namaFile.'.pdf','D');
exit;

?>