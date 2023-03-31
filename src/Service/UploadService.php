<?php

namespace App\Src\Service;

use App\Src\Core\Upload;
use App\Src\Entity\File;

class UploadService
{


    /**
     * @param File $file parameter
     * @return false|string
     */
    public function uploadPost(File $file)
    {
        $upload = new Upload($file, 'post');

        return $upload->addFile();
    }

    /**
     * @param File $file parameter
     * @return false|string
     */
    public function uploadUser(File $file)
    {
        $upload = new Upload($file, 'user');

        return $upload->addFile();
    }

    /**
     * @param File $file parameter
     * @return false|string
     */
    public function uploadConfigImage(File $file)
    {
        $upload = new Upload($file, 'config');

        return $upload->addFile();
    }

    /**
     * @param File $file parameter
     * @return false|string
     */
    public function uploadConfigCv(File $file)
    {
        $upload = new Upload($file, 'config');

        return $upload->addPdf();
    }

    /**
     * @param string $firstname parameter
     * @param string $lastname  parameter
     * @return false|string
     */
    public function uploadDefaultUser(string $firstname, string $lastname)
    {
        $upload = new Upload(null, 'user');

        return $upload->addFileByUrl('https://ui-avatars.com/api/?name='.$firstname.'+'.$lastname.'&background=random&format=png');
    }

}