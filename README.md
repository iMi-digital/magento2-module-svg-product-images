IMI_SVGProductImages
====================

Simple, yet hacky, plugin to allow SVG files for product images.


https://magento.stackexchange.com/questions/182535/how-can-i-upload-svg-files-as-magento-product-images/182617#182617

Note, that this module overrides the regular image adapter's validateUploadFile() method, meaning the checks done otherwise will not be executed for svg images.