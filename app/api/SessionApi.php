<?php

namespace App\Api;

use App\Core\Request;
use App\Model\Session;
use App\Utility\Response;
use App\Utility\StatusCode;
use Exception;

class SessionApi
{
    /**
     * Get one session from parameters.
     *
     * @throws Exception
     */
    public function session(Request $request, Response $response)
    {
        $queryParameters = $request->query()->all();

        if ($request->query()->get('owner')) {
            $session = Session::where('owner', '=', $queryParameters['owner'])
                ->get()
                ->first()
                ->toArray()
            ;

            return $response
                ->setStatusCode(StatusCode::REQUEST_SUCCESS)
                ->setStatusMessage('Get session with owner ID.')
                ->setBodyContent($session)
                ->send();
        }

        dd($queryParameters);
    }

    public function sessions(Response $response)
    {

    }
}