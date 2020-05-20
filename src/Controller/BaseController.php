<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class BaseController
 * @author ereshkidal
 */
abstract class BaseController extends AbstractController
{
    protected function getUser(): ?User
    {
        return parent::getUser();
    }
}