<?php

namespace App\DTO;

use DateTime;

class BorrowInput
{
    public function __construct(
        public DateTime $borrowPeriodStart,
        public DateTime $borrowPeriodEnd,
        public int      $materialId,
        public array    $borrowAccessories = [],
        public ?int     $borrowerId = null,
        public ?string  $borrowerFirstName = null,
        public ?string  $borrowerLastName = null,
        public ?string  $borrowerGroup = null,
        public ?string  $materialState = null,
        public ?string  $materialDetails = null)
    {
    }
}
