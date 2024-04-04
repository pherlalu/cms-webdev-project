<?php
session_start();


$captchaImage = generateCaptchaString();

header('Content-Type: image/png');
imagepng($captchaImage);
imagedestroy($captchaImage);
ob_flush();
flush();


function generateCaptchaString($length = 6)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $result = '';
  for ($i = 0; $i < $length; $i++) {
    $result .= $characters[mt_rand(0, strlen($characters) - 1)];
  }

  $image = imagecreatetruecolor(150, 50);
  $backgroundColor = imagecolorallocate($image, 255, 255, 255);
  $textColor = imagecolorallocate($image, 0, 0, 0);
  imagefilledrectangle($image, 0, 0, 150, 50, $backgroundColor);
  imagestring($image, 20, 50, 20, $result, $textColor);

  $_SESSION['captcha'] = $result;

  ob_start();
  imagepng($image);
  $imageString = ob_get_contents();
  ob_end_clean();
  $imageFileName = session_id() . '.png';
  $file = tempnam(sys_get_temp_dir(), 'captcha_');
  file_put_contents($file, $imageString);

  return $image;
}
