<?php
$time_start = microtime(true); 
include_once("functions.inc.php");
include_once("config.inc.php");

//$img = new Imagick('/path/to/file');
//autorotate($img);
//$img->stripImage(); // if you want to get rid of all EXIF data
//$img->writeImage();
$progVersion="v2.0-PHP";
$phpVersion=phpversion();
$rawDir="raw/";
$outDir="resized/";

echo "ImageProc ".$progVersion." - PHP ".$phpVersion."\n\n\n";

$dateInput=readline("Current Date (press enter for ".date('mdy')."): ");
$startNumInput=readline("Starting Number: ");

if (empty($dateInput)) {
    $dateInput=date('mdy');
}
if (empty($startNumInput)) {
    $startNumInput="1";
}
echo "\n";
foreach(glob($rawDir.'*.{jpg,JPG,jpeg,JPEG}',GLOB_BRACE) as $filename){
    $outputName=basename($filename);
    $outImgFile=sprintf("%s/%s-%04d.jpg",$outDir, $dateInput, $startNumInput);
    echo "#";
    $img=new Imagick($filename);
    autorotate($img);
    $img->stripImage();
    // This is kinda slow sometimes, so we'll try using scaleImage instead
    //$img->resizeImage($imgWidth, $imgHeight, imagick::FILTER_CATROM, 1);
    $img->scaleImage($imgWidth, $imgHeight, FALSE);
    $img->setImageCompressionQuality($imgQuality);
    $img->writeImage($outImgFile);
    $img->destroy();
    $startNumInput++;
}
echo "\n\nTotal Runtime: ".ceil((microtime(true) - $time_start))." seconds";
echo "\n";
readline("");
?>