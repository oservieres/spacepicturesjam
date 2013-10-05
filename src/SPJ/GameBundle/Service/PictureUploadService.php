<?php
namespace SPJ\GameBundle\Service;

use Symfony\Component\HttpFoundation\File\Exception\UploadException;

/**
 * PictureUploadService
 */
class PictureUploadService
{
    protected $cdnLocalPath;

    public function __construct($cdnLocalPath)
    {
        $this->cdnLocalPath = $cdnLocalPath;
    }

    public function upload($file)
    {
        if (null === $file) {
            throw new UploadException('Picture is mandatory');
        }

        $file->move($this->cdnLocalPath, $file->getClientOriginalName());

        return array(
            'path' => $file->getClientOriginalName(),
            'miniature_path' => ''
        );
    }
}
