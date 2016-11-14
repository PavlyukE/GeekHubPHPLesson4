<?php

namespace Repositories;

class StudentRepository implements RepositoryInterface
{
    private $connector;

    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    public function getAll()
    {
        $statement = $this->connector->getPdo()->prepare('
            SELECT students.id, students.name, students.surname, departments.name AS departmentName,
             universities.name AS universityName
            FROM students 
            INNER JOIN departments ON (students.department_id = departments.id)
            INNER JOIN universities ON (departments.university_id = universities.id);
        ');
        $statement->execute();
        $result = $statement->fetchAll();

        return $result;
    }
    public function insert(array $studentData)
    {
        $statement = $this->connector->getPdo()->prepare('
          INSERT INTO students (name, surname, email, telephone, department_id) 
          VALUES(:name, :surname, :email, :telephone, :department_id)
        ');
        $statement->bindValue(':name', $studentData['name']);
        $statement->bindValue(':surname', $studentData['surname']);
        $statement->bindValue(':email', $studentData['email']);
        $statement->bindValue(':telephone', $studentData['telephone']);
        $statement->bindValue(':department_id', $studentData['department_id']);

        return $statement->execute();
    }
    public function update(array $studentData)
    {
        $statement = $this->connector->getPdo()->prepare('
          UPDATE students 
          SET name = :name, surname = :surname, email = :email, telephone = :telephone
          WHERE id = :id
        ');
        $statement->bindValue(':name', $studentData['name'], \PDO::PARAM_STR);
        $statement->bindValue(':surname', $studentData['surname'], \PDO::PARAM_STR);
        $statement->bindValue(':email', $studentData['email'], \PDO::PARAM_STR);
        $statement->bindValue(':telephone', $studentData['telephone'], \PDO::PARAM_STR);
        $statement->bindValue(':id', $studentData['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
    public function getDepartments()
    {
        $statement = $this->connector->getPdo()->prepare('
            SELECT departments.id, departments.name, universities.name AS universityName 
            FROM departments 
            INNER JOIN universities ON (departments.university_id = universities.id);
');
        $statement->execute();
        $result = $statement->fetchAll();

        return $result;
    }
    public function remove(array $studentData)
    {
        $statement = $this->connector->getPdo()->prepare('DELETE FROM students WHERE id = :id');
        $statement->bindValue(':id', $studentData['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
    public function find($id)
    {
        $statement = $this->connector->getPdo()->prepare('
          SELECT * FROM students WHERE id = :id LIMIT 1');
        $statement->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch();

        return $result;
    }
}
