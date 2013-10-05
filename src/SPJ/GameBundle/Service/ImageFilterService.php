<?php
namespace SPJ\GameBundle\Service;

/**
 * ImageFilterService
 */
class ImageFilterService
{

    protected function getFileExtension($fileName)
    {
        return pathinfo($fileName, PATHINFO_EXTENSION);
    }

    public function resize($sourcePath, $destinationPath, $newWidth = 1280)
    {
        list($width, $height) = getimagesize($sourcePath);
        $newHeight = $height * $newWidth / $width;

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

    public function blur($sourcePath, $destinationPath)
    {
        $image = imagecreatefromjpeg($sourcePath);
        imagefilter($image, IMG_FILTER_SMOOTH, -4);
        imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);
        imagejpeg($image, $destinationPath, 100);
    }

}
