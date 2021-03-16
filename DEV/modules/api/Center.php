<?php

namespace App\Api;

use App\Service\Center as CenterService;
use App\Core\Controller;
use App\Utility\Response;

class Center extends Controller
{
    /**
     * @var \App\Service\Center $CenterService
     */
    private $CenterService;

    public function __construct()
    {
        parent::__construct();
        // Load Center service
        $this->CenterService = new CenterService();
    }

    /**
     * Get all centers.
     */
    public function getAllCenters()
    {
        $centers = $this->CenterService->getCenters();

        if (!$centers)
        {
            http_response_code(404);
            Response::json("Impossible de récupérer la liste des centres.");
            return;
        }
        Response::json($centers);
    }
}
