<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ViewController
 */
class ViewController extends AbstractController
{
    /**
     * @Route("/create")
     */
    public function index(): Response
    {
        return $this->render('add.members.html.twig');
    }
}
