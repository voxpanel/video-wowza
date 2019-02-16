<?php
// Classe para gerar trumb de um video MP4
class VideoTile
{
    public static function createMovieThumb($srcFile, $destFile)
    {
        // Change the path according to your server.
        $ffmpeg_path = '/usr/local/bin/';

        $output = array();

        $cmd = sprintf('%sffmpeg -i %s -an -ss 00:00:05 -r 1 -vframes 1 -y %s',
            $ffmpeg_path, $srcFile, $destFile);

        exec($cmd, $output, $retval);

        if ($retval) {
            return false;
                } else {
                        list($width, $height) = getimagesize($destFile);
                        $src = imagecreatefromjpeg($destFile);
                        $tmp = imagecreatetruecolor($width, $height);
                        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $width, $height, $width, $height);
                        imagejpeg($tmp, $destFile, 30);
                }

        return $destFile;
    }
}
?>
