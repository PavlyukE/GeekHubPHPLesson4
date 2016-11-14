<?php

namespace Controllers;

use Repositories\StudentRepository;

class StudentController
{
    private $repository;
    private $loader;
    private $twig;
    public function __construct($connector)
    {
        $this->repository = new StudentRepository($connector);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/templates/');
        $this->twig = new \Twig_Environment($this->loader, array(
            'cache' => false,
        ));
    }
    public function allAction()
    {
        $students = $this->repository->getAll();

        return $this->twig->render('students.html.twig', [
            'students' => $students,
        ]);
    }

    public function addNewAction()
    {
        if (isset($_POST['name'])) {
            $this->repository->insert(
                [
                    'name' => $_POST['name'],
                    'surname' => $_POST['surname'],
                    'email' => $_POST['email'],
                    'telephone' => $_POST['telephone'],
                    'department_id' => $_POST['department_id'],
                ]
            );

            return $this->allAction();
        }
        $departments = $this->repository->getDepartments();

        return $this->twig->render('student_form.html.twig',
            [
                'name' => '',
                'surname' => '',
                'email' => '',
                'telephone' => '',
                'department_id' => '',
                'departments' => $departments,
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

        return $this->twig->render('student_delete.html.twig', array('student_id' => $_GET['id']));
    }
    public function editAction()
    {
        if (isset($_POST['name'])) {
            $this->repository->update(
                [
                    'name' => $_POST['name'],
                    'surname' => $_POST['surname'],
                    'email' => $_POST['email'],
                    'telephone' => $_POST['telephone'],
                    'id' => (int) $_GET['id'],
                ]
            );

            return $this->allAction();
        }
        $student = $this->repository->find($_GET['id']);

        return $this->twig->render('student_edit_form.html.twig', [
            'student' => $student,
        ]);
    }
}
