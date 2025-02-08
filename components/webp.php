

<?php

function jpg($source_file, $destination_file, $compression_quality = 100)
{
    $image = imagecreatefromjpeg($source_file);
    $result = imagewebp($image, $destination_file, $compression_quality);
    if (false === $result) {
        return false;
    }
    imagedestroy($image);
    return $destination_file;
}

//echo hs_jpg2webp('img/a.jpg','img/b.webp',100);

function png($source_file, $destination_file, $compression_quality = 100)
{
    $image = imagecreatefrompng($source_file);
    imagepalettetotruecolor($image);
    imagealphablending($image, true);
    imagesavealpha($image, true);
    $result = imagewebp($image, $destination_file, $compression_quality);
    if (false === $result) {
        return false;
    }
    imagedestroy($image);
    return $destination_file;
}


//echo png('img/a.png','img/b.webp',100);




?>
