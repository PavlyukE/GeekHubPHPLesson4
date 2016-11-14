<?php

namespace Repositories;

use Entities\University;
use PDO;

class UniversityRepository implements RepositoryInterface
{
    private $connector;

    /**
     * HomeRepository constructor.
     * Initialize the database connection with sql server via given credentials.
     *
     * @param $connector
     */
    public function __construct(Connector $connector)
    {
        $this->connector = $connector;
    }

    public function getAll()
    {
        $statement = $this->connector->getPdo()->prepare('SELECT id, name, city, site FROM universities');
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, University::class);

        return $result;
    }
    public function insert(array $univerData)
    {
        $statement = $this->connector->getPdo()->prepare('
          INSERT INTO universities (name, city, site) 
          VALUES(:name, :city, :site)
        ');
        $statement->bindValue(':name', $univerData['name']);
        $statement->bindValue(':city', $univerData['city']);
        $statement->bindValue(':site', $univerData['site']);

        return $statement->execute();
    }
    public function remove(array $universityData)
    {
        $statement = $this->connector->getPdo()->prepare('DELETE FROM universities WHERE id = :id');
        $statement->bindValue(':id', $universityData['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
    public function update(array $universityData)
    {
        $statement = $this->connector->getPdo()->prepare('
          UPDATE universities 
          SET name = :name, city = :city, site = :site 
          WHERE id = :id
        ');
        $statement->bindValue(':name', $universityData['name'], \PDO::PARAM_STR);
        $statement->bindValue(':city', $universityData['city'], \PDO::PARAM_STR);
        $statement->bindValue(':site', $universityData['site'], \PDO::PARAM_STR);
        $statement->bindValue(':id', $universityData['id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
    public function find($id)
    {
        $statement = $this->connector->getPdo()->prepare('
          SELECT * FROM universities WHERE id = :id LIMIT 1');
        $statement->bindValue(':id', (int) $id, \PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch();

        return $result;
    }
}
