<?php

namespace App\Api;

use App\Core\Request;
use App\Core\Router;
use App\Model\User;
use App\Model\UserRepository;
use App\Utility\Response;
use App\Utility\StatusCode;
use Exception;

/**
 * Allow update user information from request parameters inside database.
 * User should be identified by an index referenced under User model class.
 *
 * NB: Password can be sent has plain texte because a mutator automatically will hash it
 * under User model.
 *
 * @UserEditApi
 * @package API\User
 * @author Aufrère Guillian
 * @version 1.0.0
 */
class UserEditApi
{
    /**
     * Update user information.
     *
     * @param Request $request (DI) Request object.
     * @param Response $response (DI) Response helper object.
     * @param UserRepository $userRepository (DI) UserRepository object.
     * @param Router $router (DI) Router object.
     *
     * @throws Exception
     */
    public function edit(Request $request, Response $response, UserRepository $userRepository, Router $router)
    {
        /*
         * Get data from request.
         */
        $data = $request->request()->all();

        // Delete issuer from request. It does not concern user.
        unset($data['issuer']);

        /*
         * Check there is a field to identify user on the app.
         */
        $identifier = $this->checkIdentifier($request);
        if(!$identifier) {
            $response
                ->setStatusCode(StatusCode::MISSING_REQUEST_PARAMETER)
                ->setBodyContent(
                    'Missing a parameter to identify user on the app.'
                    .'You can list columns with '
                    .$router->generate('api.user.table')
                    .'.'
                )
                ->send(404, true);
        };

        /*
         * Get user from database.
         */
        $user = $userRepository->findOneByUsernames($data[$identifier]);

        /*
         * Compare request parameters with user table columns.
         */
        $faultUserColumns = $this->checkTableColumns($user->getAttributes(), $data);

        if ($faultUserColumns) {
            $response
                ->setStatusCode(StatusCode::USER_EDIT_COLUMN_FAILURE)
                ->setStatusMessage(
                    "$faultUserColumns don't exist inside user table."
                    ."You can list columns with "
                    .$router->generate('api.user.table')
                    ."."
                )
                ->send(400, true);
        }

        /*
         * Update user with new request parameters.
         */
        foreach ($data as $key => $item) {
            $user->$key = $item;
        }

        try {
            $user->update();
        } catch (\Exception $exception) {
            error_log($exception);
            $response
                ->setStatusCode(StatusCode::USER_EDIT_FAILURE)
                ->setBodyContent('An error has been throw when trying to update user.')
                ->send(500, true);
        }

        $response
            ->setStatusCode(StatusCode::USER_EDIT_SUCCESS)
            ->setStatusMessage('User updated successfully.')
            ->setBodyContent($user)
            ->send();
    }

    /**
     * Verify identifier presence and return it.
     *
     * @param Request $request
     *
     * @return string|null
     *
     * @throws Exception
     */
    private function checkIdentifier(Request $request): ?string
    {
        $requestData = $request->request()->all();

        foreach (User::INDEX_FIELDS as $index) {
            if (isset($requestData[$index])) {
                return $index;
            }
        }

        return null;
    }

    /**
     * Return a non existing request parameter inside user table.
     *
     * @param array $table
     * @param array $requestData
     *
     * @return string|null
     */
    private function checkTableColumns(array $table, array $requestData): ?string
    {
        // Reference user table columns.
        $userTableColumns = array_keys($table);

        // Verify parameters from request exist inside user table.
        foreach ($requestData as $key => $data) {
            if (!in_array($key, $userTableColumns)) {
                // Return the bad request parameter.
                return $key;
            }
        }

        return null;
    }
}