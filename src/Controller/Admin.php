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


    /**
     * Affiche les informations de la page d'accueil ainsi que quelque statistique
     *
     * @return void
     */
    public function index()
    {
        $configRepository = new ConfigRepository();
        $postRepository = new PostRepository();
        $commentRepository = new CommentRepository();
        $config = $configRepository->findOne();

        if ($this->session->getAuth('level') < 60) {
            $this->redirectTo('/');
        }

        $post
            = [
            'all' => (count($postRepository->findAll() ?? [])),
            'publish' => (count($postRepository->findBy(['deleted_at' => "is null", 'published_at' => "is not null"]) ?? [])),
            'delete' => (count($postRepository->findBy(['deleted_at' => "is not null"]) ?? [])),
            'moderate' => (count($postRepository->findBy(['deleted_at' => "is null", 'published_at' => "is null"]) ?? [])),
        ];

        $comment
            = [
            'all' => (count($commentRepository->findAll() ?? [])),
            'publish' => (count($commentRepository->findBy(['deleted_at' => "is null", "validated_at" => "is not null"]) ?? [])),
            'delete' => (count($commentRepository->findBy(['deleted_at' => "is not null"]) ?? [])),
            'moderate' => (count($commentRepository->findBy(['deleted_at' => "is null", "validated_at" => "is null"]) ?? [])),
        ];

        $this->render(
            'admin/index',
            [
                "config" => $config,
                "post" => $post,
                "comment" => $comment
            ]
        );

        //end index()
    }


    /**
     * Formulaire permettant de modifier les informations de la page d'accueil
     *
     * @return void
     */
    public function updateConfig()
    {

        if ($this->session->getAuth('level') < 60) {
            $this->redirectTo('/');
        }
        $configRepository = new ConfigRepository();
        $config = $configRepository->findOne();

        $request = new Request();
        $configForm = new ConfigForm();

        if (!$this->valideForm($request, 'updateConfig', 'Admin/updateConfig')) {
            $token = uniqid(rand(), true);
            $this->session->setToken($token);
            $form = $configForm->updateConfig([], [], [], $config, $token);
            $this->render('admin/update', ['form' => $form->create()]);
            return;
        }


        $config->setTitle($request->get('post', 'title'));
        $config->setCatchPhrase($request->get('post', 'catchPhrase'));

        $configValidator = new ConfigValidator($config);
        $testConfig = $configValidator->validate();

        $testImage = $testCv = 'noChange';

        if ($request->get('file', 'image')['size'] > 0) {
            $fileValidator = new FileValidator(new File($request->get('file', 'image')));
            $testImage = $fileValidator->validateImage();
        }

        if ($request->get('file', 'cv')['size'] > 0) {
            $fileValidator = new FileValidator(new File($request->get('file', 'cv')));
            $testCv = $fileValidator->validatePdf();
        }

        if ($testConfig === true && ($testImage === true || $testImage === 'noChange') && ($testCv === true || $testCv === 'noChange')) {
            $uploadService = new UploadService();

            if ($testImage !== 'noChange' && $filename = $uploadService->uploadConfigImage(new File($request->get('file', 'image')))) {
                $config->setImage($filename);
            }

            if ($testCv !== 'noChange' && $filename = $uploadService->uploadConfigCv(new File($request->get('file', 'cv')))) {
                $config->setCv($filename);
            }

            $configRepository->update($config);
            $this->session->setFlash('success', "Les informations ont bien été modifiées");
            $this->redirectTo('/');
        }

        $token = uniqid(rand(), true);
        $this->session->setToken($token);
        $form = $configForm->updateConfig($testConfig, $testImage, $testCv, $config, $token);
        $this->render('admin/update', ['form' => $form->create()]);
    }


}
