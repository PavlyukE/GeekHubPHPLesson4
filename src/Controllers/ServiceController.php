<?php

namespace Controllers;

use Repositories\ServiceRepository;

class ServiceController
{
    private $repository;
    private $loader;
    private $twig;

    public function __construct($connector)
    {
        $this->repository = new ServiceRepository($connector);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/templates/');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => false,
        ));
    }

    public function indexAction()
    {
        return $this->twig->render('home.html.twig');
    }

    public function createAction()
    {
        $this->repository->createTables();
        $this->repository->addFakeUniversity(15);
        $this->repository->addFakeDepartment(20);
        $this->repository->addFakeStudent(50);
        header('Location: index.php?controller=university&action=all');
    }
}
