<?php
namespace App\Service;

use App\Core\Service;

class Center extends Service
{
    public  function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all centers.
     *
     * @return array
     */
    public function getCenters(): array
    {
        return $this->db->getSelectDatas('SELECT * FROM centers');
    }
}
