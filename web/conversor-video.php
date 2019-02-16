<?php
header('Access-Control-Allow-Origin: *');
ini_set("memory_limit", "1024M");
ini_set("max_execution_time", 1800);

function liveExecuteCommand($cmd)
{

    while (@ ob_end_flush());

    $proc = popen("$cmd 2>&1", 'r');

    $live_output     = "";
    $complete_output = "";

    while (!feof($proc))
    {
        $live_output     = fread($proc, 4096);
        $complete_output = $complete_output . $live_output;
        echo str_replace("/home/streaming/".$_GET["login"]."/","",$live_output)."<br>";
		echo '<script>this.scrollIntoView(false);</script>';
        @ flush();
    }

    pclose($proc);

}

$local = '/home/streaming/'.$_GET["login"].'';
$pasta = $_GET["pasta"];
$video = $_GET["video"];
$video_resolucao = $_GET["video_resolucao"];
$video_framerate_atual = $_GET["video_framerate_atual"];
$video_framerate_novo = $_GET["video_framerate_novo"];
$video_bitrate = $_GET["video_bitrate"];
$audio_bitrate = $_GET["audio_bitrate"];
$audio_samplerate = $_GET["audio_samplerate"];

$video_novo_nome = str_replace(".mp4","",$video);
$video_novo_nome = $video_novo_nome."_converted.mp4";

$parametros = "";

if($video_resolucao) {
$parametros .= "-vf scale=".$video_resolucao." ";
}

if($video_framerate_atual && $video_framerate_novo) {
$parametros .= "-framerate ".$video_framerate_atual." -r ".$video_framerate_novo." ";
}

if($video_bitrate) {
$parametros .= "-b:v ".$video_bitrate."k ";
}

if($audio_bitrate || $audio_samplerate) {
$parametros .= "-c:a aac ";
}

if($audio_bitrate) {
$parametros .= "-b:a ".$audio_bitrate."k ";
}

if($audio_samplerate) {
$parametros .= "-ar ".$audio_samplerate." ";
}

liveExecuteCommand("/usr/local/bin/ffmpeg -i '".$local."/".$pasta."/".$video."' -c:v libx264 -profile:v baseline -level 3.0 ".$parametros." -y '".$local."/".$pasta."/".$video_novo_nome."'");

echo "OK!<br>Video ".$video_novo_nome."<br><br>";

if($_GET["remover_source"] == "sim") {
@unlink("".$local."/".$pasta."/".$video."");
}
?>
