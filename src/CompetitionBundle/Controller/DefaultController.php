<?php

namespace CompetitionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CompetitionBundle:Default:index.html.twig');
    }
}
