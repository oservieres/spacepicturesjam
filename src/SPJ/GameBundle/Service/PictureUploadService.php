<?php
namespace SPJ\GameBundle\Service;

use Symfony\Component\HttpFoundation\File\Exception\UploadException;

/**
 * PictureUploadService
 */
class PictureUploadService
{
    protected $cdnLocalPath;
    protected $secret;
    protected $rootDir;
    protected $imageFilter;

    public function __construct($imageFilter, $rootDir, $cdnLocalPath, $secret)
    {
        $this->cdnLocalPath = $cdnLocalPath . '/content';
        $this->secret = $secret;
        $this->imageFilter = $imageFilter;
        $this->rootDir = $rootDir;
    }

    public function upload($file)
    {
        if (null === $file) {
            throw new UploadException('Picture is mandatory');
        }

        $fileNameMd5 = md5($file->getClientOriginalName());
        $cdnSubDirectories = substr($fileNameMd5, 0, 2) . '/'
                           . substr($fileNameMd5, 2, 2);

        if (false === is_dir($this->cdnLocalPath . '/' . $cdnSubDirectories)) {
            mkdir($this->cdnLocalPath . '/' . $cdnSubDirectories, 0777, true);
        }

        $temporaryFileDirectory = $this->rootDir . "/tmp/img";

        $imageFileName = md5($file->getClientOriginalName() . $this->secret) . '.jpg';
        $miniatureFileName = md5($file->getClientOriginalName() . 'miniature' . $this->secret) . '.jpg';
        $blurredMiniatureFileName = md5($file->getClientOriginalName() . 'blur' . $this->secret) . '.jpg';

        $file->move($temporaryFileDirectory, $file->getClientOriginalName());

        $this->imageFilter->resize(
            $temporaryFileDirectory . '/' . $file->getClientOriginalName(),
            $this->cdnLocalPath . '/' . $cdnSubDirectories . '/' . $imageFileName,
            1280
        );
        $this->imageFilter->resize(
            $temporaryFileDirectory . '/' . $file->getClientOriginalName(),
            $this->cdnLocalPath . '/' . $cdnSubDirectories . '/' . $miniatureFileName,
            120
        );
        $this->imageFilter->blur(
            $this->cdnLocalPath . '/' . $cdnSubDirectories . '/' . $miniatureFileName,
            $this->cdnLocalPath . '/' . $cdnSubDirectories . '/' . $blurredMiniatureFileName
        );

        return array(
            'path' => $cdnSubDirectories . '/' . $imageFileName,
            'miniature_path' => $cdnSubDirectories . '/' . $miniatureFileName,
            'blurred_miniature_path' => $cdnSubDirectories . '/' . $blurredMiniatureFileName
        );
    }
}
