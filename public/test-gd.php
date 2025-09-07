<?php
if (extension_loaded('gd')) {
    echo "GD extension is loaded.";
    
    // Test membuat gambar sederhana
    $im = imagecreate(100, 100);
    $white = imagecolorallocate($im, 255, 255, 255);
    $black = imagecolorallocate($im, 0, 0, 0);
    imagestring($im, 5, 10, 30, 'GD OK', $black);
    header('Content-Type: image/png');
    imagepng($im);
    imagedestroy($im);
} else {
    echo "GD extension is NOT loaded.";
}
?>