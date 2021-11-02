<?php
header("Content-type: text/xml");
include("conn.php");

$stmt = $db->prepare('SELECT * FROM kml');
$stmt->execute();
while($row = $stmt->fetch()) {


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, ''.$row['url'].'');
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
$myfile = fopen("data-".strtolower(trim($row['name'])).".kml", "w") or die("Unable to open file!");
fwrite($myfile, $result);
fclose($myfile);
	echo "<script LANGUAGE='JavaScript'>
	alert('Files Updated');
    window.location.href='index.php';
    </script>";
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);
}
?>