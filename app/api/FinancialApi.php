<?php


namespace App\Api;
use App\Model\Financial;
use App\Model\FinancialRepository;
use App\Utility\Response;
use App\Utility\StatusCode;

class FinancialApi
{
    private Response $response;
    private FinancialRepository $financialRepository;

    public function __construct(Response $response, FinancialRepository $financialRepository)
    {
        $this->response = $response;
        $this->financialRepository = $financialRepository;
    }

    public function index()
    {
        $financials = Financial::all();
        $this->response
            ->setStatusCode(StatusCode::REQUEST_SUCCESS)
            ->setBodyContent($financials)
            ->send();
    }
}
