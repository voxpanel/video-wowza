<?php
function remover_caracteres($texto) {

$characteres = array(
    'S'=>'S', 's'=>'s', 'Ð'=>'Dj','Z'=>'Z', 'z'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A',
    'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I',
    'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U',
    'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a',
    'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i',
    'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
    'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'f'=>'f', '¹'=> '', '²'=> '', '&'=> 'e',
	'³'=> '', '£'=> '', '$'=> '', '%'=> '', '¨'=> '', '§'=> '', 'º'=> '', 'ª'=> '', '©'=> '', 'Ã£'=> '',
	'('=> '', ')'=> '', "'"=> '', '@'=> '', '='=> '', ':'=> '', '!'=> '', '?'=> '', '...'=> '', '´'=> '',
	'/'=> '', '^'=> '', '~'=> '', '®'=> '', '|'=> '', ','=> '', '<'=> '', '>'=> '', '{'=> '', '}'=> '',
	'['=> '', ']'=> '', ' '=> '_'
);

return strtr($texto, $characteres);

}

$total = 0;

$local = '/home/streaming/'.$_GET["login"].'';

$array_pastas[] = '/';

$dir = new DirectoryIterator($local);

foreach($dir as $file) {

if(!$file->isDot() && $file->isDir()) {

$array_pastas[] = $file->getFilename();

}

}

foreach($array_pastas as $pasta) {

$dir = new DirectoryIterator($local."/".$pasta);
foreach($dir as $file) {
if($file->isFile() && pathinfo($file->getFilename(), PATHINFO_EXTENSION) == "mp4") {

@rename($local."/".$pasta."/".$file->getFilename(),$local."/".$pasta."/".remover_caracteres($file->getFilename()));

$resultado .= "".$file->getFilename()." -> ".remover_caracteres($file->getFilename())."\n";

$total++;
}

}

}

echo $total."|".$resultado;

?>
