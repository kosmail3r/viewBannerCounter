<?php
namespace Classes;

class Image
{
    /**
     * @var  - name of file
     */
    protected $imageName;

    public function __construct($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    /**
     * Method show image if file exist
     */
    public function showImage()
    {
        $imageUrl = $this->imagePath;
        $imageInfo = getimagesize($imageUrl);
        if ($imageInfo) {
            header('Content-type: ' . $imageInfo['mime']);
            readfile($imageUrl);
            return true;
        }
        return false;
    }
}