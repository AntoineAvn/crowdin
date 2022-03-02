<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Project;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ProjectVoter extends Voter
{
    public const EDIT = 'project_edit';
    public const VIEW = 'project_view';

    protected function supports(string $attribute, $project): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $project instanceof \App\Entity\Project;
    }

    protected function voteOnAttribute(string $attribute, $project, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if (null === $project->getUser()) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                return $this->canEdit($project, $user);
                break;
            case self::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                return $this->canView($project, $user);
                break;
        }

        return false;
    }

    private function canEdit(Project $project, User $user){
        //The owner can edit
        return $user === $project->getUser();
    }

    private function canView(Project $project, User $user){
            //The owner can view
            return $user === $project->getUser();
    }
}
