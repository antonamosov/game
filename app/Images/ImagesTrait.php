<?php

namespace App\Images;

use Symfony\Component\HttpFoundation\File\UploadedFile;


trait ImagesTrait
{

    public function images($returnQuery = false, $tag = null)
    {
        $imagesQuery = Image::query();

        $imagesQuery->where('owner_class', $this->getTable())->where('owner_id', $this->id);

        if ($tag) {
            $imagesQuery->whereTag($tag);
        }

        if ($returnQuery) {
            return $imagesQuery;
        } else {
            return $imagesQuery->get();
        }
    }

    public function hasImage($tag = null)
    {
        $firstImage = $this->images(true, $tag)->first();

        return $firstImage ? true : false;
    }

    public function firstImage($tag = null)
    {
        $firstImage = $this->images(true, $tag)->first();

        if ($firstImage) {
            return $firstImage;
        } else {
            return new Image;
        }
    }

    public function nextImage($tag = null, $order = 1)
    {
        $images = $this->images(true, $tag)->get();
        $i = 0;

        foreach($images as $image)
        {
            $i++;
            if($order == $i)
            {
                return $image;
            }
        }
        return new Image;
    }


    public function image($tag = null)
    {
        return $this->firstImage($tag);
    }

    public function attachUploadedImage(UploadedFile $imageFile, $tag = null)
    {
        if (!$this->exists()) {
            throw new \Exception('Cant attach image - object not exists');
        }

        $image = new Image();

        $image->source = strtolower($imageFile->getClientOriginalExtension());

        $image->owner_class = $this->getTable();

        $image->owner_id = $this->id;

        $image->tag = $tag;

        $image->save();

        if (!\File::isDirectory(config()->get('images.path'))) {
            \File::makeDirectory(config()->get('images.path'));
        }

        $imageFile->move(config()->get('images.path'), $image->id . "." . $image->source);


        return $image;
    }

    public function deleteAllImages($tag = null)
    {
        $savedImages = $this->images();

        $this->images(true, $tag)->delete();

        return $savedImages;
    }

    public function flashImagesOwner()
    {
        \Session::put('images_owner', $this);
    }

    public function getImages($tag)
    {
        return $this->images(true, $tag);
    }

}
