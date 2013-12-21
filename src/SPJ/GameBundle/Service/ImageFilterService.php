<?php
namespace SPJ\GameBundle\Service;

use SPJ\GameBundle\Adapter\ImageProcessingAdapterInterface;

class ImageFilterService
{
    protected $imageProcesssingAdapter;

    public function __construct(ImageProcessingAdapterInterface $imageProcesssingAdapter)
    {
        $this->imageProcesssingAdapter = $imageProcesssingAdapter;
    }

    public function resize($sourcePath, $destinationPath, $maxWidth, $maxHeight)
    {
        list($width, $height) = $this->imageProcesssingAdapter->getSize($sourcePath);

        $newWidth = $maxWidth;
        $newHeight = $height * $maxWidth / $width;
        if ($newHeight > $maxHeight) {
            $newWidth = $width * $maxHeight / $height;
            $newHeight = $maxHeight;
        }

        $this->imageProcesssingAdapter->resize(
            $sourcePath,
            $destinationPath,
            $newWidth,
            $newHeight
        );
    }

}
