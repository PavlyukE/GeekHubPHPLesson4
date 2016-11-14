<?php

namespace Controllers;

use Repositories\DepartmentRepository;

class DepartmentController
{
    private $repository;
    private $loader;
    private $twig;
    public function __construct($connector)
    {
        $this->repository = new DepartmentRepository($connector);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/templates/');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => false,
        ));
    }
    public function allAction()
    {
        $departments = $this->repository->getAll();

        return $this->twig->render('departments.html.twig', [
            'departments' => $departments,
        ]);
    }

    public function addNewAction()
    {
        if (isset($_POST['name'])) {
            $this->repository->insert(
                [
                    'name' => $_POST['name'],
                    'university_id' => $_POST['university_id'],
                ]
            );

            return $this->allAction();
        }
        $universities = $this->repository->getUniversityNames();

        return $this->twig->render('department_form.html.twig',
            [
                'name' => '',
                'university_id' => '',
                'universities' => $universities,
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

        return $this->twig->render('department_delete.html.twig', array('department_id' => $_GET['id']));
    }
    public function editAction()
    {
        if (isset($_POST['name'])) {
            $this->repository->update(
                [
                    'name' => $_POST['name'],
                    'id' => (int) $_GET['id'],
                ]
            );

            return $this->allAction();
        }
        $department = $this->repository->find($_GET['id']);

        return $this->twig->render('department_edit_form.html.twig', [
            'department' => $department,
        ]);
    }
}
