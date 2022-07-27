<?php
$id = $_GET['id'];
if (!isset($id) or $id == "") {
    header('HTTP/1.1 400 Bad Request');
    echo "No ID Specified";
    die();
}

$headers = array(
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0",
    "Referer: https://www.imdb.com"
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://www.imdb.com/title/$id/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($ch);
curl_close($ch);
$regex = '/\"image\":\"(.*?)\"/';
preg_match_all($regex, $result, $matches);
$image = $matches[1][0];

if ($_GET['do'] == "redirect") {
    header("Location: $image");
    die();
} else {
    header("Content-Type: image/jpeg");
    echo file_get_contents($image);
    die();
}
?>
