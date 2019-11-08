<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 20:52
 * PHP version 7
 */
namespace App\Model;

use App\Model\Connection;

/**
 * Abstract class handling default manager.
 */
abstract class AbstractManager
{
    /**
     * @var \PDO
     */
    protected $pdo; //variable de connexion

    /**
     * @var string
     */
    protected $table;
    /**
     * @var string
     */
    protected $className;


    /**
     * Initializes Manager Abstract class.
     * @param string $table
     */
    public function __construct(string $table)
    {
        $this->table = $table;
        $this->className = __NAMESPACE__ . '\\' . ucfirst($table);
        $this->pdo = (new Connection())->getPdoConnection();
    }

    /**
     * Get all row from database.
     *
     * @return array
     */
    public function selectAll(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table)->fetchAll();
    }

    /**
     * Get one row from database by ID.
     *
     * @param  int $id
     *
     * @return array
     */
    public function selectOneById(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT beast.*, planet.name as planetName, movie.* FROM $this->table join movie on movie.id=beast.id_movie join planet on planet.id=beast.id_planet WHERE beast.id=:id");
        //select * from beast join movie on movie.id=beast.id_movie join planet on planet.id=beast.id_planet
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    public function getMovies()
    {
        return $this->pdo->query('SELECT * FROM movie')->fetchAll();
    }

    public function getPlanets()
    {
        return $this->pdo->query('SELECT * FROM planet')->fetchAll();
    }

    public function update(array $post):bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE $this->table SET `name` = :name, `size` = :sizebeast, `id_castle` = :castle WHERE id=:id");
        $statement->bindValue('id', $post['id'], \PDO::PARAM_INT);
        $statement->bindValue(':name', $post['name'], \PDO::PARAM_STR);
        $statement->bindValue('area', $post['area'], \PDO::PARAM_INT);
        $statement->bindValue('picture', $post['picture'], \PDO::PARAM_STR);
        $statement->bindValue('size', $post['size'], \PDO::PARAM_INT);
        $statement->bindValue('id_movie', $post['movies'], \PDO::PARAM_INT);
        $statement->bindValue('id_planet', $post['planet'], \PDO::PARAM_INT);



        $statement->bindValue('castle', $post['castle'], \PDO::PARAM_INT);
        return $statement->execute();
    }

}
