<?php
namespace SPJ\GameBundle\Service;

/**
 * ImageFilterService
 */
class ImageFilterService
{

    public function resize($sourcePath, $destinationPath, $maxWidth, $maxHeight)
    {
        list($width, $height) = getimagesize($sourcePath);

        $newWidth = $maxWidth;
        $newHeight = $height * $maxWidth / $width;
        if ($newHeight > $maxHeight) {
            $newWidth = $width * $maxHeight / $height;
            $newHeight = $maxHeight;
        }

        $originalImage = imagecreatefromjpeg($sourcePath);
        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled(
            $resizedImage,
            $originalImage,
            0, 0, 0, 0,
            $newWidth,
            $newHeight,
            $width,
            $height
        );
        imagejpeg($resizedImage, $destinationPath, 100);
    }

}
