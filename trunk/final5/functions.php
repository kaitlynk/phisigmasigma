<?php
function cropImage($path, $width, $height, $widthl, $heightl) {
	$extension = strrchr($path, '.');
  
    switch($extension)  
    {  
        case '.jpg':  
        case '.jpeg':  
            $img = imagecreatefromjpeg($_FILES['photo']['tmp_name']);  
            break;  
        case '.gif':  
            $img = imagecreatefromgif($_FILES['photo']['tmp_name']);  
            break;  
        case '.png':  
            $img = imagecreatefrompng($_FILES['photo']['tmp_name']);  
            break;  
        default:  
            $img = false;
            return 'error';
            break;
    }  
    
	$x = imagesx($img);
	$y = imagesy($img);

	if($x/$y > $width/$height) {
		$resizeHeight = $height;
		$resizeWidth = $x*$height/$y;
		$cropX = $resizeWidth/2 - $width/2;
		$cropY = 0;
	}
	else {
		$resizeWidth = $width;
		$resizeHeight = $y*$width/$x;
		$cropX = 0;
		$cropY = $resizeHeight/2 - $height/2;
	}

	if($x/$y > $widthl/$heightl) {
		$widthLarge = $widthl;
		$heightLarge = $y*$widthl/$x;
	}
	else {
		$heightLarge = $heightl;
		$widthLarge = $x*$heightl/$y;
	}

	$imageResized = imagecreatetruecolor($resizeWidth, $resizeHeight);  
	imagecopyresampled($imageResized, $img, 0, 0, 0, 0, $resizeWidth, $resizeHeight, $x, $y);  

	$imageCropped = imagecreatetruecolor($width , $height);
	imagecopyresampled($imageCropped, $imageResized , 0, 0, $cropX, $cropY, $width, $height , $width, $height);

	$imageLarge = imagecreatetruecolor($widthLarge, $heightLarge);  
	imagecopyresampled($imageLarge, $img, 0, 0, 0, 0, $widthLarge, $heightLarge, $x, $y);  

	switch($extension)  
	{  
	    case '.jpg':  
	    case '.jpeg':  
	        if (imagetypes() & IMG_JPG) { 
	        	imagejpeg($imageLarge, "photos/large_".$path, 100);  
	            imagejpeg($imageCropped, "photos/".$path, 100);  
	        }  
	        break;  

	    case '.gif':  
	        if (imagetypes() & IMG_GIF) { 
	        	imagegif($imageLarge, "photos/large_".$path);  
	            imagegif($imageCropped, "photos/".$path);  
	        }  
	        break;  
	    case '.png':   

	        if (imagetypes() & IMG_PNG) {  
	        	imagepng($imageLarge, "photos/large_".$path, 0); 
	            imagepng($imageCropped, "photos/".$path, 0);  
	        }  
	        break;  

	    default:  
	        // *** No extension - No save.  
	        break;  
	}  
    imagedestroy($imageResized);  
}
?>