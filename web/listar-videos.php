<?php
require_once("thumb.php");

$xml = new XMLWriter;
$xml->openMemory();
$xml->startDocument('1.0','iso-8859-1');

$xml->startElement("videos");

$local = '/home/streaming/'.$_GET["login"].'/'.str_replace("%20"," ",$_GET["pasta"]).'';
$local_thumb = 'thumb/';

$dir = new DirectoryIterator($local);

foreach($dir as $file) {
	if($file->isFile()) {
		if(pathinfo($file->getFilename(), PATHINFO_EXTENSION) == "mp4" || pathinfo($file->getFilename(), PATHINFO_EXTENSION) == "MP4") {
			$array_videos[] = $file->getFilename();
		}
	}

}

if($_GET["ordenar"] == "sim") {
asort($array_videos);
}

foreach($array_videos as $video) {

$xml->startElement("video");

$video_info = json_decode(shell_exec("/usr/local/bin/ffprobe -v quiet -print_format json -show_format -show_streams '".$local."/".$video."'"));

$tipo_stream = ($video_info->{'streams'}[0]->{'codec_type'} == "video") ? 0 : 1;

$codec = $video_info->{'streams'}[$tipo_stream]->{'codec_name'};
$width = $video_info->{'streams'}[$tipo_stream]->{'width'};
$height = $video_info->{'streams'}[$tipo_stream]->{'height'};
$duration = $video_info->{'format'}->{'duration'};
$bitrate = floor($video_info->{'format'}->{'bit_rate'}/1000);
$duration = $video_info->{'format'}->{'duration'};
$framerate1 = strstr($video_info->{'streams'}[$tipo_stream]->{'r_frame_rate'}, '/', true);
$framerate2 = str_replace("/","",strstr($video_info->{'streams'}[$tipo_stream]->{'r_frame_rate'}, '/'));

// Verifica se já existe thumb e cria novo caso não exista
$thumb_path_nome = $local_thumb.$_GET["login"]."_".md5($video).".jpg";

if(file_exists($thumb_path_nome)) {
$thumb = $thumb_path_nome;
} else {
$thumb = VideoTile::createMovieThumb($local.'/'.$video, $thumb_path_nome);
}

$xml->writeElement("nome", utf8_encode($video));
$xml->writeElement("codec", $codec);
$xml->writeElement("width", $width);
$xml->writeElement("height", $height);
$xml->writeElement("bitrate", $bitrate);
$xml->writeElement("duracao", gmdate("H:i:s", $duration));
$xml->writeElement("duracao_segundos", floor($duration));
$xml->writeElement("framerate", round($framerate1/$framerate2));
$xml->writeElement("thumb", $thumb);

$xml->endElement();

}

$xml->endElement();

header('Content-type: text/xml');

print $xml->outputMemory(true);
?>
