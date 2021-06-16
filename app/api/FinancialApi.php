<?php


namespace App\Api;
use App\Model\Financial;
use App\Model\FinancialRepository;
use App\Utility\Response;

class FinancialApi
{
    private Response $response;
    private FinancialRepository $financialRepository;

    public function __construct(Response $response, FinancialRepository $financialRepository)
    {
        $this->response = $response;
        $this->financialRepository = $financialRepository;
    }

    public function getAll()
    {
        $financials = Financial::all();
        $this->response
            ->setBodyContent($financials)
            ->send();
    }
}
