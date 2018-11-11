<?php
    if (!isset($_GET["referer"])) {
        exit();
    }
    $referrer = $_GET["referer"];
    $admissibleURIs = array("signin", "signup", "restore");
    if (!in_array($referrer, $admissibleURIs)) {
        exit();
    }
    require_once("../../php/authLibrary.php");
    $captcha = startCaptchaSession($referrer);
    
    header('Content-Type: image/png');
    $width = 207;
    $height = 50;

    $image = imagecreatetruecolor($width, $height);
    $background_color = imagecolorallocate($image, 255, 255, 255);
    imagefilledrectangle($image, 0, 0, $width, $height, $background_color);
    $line_color = imagecolorallocate($image, 64, 64, 64);
    for ($i = 0; $i < 10; $i++) {
        imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $line_color);
    }
    
    for ($i = 0; $i < 1000; $i++) {
        $pixel_color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
        imagesetpixel($image, rand(0, $width), rand(0, $height), $pixel_color);
    }

    $fontNames = array("../../captcha_fonts/chunkfive.otf",
                       "../../captcha_fonts/grandhotel.otf",
                       "../../captcha_fonts/kaushan.otf",
                       "../../captcha_fonts/pacifico.ttf",
                       "../../captcha_fonts/tusj.ttf");

    $colors = array(array(89, 0, 0),
                    array(21, 81, 27),
                    array(20, 34, 80),
                    array(86, 60, 16));
    $x_pos = 25+rand(-5,5);
    for ($i = 0; $i < strlen($captcha); $i++) {
        $rgb = $colors[rand(0, count($colors)-1)];
        $letterColor = imagecolorallocate($image, $rgb[0], $rgb[1], $rgb[2]);
        putenv('GDFONTPATH='.realpath('.'));
        imagettftext($image, 22+rand(-3,3), rand(-45,45), $x_pos, rand(35,40), $letterColor, $fontNames[rand(0,count($fontNames)-1)], $captcha[$i]);
        $x_pos = $x_pos + rand(22, 30);
    }
    imagepng($image);
    imagedestroy($image);    
?>