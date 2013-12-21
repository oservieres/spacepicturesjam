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

        $temporaryFileDirectory = sys_get_temp_dir() . "/tmp/img";

        $time = time();
        $imageFileName = $time . md5($file->getClientOriginalName() . $this->secret) . '.jpg';
        $miniatureFileName = $time . md5($file->getClientOriginalName() . 'miniature' . $this->secret) . '.jpg';

        $file->move($temporaryFileDirectory, $file->getClientOriginalName());
        $exifData = exif_read_data($temporaryFileDirectory . '/' . $file->getClientOriginalName());

        $this->imageFilter->resize(
            $temporaryFileDirectory . '/' . $file->getClientOriginalName(),
            $this->cdnLocalPath . '/' . $cdnSubDirectories . '/' . $imageFileName,
            1280,
            720
        );
        $this->imageFilter->resize(
            $temporaryFileDirectory . '/' . $file->getClientOriginalName(),
            $this->cdnLocalPath . '/' . $cdnSubDirectories . '/' . $miniatureFileName,
            128,
            72
        );

        unlink($temporaryFileDirectory . '/' . $file->getClientOriginalName());

        return array(
            'path' => 'content/' . $cdnSubDirectories . '/' . $imageFileName,
            'miniature_path' => 'content/' . $cdnSubDirectories . '/' . $miniatureFileName,
            'exif' => $exifData
        );
    }
}
