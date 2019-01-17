<?php

namespace IMI\SVGProductImages\Plugin\File;

class UploaderPlugin
{

    public function aroundSetAllowedExtensions(\Magento\Framework\File\Uploader $subject, \Closure $proceed,  $extensions = [])
    {
        if (!in_array('svg', $extensions)) {
            $extensions[] = 'svg';
        }

        return $proceed($extensions);
    }
}