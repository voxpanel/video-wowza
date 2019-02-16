<?php
header('Access-Control-Allow-Origin: *');
ini_set("memory_limit", "1024M");
ini_set("max_execution_time", 1800);

// Função para formatar texto retirando acentos e caracteres especiais
function formatar_texto($texto) {

$characteres = array(
    'S'=>'S', 's'=>'s', 'Ð'=>'Dj','Z'=>'Z', 'z'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
    'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
    'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
    'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
    'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
    'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
    'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'f'=>'f', '¹'=> '', '²'=> '', '&'=> 'e',
	'³'=> '', '£'=> '', '$'=> '', '%'=> '', '¨'=> '', '§'=> '', 'º'=> '', 'ª'=> '', '©'=> '', 'Ã£'=> '',
	'('=> '', ')'=> '', "'"=> '', '@'=> '', '='=> '', ':'=> '', '!'=> '', '?'=> '', '...'=> '', ' '=> '_',
	'['=> '', ']'=> '', '"'=> '', '.'=> '', '+'=> '', '/'=> '-', '|'=> ''
);

return strtr($texto, $characteres);

}

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
        echo str_replace("/home/streaming/".$_GET["login"]."/","",$live_output)."<br><script>window.scrollBy(0,100);</script>";
        @ flush();
    }

    pclose($proc);

}

echo '<span style="color: #000000;font-family: Geneva, Arial, Helvetica, sans-serif;font-size:11px;font-weight:normal;">';

$dados_video_youtube = json_decode(@file_get_contents("https://www.youtube.com/oembed?url=https://www.youtube.com/watch?v=".$_GET["video"].""));

$arquivo = formatar_texto(utf8_decode($dados_video_youtube->title)).".mp4";

@shell_exec("/bin/mkdir /home/streaming/".$_GET["login"]."/youtube");

liveExecuteCommand("/usr/local/bin/youtube-dl --no-cache-dir --output '/home/streaming/".$_GET["login"]."/".$_GET["pasta"]."/".$arquivo."' --format 18 https://www.youtube.com/watch?v=".$_GET["video"]."");

@shell_exec("/bin/chown streaming.streaming /home/streaming/".$_GET["login"]."/".$_GET["pasta"]."/".$arquivo."");

if(file_exists("/home/streaming/".$_GET["login"]."/".$_GET["pasta"]."/".$arquivo."")) {
echo "<span style=\"color: #009900;font-family: Geneva, Arial, Helvetica, sans-serif;font-size:11px;font-weight:normal;\">OK!<br>".$_GET["pasta"]."/".$arquivo."<br></span>";
} else {
echo "<span style=\"color: #FF0000;font-family: Geneva, Arial, Helvetica, sans-serif;font-size:11px;font-weight:normal;\">Error! Por favor tente novamente. Please try again.<br></span>";
}

echo '</span><script>window.scrollBy(0,100);</script>';

?>
