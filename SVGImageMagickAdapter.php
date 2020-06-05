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
}
