<?php

namespace App\Security\Voter;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

final class ReviewVoter extends Voter
{
    public const EDIT = 'REVIEW_EDIT';
    public const VIEW = 'REVIEW_VIEW';

    public function __construct(private Security $security) {}


    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Entity\Review;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case self::EDIT:
                if ($this->security->isGranted('ROLE_USER') || $this->security->isGranted('ROLE_ADMIN')) {
                    return true;
                }
                break;

            case self::VIEW:

                break;
        }

        return false;
    }
}
