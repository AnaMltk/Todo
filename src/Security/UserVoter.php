<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on `User` objects
        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $loggedUser = $token->getUser();
        if (!$loggedUser instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }
        
        // you know $subject is a Task object, thanks to `supports()`
        /** @var User $user */
        $user = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($user, $loggedUser);
            case self::EDIT:
                return $this->canEdit($user, $loggedUser);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(User $user, User $loggedUser): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($user, $loggedUser)) {
            return true;
        }
    }

    private function canEdit(User $user, User $loggedUser): bool
    {
        if(in_array('ROLE_ADMIN', $user->getRoles())){
            return true;
        }
        return false;
    }
}