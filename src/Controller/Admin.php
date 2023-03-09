<?php

namespace App\Src\Controller;

use App\Src\Entity\File;
use App\Src\Form\ConfigForm;
use App\Src\Repository\CommentRepository;
use App\Src\Repository\ConfigRepository;
use App\Src\Repository\PostRepository;
use App\Src\Service\UploadService;
use App\Src\Validator\ConfigValidator;
use App\Src\Validator\FileValidator;

class Admin extends Controller
{

    public function index()
    {
        $configRepository = new ConfigRepository();
        $postRepository = new PostRepository();
        $commentRepository = new CommentRepository();
        $config = $configRepository->findOne();

        if (Session::getAuth('level') < 60) {
            header('Location: /');
        }

        $post = [
            'all' => count($postRepository->findAll()),
            'publish' => count($postRepository->findBy(['deleted_at' => "is null", "published_at" => "is not null"])),
            'delete' => count($postRepository->findBy(['deleted_at' => "is not null"])),
            'moderate' => count($postRepository->findBy(['deleted_at' => "is null", "published_at" => "is null"]))
        ];

        $comment = [
            'all' => count($commentRepository->findAll()),
            'publish' => count($commentRepository->findBy(['deleted_at' => "is null", "validated_at" => "is not null"])),
            'delete' => count($commentRepository->findBy(['deleted_at' => "is not null"])),
            'moderate' => count($commentRepository->findBy(['deleted_at' => "is null", "validated_at" => "is null"]))
        ];

        $this->render('admin/index', [
            "config" => $config,
            "post" => $post,
            "comment" => $comment
        ]);
    }

    public function updateConfig()
    {

        if (Session::getAuth('level') < 60) {
            header('Location: /');
        }
        $configRepository = new ConfigRepository();
        $config = $configRepository->findOne();
        $request = new Request();
        $testConfig = [];
        $testImage = [];
        $testCv = [];

        if ($this->valideForm($request, 'updateConfig', 'Admin/updateConfig/' . $config->getId())) {

            $config->setTitle($request->get('post', 'title'));
            $config->setCatchPhrase($request->get('post', 'catchPhrase'));

            $configValidator = new ConfigValidator($config);

            $testConfig = $configValidator->validate();

            if ($request->get('file', 'image')['size'] > 0) {

                $image = new File($request->get('file', 'image'));

                $fileValidator = new FileValidator($image);

                $testImage = $fileValidator->validateImage();
            } else {
                $testImage = 'noChange';
            }

            if ($request->get('file', 'cv')['size'] > 0) {

                $cv = new File($request->get('file', 'cv'));

                $fileValidator = new FileValidator($cv);

                $testCv = $fileValidator->validatePdf();
            } else {
                $testCv = 'noChange';
            }

            if ($testConfig === true && ($testImage === true || $testImage === 'noChange') && ($testCv === true || $testCv === 'noChange')) {

                if ($testImage !== 'noChange' && $image->getName()) {

                    if ($filename = UploadService::uploadConfigImage($image)) {
                        $config->setImage($filename);
                    } else {
                        Session::setFlash('danger', "Un problème est survenue lors du transfert de l'image");
                    }
                }

                if ($testCv !== 'noChange' && $cv->getName()) {

                    if ($filename = UploadService::uploadConfigCv($cv)) {
                        $config->setCv($filename);
                    } else {
                        Session::setFlash('danger', "Un problème est survenue lors du transfert du pdf");
                    }
                }

                $configRepository->update($config);

                Session::setFlash('success', "Les informations ont bien été modifiées");
                header('Location: /');
            }
        }

        $configForm = new ConfigForm();

        $token = uniqid(rand(), true);
        Session::setToken($token);

        $form = $configForm->updateComment($testConfig, $testImage, $testCv, $config, $token);

        $this->render('admin/update', [
            'form' => $form->create(),
        ]);

    }

}
