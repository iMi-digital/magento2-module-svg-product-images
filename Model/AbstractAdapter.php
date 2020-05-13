<?php
namespace IMI\SVGProductImages\Model;

use Magento\Framework\App\Filesystem\DirectoryList;

abstract class AbstractAdapter extends \Magento\Framework\Image\Adapter\AbstractAdapter
{
    /**
     * @var \Magento\Framework\Filesystem\Io\File
     */
    private $ioFile;

    public function __construct(
        \Magento\Framework\Filesystem\Io\File $ioFile,
        \Magento\Framework\Filesystem $filesystem,
        \Psr\Log\LoggerInterface $logger,
        array $data = [])
    {
        parent::__construct($filesystem, $logger, $data);
        $this->ioFile = $ioFile;
    }

    /**
     * Check - is this file an image
     *
     * @param string $filePath
     * @return bool
     * @throws \InvalidArgumentException
     * @throws \DomainException
     * @throws \BadFunctionCallException
     * @throws \RuntimeException
     * @throws \OverflowException
     */
    public function validateUploadFile($filePath)
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException('Upload file does not exist.');
        }

        if (filesize($filePath) === 0) {
            throw new \InvalidArgumentException('Wrong file size.');
        }

        try {
            $imageSize = getimagesize($filePath);
        } catch (\Exception $e) {
            $imageSize = false;
        }

        if (!$imageSize && $this->ioFile->getPathInfo($filePath)['extension'] !== 'svg') {
            throw new \InvalidArgumentException('Disallowed file type.');
        }
        $this->checkDependencies();
        $this->open($filePath);

        return $this->getImageType() !== null;
    }
}