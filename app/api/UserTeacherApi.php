<?php

namespace App\Api;

use App\Model\UserRepository;
use App\Utility\Response;
use App\Utility\StatusCode;

class UserTeacherApi
{
    /**
     * Get all teachers from DB.
     *
     * @param UserRepository $userRepository
     * @param Response $response
     */
    public function getTeachers(UserRepository $userRepository, Response $response)
    {
        $teachers = $userRepository->getTeachers();
        $response
            ->setStatusCode(StatusCode::REQUEST_SUCCESS)
            ->setStatusMessage('List of teachers list.')
            ->setBodyContent($teachers)
            ->send()
        ;
    }
}
