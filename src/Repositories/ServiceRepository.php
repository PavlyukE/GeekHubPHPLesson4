<?php

namespace Repositories;

use Faker\Factory;

class ServiceRepository
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

    public function createTables()
    {
        $statement = $this->connector->getPdo()->prepare('
            CREATE TABLE universities (
              id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
              name CHAR (30) DEFAULT NULL,
              city CHAR (30) DEFAULT NULL,
              site CHAR(30) DEFAULT NULL
            );
            CREATE TABLE departments (
              id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
              name CHAR (30) DEFAULT NULL,
              university_id INT DEFAULT NULL,
              FOREIGN KEY (university_id) REFERENCES universities(id) ON DELETE CASCADE
            );
            CREATE TABLE students (
              id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
              name CHAR (30) DEFAULT NULL,
              surname CHAR (30) DEFAULT NULL,
              email CHAR (30) DEFAULT NULL,
              telephone CHAR (30) DEFAULT NULL,
              department_id INT DEFAULT NULL,
              FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
            );
            ');
        $statement->execute();
    }

    /**
     * Create fake university $k times.
     *
     * @param int $k
     *
     * @return mixed
     */
    public function addFakeUniversity($k)
    {
        for ($i = 1; $i <= $k; ++$i) {
            $faker = Factory::create();
            $statement = $this->connector->getPdo()->prepare('
            INSERT INTO universities (name, city, site) 
            VALUES(:name, :city, :site)');
            $statement->bindValue(':name', $faker->company."'s University");
            $statement->bindValue(':city', $faker->city);
            $statement->bindValue(':site', $faker->domainName);
            $statement->execute();
        }
    }

    /**
     * Create fake department $k times.
     *
     * @param int $k
     *
     * @return mixed
     */
    public function addFakeDepartment($k)
    {
        for ($i = 1; $i <= $k; ++$i) {
            $faker = Factory::create();
            $statement = $this->connector->getPdo()->prepare('
            INSERT INTO departments (name, university_id) 
            VALUES(:name, :university_id)');
            $statement->bindValue(':name', $faker->jobTitle);
            $statement->bindValue(':university_id', $faker->numberBetween($min = 1, $max = 8));
            $statement->execute();
        }
    }

    /**
     * Create fake student $k times.
     *
     * @param int $k
     *
     * @return mixed
     */
    public function addFakeStudent($k)
    {
        for ($i = 1; $i <= $k; ++$i) {
            $faker = Factory::create();
            $name = $faker->firstName;
            $surname = $faker->lastName;
            $email = $faker->safeEmail;
            $telephone = $faker->tollFreePhoneNumber;
            $department_id = $faker->numberBetween($min = 1, $max = 15);
            $statement = $this->connector->getPdo()->prepare('
            INSERT INTO students (name, surname, email, telephone, department_id) 
            VALUES(:name, :surname, :email, :telephone, :department_id)');
            $statement->bindValue(':name', $name);
            $statement->bindValue(':surname', $surname);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':telephone', $telephone);
            $statement->bindValue(':department_id', $department_id);
            $statement->execute();
        }
    }
}
