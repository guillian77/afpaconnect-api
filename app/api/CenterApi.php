<?php


namespace App\Api;


use App\Model\CenterRepository;
use App\Utility\Response;

class CenterApi
{
    private Response $response;

    private CenterRepository $repository;

    public function __construct(CenterRepository $repository, Response $response)
    {
        $this->response = $response;
        $this->repository = $repository;
    }

    public function getAll()
    {
        $centers = $this->repository->findAll();
        $this->response
            ->setBodyContent($centers)
            ->send();
    }
}
