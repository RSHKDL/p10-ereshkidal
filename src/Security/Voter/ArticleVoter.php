<?php

namespace App\Security\Voter;

use App\Entity\Article;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleVoter extends Voter
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject): bool
    {
        return in_array($attribute, ['MANAGE', 'PURGE'])
            && $subject instanceof Article;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'MANAGE':
                if ($subject->getAuthor() === $user) {
                    return true;
                }

                if ($this->security->isGranted('ROLE_ADMIN')) {
                    return true;
                }
                break;
            case 'PURGE':
                // logic to determine if the user can PURGE
                // return true or false
                break;
        }

        return false;
    }
}
