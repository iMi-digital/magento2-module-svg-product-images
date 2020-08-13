<?php

namespace IMI\SVGProductImages;

use Magento\Framework\File\Mime;
use Magento\Framework\Image\Adapter\ImageMagick;

class SVGImageMagickAdapter extends ImageMagick
{
    /**
     * @var Mime
     */
    private $mime;

    public function __construct(
        \Magento\Framework\Filesystem $filesystem,
        \Psr\Log\LoggerInterface $logger, array $data = [],
        Mime $mime
    )
    {
        parent::__construct($filesystem, $logger, $data);
        $this->mime = $mime;
    }

    /**
     * Add basic SVG validation
     *
     * @param string $filePath
     *
     * @return bool
     */
    public function validateUploadFile($filePath)
    {
        //Bug in getMimeType method found: Returns 'image/svg' in case of no file extension. See \Magento\Framework\File\Mime::getMimeType
        if ($this->mime->getMimeType($filePath) === 'image/svg+xml' || $this->mime->getMimeType($filePath) === 'image/svg') {
            return true;
        }
        return parent::validateUploadFile($filePath);
    }

    private function getNotImplementedMessage($method)
    {
        return sprintf(
            '%s is intentionally not implemented for SVG files, processing is not believed not to be needed for SVGs. Filename = %s',
            $method, $this->_fileName
        );
    }

    /**
     * We skip most logic for SVGs, as ImageMagick can not reliabily handle them on all systems, and things like
     * resizing just don't make sense.
     *
     * Pull requests welcome, if needed, to improve this / make it configurable.
     *
     * @param $method
     * @return bool
     */
    private function skipForSvg($method)
    {
        if (!isset($this->_fileName)) {
            return false;
        }
        if (strtolower(pathinfo($this->_fileName, PATHINFO_EXTENSION)) == 'svg' ){
            $this->logger->debug($this->getNotImplementedMessage($method));

            return true;
        }
        return false;
    }

    public function open($fileName)
    {
        $this->_fileName = $fileName;

        if ($this->skipForSvg(__METHOD__)) {
            return;
        }

        return parent::open($fileName);
    }

    public function save($destination = null, $newName = null)
    {
        if ($this->skipForSvg(__METHOD__)) {
            return;
        }

        return parent::save($destination, $newName);
    }

    public function getImage()
    {
        if ($this->skipForSvg(__METHOD__)) {
            return;
        }

        return parent::getImage();
    }

    public function resize($width = null, $height = null)
    {
        if ($this->skipForSvg(__METHOD__)) {
            return;
        }

        return parent::resize($width, $height);
    }

    public function rotate($angle)
    {
        if ($this->skipForSvg(__METHOD__)) {
            return;
        }

        return parent::rotate($angle);
    }

    public function crop($top = 0, $left = 0, $right = 0, $bottom = 0)
    {
        if ($this->skipForSvg(__METHOD__)) {
            return;
        }

        return parent::crop($top, $left, $right, $bottom);
    }

    public function watermark($imagePath, $positionX = 0, $positionY = 0, $opacity = 30, $tile = false)
    {
        if ($this->skipForSvg(__METHOD__)) {
            return;
        }

        return parent::watermark($imagePath, $positionX, $positionY, $opacity, $tile);
    }

    public function checkDependencies()
    {
        if ($this->skipForSvg(__METHOD__)) {
            return;
        }

        parent::checkDependencies();
    }

    public function createPngFromString($text, $font = '')
    {
        if ($this->skipForSvg(__METHOD__)) {
            return;
        }

        return parent::createPngFromString($text, $font);
    }

    public function refreshImageDimensions()
    {
        if ($this->skipForSvg(__METHOD__)) {
            return;
        }

        return parent::refreshImageDimensions();
    }

    public function getColorAt($x, $y)
    {
        if ($this->skipForSvg(__METHOD__)) {
            return;
        }

        return parent::getColorAt($x, $y);
    }
}
