<?php

namespace Controllers;

use Repositories\UniversityRepository;

class UniversityController
{
    private $repository;
    private $loader;
    private $twig;
    public function __construct($connector)
    {
        $this->repository = new UniversityRepository($connector);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/templates/');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => false,
        ));
    }

    public function allAction()
    {
        $universities = $this->repository->getAll();

        return $this->twig->render('universities.html.twig', [
            'universities' => $universities,
        ]);
    }

    public function addFakeAction()
    {
        $this->repository->addFakeUniversity(1);

        return $this->allAction();
    }
    public function addNewAction()
    {
        if (isset($_POST['name'])) {
            $this->repository->add(
                [
                    'name' => $_POST['name'],
                    'city' => $_POST['city'],
                    'site' => $_POST['site'],
                ]
            );

            return $this->allAction();
        }

        return $this->twig->render('univer_form.html.twig',
            [
                'name' => '',
                'city' => '',
                'site' => '',
            ]
        );
    }
    public function deleteAction()
    {
        if (isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            $this->repository->remove(['id' => $id]);

            return $this->allAction();
        }

        return $this->twig->render('university_delete.html.twig', array('university_id' => $_GET['id']));
    }
    public function editAction()
    {
        if (isset($_POST['name'])) {
            $this->repository->update(
                [
                    'name' => $_POST['name'],
                    'city' => $_POST['city'],
                    'site' => $_POST['site'],
                    'id' => (int) $_GET['id'],
                ]
            );

            return $this->allAction();
        }
        $university = $this->repository->find($_GET['id']);

        return $this->twig->render('univer_form.html.twig', [
            'university' => $university,
        ]);
    }
}
