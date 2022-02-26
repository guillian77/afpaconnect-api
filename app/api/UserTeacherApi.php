<?php

namespace App\Api;

use App\Model\UserRepository;
use App\Utility\Response;
use App\Utility\StatusCode;

/**
 * API to get users are Teacher.
 *
 * @UserTeacherApi
 * @package API\User
 * @author Aufrère Guillian
 * @version 1.0.0
 */
class UserTeacherApi
{
    /**
     * Get all teachers from DB.
     *
     * @param UserRepository $userRepository
     * @param Response $response
     */
    public function teachers(UserRepository $userRepository, Response $response)
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
