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
     *
     * @return false|string
     */
    public function uploadPost(File $file)
    {
        $upload = new Upload($file, 'post');

        return $upload->addFile();
    }

    /**
     * @param File $file parameter
     *
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
     *
     * @return false|string
     */
    public function uploadDefaultUser(string $firstname, string $lastname)
    {
        $upload = new Upload(null, 'user');

        return $upload->addFileByUrl('https://ui-avatars.com/api/?name='.$firstname.'+'.$lastname.'&background=random&format=png');
    }

    /**
     * @param array|bool $testConfig parameter
     * @param array|bool $testImage  parameter
     * @param array|bool $testCv     parameter
     * @param Config     $config     parameter
     * @param Session    $session    parameter
     *
     * @return bool
     */
    public function UploadWithCheck($testConfig, $testImage, $testCv, Config $config, Session $session): bool
    {
        $configRepository = new ConfigRepository();

        if ($testConfig && in_array($testImage, [true, 'noChange']) && in_array($testCv, [true, 'noChange'])) {
            $config->setImage($this->uploadGetFilename('image', $testImage, $config));
            $config->setCv($this->uploadGetFilename('cv', $testCv, $config));

            $configRepository->update($config);
            $session->setFlash('success', "Les informations ont bien été modifiées");
            return true;
        }
        return false;

    }

    /**
     * @param string $choice parameter
     * @param string $test   parameter
     * @param Config $config parameter
     *
     * @return false|string|null
     */
    public function uploadGetFilename(string $choice, string $test, Config $config)
    {
        $request = new Request();

        if ($test === "noChange") {
            switch ($choice) {
            case 'image':
                return $config->getImage();
            case 'cv':
                return $config->getCv();
            default:
                return null;
            }
        }

        return $this->uploadConfig(new File($request->get('file', $choice)), $choice);


    }

    /**
     * @param File   $file   parameter
     * @param string $choice parameter
     *
     * @return false|string
     */
    public function uploadConfig(File $file, string $choice)
    {
        $upload = new Upload($file, 'config');

        switch ($choice) {
        case 'image':
            return $upload->addFile();
        case 'cv':
            return $upload->addPdf();
        }

    }

}
