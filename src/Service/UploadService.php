<?php

namespace App\Src\Service;

use App\Src\Core\Upload;

class UploadService
{

    static public function uploadPost($file)
    {
        $upload = new Upload($file, 'post');

        return $upload->addFile();
    }

    static public function uploadUser($file)
    {
        $upload = new Upload($file, 'user');

        return $upload->addFile();
    }

    static public function uploadConfigImage($file)
    {
        $upload = new Upload($file, 'config');

        return $upload->addFile();
    }

    static public function uploadConfigCv($file)
    {
        $upload = new Upload($file, 'config');

        return $upload->addPdf();
    }

    static public function uploadDefaultUser($firstname, $lastname)
    {
       $upload = new Upload(null, 'user');

       return $upload->addFileByUrl('https://ui-avatars.com/api/?name='.$firstname.'+'.$lastname.'&background=random&format=png');
    }

}