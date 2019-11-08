<?php


namespace App\Controller;

use App\Model\BeastManager;

/**
 * Class BeastController
 * @package Controller
 */
class BeastController extends AbstractController
{


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function list() : string
    {
        $beastsManager = new BeastManager();
        $beasts = $beastsManager->selectAll();
        return $this->twig->render('Beast/list.html.twig', ['beasts' => $beasts]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function details(int $id)  : string
    {
      // TODO : A page which displays all details of a specific beasts.
        $beastsManager = new BeastManager();
        $beasts = $beastsManager->selectOneById($id);
      //  print_r($beasts);exit;
        return $this->twig->render('Beast/details.html.twig', ['beast' => $beasts]);
    }

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function add()  : string
    {
      // TODO : A creation page where your can add a new beast.

        $beastsManager = new BeastManager();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $knightManager->insert($_POST);
            header("Location:/knight/edit/$id");
        }

        $movies = $beastsManager->getMovies();
        $planets = $beastsManager->getPlanets();


        return $this->twig->render('Beast/add.html.twig', ['beast' => $beasts, 'movies' => $movies, 'planets' => $planets]);
    }


    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function edit(int $id) : string
    {
      // TODO : An edition page where your can edit a beast.
        $beastsManager = new BeastManager();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $beastsManager->update($_POST);
        }
        $beasts = $beastsManager->selectOneById($id);
        $movies = $beastsManager->getMovies();
        $planets = $beastsManager->getPlanets();

        return $this->twig->render('Beast/edit.html.twig', ['beast' => $beasts, 'movies' => $movies, 'planets' => $planets]);
    }
}
