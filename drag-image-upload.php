<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Untitled Page</title>
    <script src="jquery-1.7.2.min.js"></script>
    <script src="jquery-ui.min.js"></script>
    <script src="jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript" src="drag-image.js"></script>
</head>
<body>
<?php
function resample_image($source_file, $target_file, $src_real_height, $target_real_height, $outFileName) {
	$source_img = imagecreatefromjpeg($source_file);
	$target_img = imagecreatefromjpeg($target_file);
	list($src_width, $src_height) = getimagesize($source_file);
	list($tgt_width, $tgt_height) = getimagesize($target_file);
	
	$target_with_height_ratio = (float) $tgt_width/$tgt_height;
	$src_real_pixel_ratio = $src_height/$src_real_height;
	$target_real_pixel_ratio = $tgt_height/$target_real_height;
	$target_needed_height = $src_real_pixel_ratio * $target_real_height;
	$target_needed_width = $target_needed_height * $target_with_height_ratio;
	
	
	$target_new_image = imagecreatetruecolor($target_needed_width, $target_needed_height);
	imagecopyresampled($target_new_image,$target_img,0,0,0,0,$target_needed_width, $target_needed_height, $tgt_width, $tgt_height);
	
	imagejpeg($target_new_image, $outFileName);
	imagedestroy($target_new_image);
	imagedestroy($target_img);
	imagedestroy($source_img);
}

function set_avg_luminance($filename,$lum_req,$lum_orig,$outFileName) {
	$im = imagecreatefromjpeg($filename);

	if($im && imagefilter($im, IMG_FILTER_BRIGHTNESS, $lum_req-$lum_orig))
	{
		imagejpeg($im, $outFileName);
		imagedestroy($im);
	}
	else
	{
		echo 'Image brightness change failed.';
	}
}

function set_avg_luminance_1($filename,$lum_req,$lum_orig,$outFilePath) {
    $img = imagecreatefromjpeg($filename);

    $width = imagesx($img);
    $height = imagesy($img);


    for ($x=0; $x<$width; $x+=1) {
        for ($y=0; $y<$height; $y+=1) {

            $rgb = imagecolorat($img, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

			$rNew = (int)($r*$lum_req/$lum_orig);
			$gNew = (int)($g*$lum_req/$lum_orig);
			$bNew = (int)($b*$lum_req/$lum_orig);
			$rgbNew = $r;
			$rgbNew = $rgbNew <<8 | $gNew;
			$rgbNew = $rgbNew <<8 | $bNew;
			imagesetpixel ( $img,$x,$y,$rgbNew);
			// echo "<br/>";
			// echo "RNew : ";
			// echo $rNew; 
			// echo "<br/>";
			// echo $rgb;
			// echo "<br/>";
			// echo $rgbNew;
			// echo "<br/>";
            // choose a simple luminance formula from here
            // http://stackoverflow.com/questions/596216/formula-to-determine-brightness-of-rgb-color
        }
    }
	
	imagejpeg($img, $outFilePath );
	imagedestroy($img);

}
?>
<?php
function get_avg_luminance($filename, $num_samples=10) {
    $img = imagecreatefromjpeg($filename);

    $width = imagesx($img);
    $height = imagesy($img);

    $x_step = intval($width/$num_samples);
    $y_step = intval($height/$num_samples);

    $total_lum = 0;

    $sample_no = 1;

    for ($x=0; $x<$width; $x+=$x_step) {
        for ($y=0; $y<$height; $y+=$y_step) {

            $rgb = imagecolorat($img, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            // choose a simple luminance formula from here
            // http://stackoverflow.com/questions/596216/formula-to-determine-brightness-of-rgb-color
            $lum = ($r+$r+$b+$g+$g+$g)/6;

            $total_lum += $lum;

            $sample_no++;
        }
    }

    // work out the average
    $avg_lum  = $total_lum/$sample_no;
    return $avg_lum;
    // assume a medium gray is the threshold, #acacac or RGB(172, 172, 172)
    // this equates to a luminance of 170
}
?>
<?php
$artFilePath = "1.jpg";
$wallHeight = $_POST["image_height"];
$artHeight=2;
$wallImgHeight=1000;
$imgHeight=$wallImgHeight*$artHeight/$wallHeight;
?>
<div id="draggable2" style="float:left;">
<img src="<?php echo $artFilePath ?>" height="<?php echo $imgHeight?>"/>
</div>
<div id="draggable" onclick="testImage();">
<?php
$uploadedFilePath = "upload/" . $_FILES["camera_file"]["name"]; 
$artOutFilePath = "2.jpg";
move_uploaded_file($_FILES["camera_file"]["tmp_name"],$uploadedFilePath);
$upLoadedAvgLuminance = get_avg_luminance($uploadedFilePath,10);
$artOriginalLuminance = get_avg_luminance( $artFilePath,10);
set_avg_luminance($artFilePath,$upLoadedAvgLuminance , $artOriginalLuminance , $artOutFilePath );
resample_image($uploadedFilePath, $artOutFilePath, $wallHeight, $artHeight, $artOutFilePath);

?>
	<img src="<?php echo $artOutFilePath ?>" height="<?php echo $imgHeight?>"/>
    </div>
    <br /><br />
<div id="canDrop" accept="#draggable">
	<?php
	echo "<img src=\"upload/" .  $_FILES["camera_file"]["name"] ."\" width=\"" . $wallImgHeight .  "px\" />";
	?>
    <!--img src="IMG_20130713_213120.jpg" width="25%" height="30%" /-->
</div>

</html>
