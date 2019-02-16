<?php
function remover_caracteres($texto) {

$characteres = array(
    'S'=>'S', 's'=>'s', '�'=>'Dj','Z'=>'Z', 'z'=>'z', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A',
    '�'=>'A', '�'=>'A', '�'=>'C', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'E', '�'=>'I', '�'=>'I', '�'=>'I',
    '�'=>'I', '�'=>'N', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'U', '�'=>'U',
    '�'=>'U', '�'=>'U', '�'=>'Y', '�'=>'B', '�'=>'Ss','�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a', '�'=>'a',
    '�'=>'a', '�'=>'a', '�'=>'c', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'e', '�'=>'i', '�'=>'i', '�'=>'i',
    '�'=>'i', '�'=>'o', '�'=>'n', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'o', '�'=>'u',
    '�'=>'u', '�'=>'u', '�'=>'y', '�'=>'y', '�'=>'b', '�'=>'y', 'f'=>'f', '�'=> '', '�'=> '', '&'=> 'e',
	'�'=> '', '�'=> '', '$'=> '', '%'=> '', '�'=> '', '�'=> '', '�'=> '', '�'=> '', '�'=> '', 'ã'=> '',
	'('=> '', ')'=> '', "'"=> '', '@'=> '', '='=> '', ':'=> '', '!'=> '', '?'=> '', '...'=> '', '�'=> '',
	'/'=> '', '^'=> '', '~'=> '', '�'=> '', '|'=> '', ','=> '', '<'=> '', '>'=> '', '{'=> '', '}'=> '',
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
