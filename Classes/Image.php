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
        $image_url = $this->imagePath;
        $image_info = getimagesize($image_url);
        if ($image_info) {
            header('Content-type: ' . $image_info['mime']);
            readfile($image_url);
            return true;
        }
        return false;
    }
}