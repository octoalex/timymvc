<?php


namespace Core;


use Exception;

class Image
{

    private $file;
    private $image_type;
    /**
     * @var string
     */
    private $filename;
    /**
     * @var false|resource
     */
    private $image;

    public function __construct($file)
    {
        $this->file = $file;
        $this->upload();
    }

    public function getFileName(){
        return basename($this->filename);
    }


    private function upload()
    {
        $path = ROOT . "/public/repository/photos/";
        $tmp = explode('.', basename($this->file['name']));
        $extension = end($tmp);
        $path = $path . md5(basename($this->file['name'])) . '.' . $extension;
        $this->filename = $path;
        try {
            move_uploaded_file($this->file['tmp_name'], $path);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $this;
    }

    public function load()
    {
        $image_info = getimagesize($this->filename);
        $this->image_type = $image_info[2];

        if ($this->image_type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($this->filename);
        } elseif ($this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($this->filename);
        } elseif ($this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($this->filename);
        } else {
            throw new Exception("The file you're trying to open is not supported");
        }
        return $this;
    }

    public function saveThumb($filename = '', $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = 755)
    {
        if ($filename === '') {
            $filename = str_replace('photos', 'thumbs', $this->filename);
        } else {
            $filename = ROOT . '/public/repository/thumbs/' . $filename;
        }
        $this->resizeToWidth(100);
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image, $filename);
        }

        if ($permissions != null) {
            chmod($filename, $permissions);
        }
    }


    public function save($filename = '', $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = null)
    {
        if ($filename === '') {
            $filename = $this->filename;
        }
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image, $filename);
        }

        if ($permissions != null) {
            chmod($filename, $permissions);
        }
    }

    public function output($image_type = IMAGETYPE_JPEG, $quality = 80)
    {
        if ($image_type == IMAGETYPE_JPEG) {
            header("Content-type: image/jpeg");
            imagejpeg($this->image, null, $quality);
        } elseif ($image_type == IMAGETYPE_GIF) {
            header("Content-type: image/gif");
            imagegif($this->image);
        } elseif ($image_type == IMAGETYPE_PNG) {
            header("Content-type: image/png");
            imagepng($this->image);
        }
    }

    public function getWidth()
    {
        return imagesx($this->image);
    }

    public function getHeight()
    {
        return imagesy($this->image);
    }

    public function resizeToHeight($height)
    {
        $ratio = $height / $this->getHeight();
        $width = round($this->getWidth() * $ratio);
        $this->resize($width, $height);
    }

    public function resizeToWidth($width)
    {
        $ratio = $width / $this->getWidth();
        $height = round($this->getHeight() * $ratio);
        $this->resize($width, $height);
    }


    public function resize($width, $height)
    {
        $new_image = imagecreatetruecolor($width, $height);

        imagecolortransparent($new_image, imagecolorallocate($new_image, 0, 0, 0));
        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);

        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }
}
