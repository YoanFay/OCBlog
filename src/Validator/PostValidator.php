<?php

namespace App\Src\Validator;

use App\Src\Entity\Post;
use App\Src\Repository\CategoryRepository;
use App\Src\Repository\UserRepository;

class PostValidator extends Validator
{

    private $post;

    public function __construct($post)
    {
        $this->post = $post;
        $this->error = [];
    }

    public function validate()
    {
        $this->content($this->post->getContent());
        $this->image($this->post->getImage());
        $this->category($this->post->getCategoryId());

        if ($this->error === []){
            return true;
        }

        return $this->error;
    }

    public function content($parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true){
            $this->error['content'][] = "L'article ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true){
            $this->error['content'][] = "L'article doit être une chaîne de caractère.";
        }
    }

    // TODO A voir quand le systeme pour les images sera fait
    public function image($parameter)
    {
        if (!empty($parameter)) {
            $array = explode('.', $parameter);
            $file_ext = strtolower(end($array));

            $ext = array("jpeg", "jpg", "png");
            if (in_array($file_ext, $ext) === false) {
                $this->error['image'] = "Le fichier doit être dans l'un des format suivant : .jpeg, .jpg ou .png";
            }
        }
    }

    public function createdAt($parameter)
    {
        if ($date = date_create_from_format('Y-m-d H:i:s', $parameter)){
            if ($date > new \DateTime()){
                $this->error['created_at'][] = "La date doit être inférieure ou égale à la date actuelle.";
            }
            if (!$this->intBetween($date->format('m'), 1, 12)){
                $this->error['created_at'][] = "Le mois doit être compris entre 1 et 12.";
            }
            if (!$this->intBetween($date->format('d'), 1, $date->format('t'))){
                $this->error['created_at'][] = "Le mois doit être compris entre 1 et ".$date->format('t').".";
            }
        }else{
            $this->error['created_at'][] = "La date doit être au format AAAA-MM-DD HH:MM:SS";
        }
    }

    public function publishedAt($parameter)
    {
        if ($parameter !== NULL) {
            if ($date = date_create_from_format('Y-m-d H:i:s', $parameter)){
                if ($date > new \DateTime()){
                    $this->error['published_at'][] = "La date doit être inférieure ou égale à la date actuelle.";
                }
                if (!$this->intBetween($date->format('m'), 1, 12)){
                    $this->error['published_at'][] = "Le mois doit être compris entre 1 et 12.";
                }
                if (!$this->intBetween($date->format('d'), 1, $date->format('t'))){
                    $this->error['published_at'][] = "Le mois doit être compris entre 1 et ".$date->format('t').".";
                }
            }else{
                $this->error['published_at'][] = "La date doit être au format AAAA-MM-DD HH:MM:SS";
            }
        }
    }

    public function updatedAt($parameter)
    {
        if ($parameter !== NULL) {
            if ($date = date_create_from_format('Y-m-d H:i:s', $parameter)){
                if ($date > new \DateTime()){
                    $this->error['updated_at'][] = "La date doit être inférieure ou égale à la date actuelle.";
                }
                if (!$this->intBetween($date->format('m'), 1, 12)){
                    $this->error['updated_at'][] = "Le mois doit être compris entre 1 et 12.";
                }
                if (!$this->intBetween($date->format('d'), 1, $date->format('t'))){
                    $this->error['updated_at'][] = "Le mois doit être compris entre 1 et ".$date->format('t').".";
                }
            }else{
                $this->error['updated_at'][] = "La date doit être au format AAAA-MM-DD HH:MM:SS";
            }
        }
    }

    public function deletedAt($parameter)
    {
        if ($parameter !== NULL) {
            if ($date = date_create_from_format('Y-m-d H:i:s', $parameter)){
                if ($date > new \DateTime()){
                    $this->error['deleted_at'][] = "La date doit être inférieure ou égale à la date actuelle.";
                }
                if (!$this->intBetween($date->format('m'), 1, 12)){
                    $this->error['deleted_at'][] = "Le mois doit être compris entre 1 et 12.";
                }
                if (!$this->intBetween($date->format('d'), 1, $date->format('t'))){
                    $this->error['deleted_at'][] = "Le mois doit être compris entre 1 et ".$date->format('t').".";
                }
            }else{
                $this->error['deleted_at'][] = "La date doit être au format AAAA-MM-DD HH:MM:SS";
            }
        }
    }

    public function excerpt($parameter)
    {
        if ($this->validateIsNotEmpty($parameter) !== true){
            $this->error['excerpt'][] = "Le chapô ne peut pas être vide.";
        }
        if ($this->validateIsString($parameter) !== true){
            $this->error['excerpt'][] = "Le chapô doit être une chaîne de caractère.";
        }
        if ($this->validateIsGranted($parameter, 70) !== true){
            $this->error['excerpt'][] = "Le chapô doit faire maximum 70 caractères.";
        }
    }

    public function category($parameter)
    {

        $categoryRepository = new CategoryRepository();

        $category = $categoryRepository->find($parameter);

        if ($category === null) {
            $this->error['category'][] = "La catégorie sélectionnée n'existe pas.";
        }
    }

    public function user($parameter)
    {
        $userRepository = new UserRepository();

        $user = $userRepository->find($parameter);

        if ($user == null) {
            $this->error['user'][] = "L'utilisateur n'existe pas.";
        }
    }

}