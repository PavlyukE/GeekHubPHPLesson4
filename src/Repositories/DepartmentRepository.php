<?php

namespace Repositories;

class DepartmentRepository implements RepositoryInterface
{
    private $connector;

    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }
    /**
     * Get all departments from db.
     *
     * @return mixed
     */
    public function getAll()
    {
        $statement = $this->connector->getPdo()->prepare('
            SELECT departments.id, departments.name, universities.name AS universityName FROM departments 
            INNER JOIN universities ON (departments.university_id = universities.id);
        ');
        $statement->execute();
        $result = $statement->fetchAll();

        return $result;
    }
    /**
     * Insert new department from db.
     *
     * @param $departmentData
     *
     * @return void
     */
    public function insert(array $departmentData)
    {
        $statement = $this->connector->getPdo()->prepare('
          INSERT INTO departments (name, university_id) 
          VALUES(:name, :university_id)
        ');
        $statement->bindValue(':name', $departmentData['name']);
        $statement->bindValue(':university_id', $departmentData['university_id']);
        $statement->execute();
    }
    /**
     * Insert new department from db.
     *
     * @param $departmentData
     *
     * @return void
     */
    public function update(array $departmentData)
    {
        $statement = $this->connector->getPdo()->prepare('
          UPDATE departments 
          SET name = :name
          WHERE id = :id
        ');
        $statement->bindValue(':name', $departmentData['name'], \PDO::PARAM_STR);
        $statement->bindValue(':id', $departmentData['id'], \PDO::PARAM_INT);
        $statement->execute();
    }
    /**
     * Get university names
     *
     *
     * @return mixed
     */
    public function getUniversityNames()
    {
        $statement = $this->connector->getPdo()->prepare('SELECT id, name FROM universities');
        $statement->execute();
        $result = $statement->fetchAll();

        return $result;
    }
    public function remove(array $departmentData)
    {
        $statement = $this->connector->getPdo()->prepare('DELETE FROM departments WHERE id = :id');
        $statement->bindValue(':id', $departmentData['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
    public function find($id)
    {
        $statement = $this->connector->getPdo()->prepare('
          SELECT * FROM departments WHERE id = :id LIMIT 1');
        $statement->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch();

        return $result;
    }
}
