<?php
namespace SPJ\GameBundle\Adapter;

interface ImageProcessingAdapterInterface
{
    public function resize($sourcePath, $destinationPath, $newWidth, $newHeight);
}
