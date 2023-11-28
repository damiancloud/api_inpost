<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RedirectController extends AbstractController
{
    /**
     * @Route("/", name="home_redirect")
     */
    public function redirectToSearch()
    {
        return $this->redirectToRoute('search');
    }
}