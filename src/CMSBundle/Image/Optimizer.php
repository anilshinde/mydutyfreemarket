<?php
namespace CMSBundle\Image;

/**
 * Image cropper, resizer and optimizer
 *
 * @author Joachim Ifergan
 * @category Manager
 */
class Optimizer
{

    private $pathToLocalImage;
    private $smallSize;
    private $mediumSize;
    private $bigSize;


    public function __construct($pathToLocalImage, $smallSize, $mediumSize, $bigSize)
    {
        $this->pathToLocalImage = $pathToLocalImage;
        $this->smallSize = $smallSize;
        $this->mediumSize = $mediumSize;
        $this->bigSize = $bigSize;
    }

    /**
     * Crop, resize and optimize an image to specified sizes
     *
     * @sourcePath Image source local path
     * @sizes Array of sizes requested in result
     */
    public function generateResizedImages($sourcePath, $sizes) {


        $pathinfo = pathinfo($sourcePath);
        if(!in_array($pathinfo['extension'], array('jpg', 'png'))) {
            return NULL;
        }

        $allNewImageFiles = array();
        foreach($sizes as $size) {

            list($width, $height) = $size;
            $imageSource = new \Imagick($this->pathToLocalImage.'/'.$pathinfo['basename']);
            $isImageResized = FALSE;

            try {
                $imageSource->cropThumbnailImage($width, $height);
                $imageSource->stripImage();
                $imageSource->setInterlaceScheme(\Imagick::INTERLACE_PLANE);
                $imageSource->setImageCompressionQuality(85);

                $newImageFile = substr($sourcePath, 0 , strrpos($sourcePath, '.', -1)).'-'.($width).'x'.($height).'.'.$pathinfo['extension'];
                $allNewImageFiles[] = $newImageFile;
                $imageSource->writeImage($this->pathToLocalImage.'/'.$newImageFile);
                $imageSource->destroy();
                $isImageResized = TRUE;
            } catch(Exception $e) {
                die('Unable to resize image "'.$entity->getImageSource().'" using sizes '.$width.'-'.$height.' : '.$e->getMessage());
            }
        }
        return $allNewImageFiles;

    }
}
