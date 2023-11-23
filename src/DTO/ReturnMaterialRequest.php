<?php

namespace App\DTO;

use DateTime;

class ReturnMaterialRequest
{
    /**
     * @param int $materialId
     * @param string $state
     * @param string $details
     * @param string $returnComment
     * @param DateTime $returnDate
     */
    public function __construct(public int $materialId, public string $state, public string $details, public string $returnComment, public DateTime $returnDate)
    {
    }
}
