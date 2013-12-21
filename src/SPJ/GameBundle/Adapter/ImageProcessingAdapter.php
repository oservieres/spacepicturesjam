<?php
namespace SPJ\GameBundle\Adapter;

class ImageProcessingAdapter implements ImageProcessingAdapterInterface
{

    public function getSize($filePath)
    {
        return getimagesize($filePath);
    }

    public function resize($sourcePath, $destinationPath, $newWidth, $newHeight)
    {
        list($width, $height) = $this->getSize($sourcePath);
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
