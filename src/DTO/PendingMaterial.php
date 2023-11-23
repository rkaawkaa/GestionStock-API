<?php

namespace App\DTO;

use DateTime;

class PendingMaterial
{
    /**
     * @param int $materialId
     * @param string $materialName
     * @param string $materialState
     * @param string $materialDetails
     * @param string $materialSubStatus
     * @param string $borrowReturnComment
     * @param DateTime $returnDate
     */
    public function __construct(public int $materialId, public string $materialName, public string $materialState, public string $materialDetails, public string $materialSubStatus, public string $borrowReturnComment, public DateTime $returnDate)
    {
    }
}
