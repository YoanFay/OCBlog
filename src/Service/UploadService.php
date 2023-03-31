<?php

namespace App\Src\Service;

use App\Src\Controller\Request;
use App\Src\Controller\Session;
use App\Src\Core\Upload;
use App\Src\Entity\Config;
use App\Src\Entity\File;
use App\Src\Repository\ConfigRepository;

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
     * @param string $firstname parameter
     * @param string $lastname  parameter
     * @return false|string
     */
    public function uploadDefaultUser(string $firstname, string $lastname)
    {
        $upload = new Upload(null, 'user');

        return $upload->addFileByUrl('https://ui-avatars.com/api/?name='.$firstname.'+'.$lastname.'&background=random&format=png');
    }

    /**
     * @param array|bool $testConfig
     * @param array|bool $testImage
     * @param array|bool $testCv
     * @param Config     $config
     * @param Session    $session
     * @return bool
     */
    public function UploadWithCheck($testConfig, $testImage, $testCv, Config $config, Session $session): bool
    {
        $request = new Request();
        $configRepository = new ConfigRepository();

        if ($testConfig === true && ($testImage === true || $testImage === 'noChange') && ($testCv === true || $testCv === 'noChange')) {

            if ($testImage !== 'noChange' && $filename = $this->uploadConfigImage(new File($request->get('file', 'image')))) {
                $config->setImage($filename);
            }

            if ($testCv !== 'noChange' && $filename = $this->uploadConfigCv(new File($request->get('file', 'cv')))) {
                $config->setCv($filename);
            }

            $configRepository->update($config);
            $session->setFlash('success', "Les informations ont bien été modifiées");
            return true;
        }
        return false;
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

}
