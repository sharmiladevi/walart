<?php

function set_avg_luminance_1($filename,$lum_req,$lum_orig,$outFileName) {
	$im = imagecreatefromjpeg($filename);

	if($im && imagefilter($im, IMG_FILTER_BRIGHTNESS, $lum_req-$lum_orig))
	{
		echo 'Image brightness changed.';

		imagepng($im, $outFileName);
		imagedestroy($im);
	}
	else
	{
		echo 'Image brightness change failed.';
	}
}
function set_avg_luminance($filename,$lum_req,$lum_orig,$outfilename) {
    $img = imagecreatefromjpeg($filename);

    $width = imagesx($img);
    $height = imagesy($img);

	

    for ($x=0; $x<$width; $x+=1) {
        for ($y=0; $y<$height; $y+=1) {

            $rgb = imagecolorat($img, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

			$rNew = $r*$lum_req/$lum_orig
			$gNew = $g*$lum_req/$lum_orig
			$bNew = $b*$lum_req/$lum_orig
			$rgbNew = $r
			$rgbNew = $rgbNew <<8 || $gNew
			$rgbNew = $rgbNew <<8 || $bNew
			imagesetpixel ( $img,$x,$y,$rgbNew)
            // choose a simple luminance formula from here
            // http://stackoverflow.com/questions/596216/formula-to-determine-brightness-of-rgb-color
        }
    }
	
	imagejpeg($img, $outfilename )
	imagedestroy($img);
}
?>