<?php
namespace App\Service;

use App\Entity\User;
use DateTime;

class ServiceUser
{
    public function calculateAge(User $user): ?int
    {
        $birthDate = $user->getBirthDate();

        if ($birthDate !== null) {
            $currentDate = new DateTime();
            $interval = $currentDate->diff($birthDate);

            return $interval->y;
        }

        return null;
    }
}
