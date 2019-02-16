<?php
$ftpquota = @file_get_contents("/home/streaming/".$_GET["login"]."/.ftpquota");

if(!$ftpquota) {
$ftpquota = @readfile("/home/streaming/".$_GET["login"]."/.ftpquota");
}

list($arquivos, $espaco_usado_bytes) = explode(" ",$ftpquota);

$espaco_usado = round($espaco_usado_bytes/1024/1024);

if($espaco_usado_bytes > 0) {
echo $espaco_usado;
}
?>
