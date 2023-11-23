<?php

namespace App\DTO;

use DateTime;

class BorrowedMaterial
{
    /**
     * @param int $materialId
     * @param string $materialName
     * @param string $materialState
     * @param string $materialDetails
     * @param string $borrowerFirstName
     * @param string $borrowerLastName
     * @param string $borrowerGroup
     * @param array $borrowAccessories
     * @param DateTime $borrowPeriodStart
     * @param DateTime $borrowPeriodEnd
     */
    public function __construct(public int $materialId, public string $materialName, public string $materialState, public string $materialDetails, public string $borrowerFirstName, public string $borrowerLastName, public string $borrowerGroup, public array $borrowAccessories, public DateTime $borrowPeriodStart, public DateTime $borrowPeriodEnd)
    {
    }
}
