<?php

namespace App\Src\Service;

class UploadService
{

    private const image_post_path = "img/post/";

    //TODO: Faire un Core/Upload quand j'en aurais besoin
    static public function uploadPost($file)
    {

        $filename = uniqid("post_") . "." . pathinfo($file->getName(), PATHINFO_EXTENSION);

        try {
            move_uploaded_file($file->getTmpName(), self::image_post_path . $filename);
        } catch (\Exception $e) {
            return false;
        }

        return $filename;
    }

}