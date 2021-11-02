<?php

include("conn.php");
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://genmap.lyngsat.org/server2/kml');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

$headers = array();
$headers[] = 'Connection: keep-alive';
$headers[] = 'Cache-Control: max-age=0';
$headers[] = 'Upgrade-Insecure-Requests: 1';
$headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.54 Safari/537.36';
$headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
$headers[] = 'Accept-Language: tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7';
$headers[] = 'Cookie: PHPSESSID='.md5(rand()).'';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
$myfile = fopen("data-kml.json", "w") or die("Unable to open file!");
fwrite($myfile, $result);
fclose($myfile);
$data = json_decode($result, true);


foreach($data["kml_list"] as $kml) {


	$update = $db->prepare("INSERT INTO kml(id, name, satpos, beams_process_timestamp, url) VALUES (:id, :name, :satpos, :beams, :url) ");
	$update->bindValue(':id', strip_tags($kml["id"]));
	$update->bindValue(':name', strip_tags($kml["name"]));
	$update->bindValue(':satpos', strip_tags($kml["satpos"]));
	$update->bindValue(':beams', strip_tags($kml["beams_process_timestamp"]));
	$update->bindValue(':url', strip_tags($kml["url"]));

	$update->execute();
	if($row = $update->rowCount()) {
	echo "<script LANGUAGE='JavaScript'>
	alert('Database Updated / Files Will Be Update');
    window.location.href='sat.php';
    </script>";
	} else {
    echo "<script LANGUAGE='JavaScript'>
    alert('Database Not Updated');
    window.location.href='index.php';
    </script>";
	}

}

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
?>