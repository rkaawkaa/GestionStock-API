<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\BorrowerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(paginationEnabled: false)]
#[ORM\Entity(repositoryClass: BorrowerRepository::class)]
class Borrower
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    #[ApiProperty(identifier: true)]
    private int $borrowerId;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $borrowerFirstName;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $borrowerLastName;

    #[ORM\Column(type: 'string', length: 255)]
    private string $borrowerGroup;

    /**
     * @param int $borrowerId
     * @param string $borrowerFirstName
     * @param string $borrowerLastName
     * @param string $borrowerGroup
     */
    public function __construct(int $borrowerId, string $borrowerFirstName, string $borrowerLastName, string $borrowerGroup)
    {
        $this->borrowerId = $borrowerId;
        $this->borrowerFirstName = $borrowerFirstName;
        $this->borrowerLastName = $borrowerLastName;
        $this->borrowerGroup = $borrowerGroup;
    }

    public function getBorrowerId(): ?int
    {
        return $this->borrowerId;
    }

    public function getBorrowerFirstName(): ?string
    {
        return $this->borrowerFirstName;
    }

    public function setBorrowerFirstName(string $borrowerFirstName): self
    {
        $this->borrowerFirstName = $borrowerFirstName;

        return $this;
    }

    public function getBorrowerLastName(): ?string
    {
        return $this->borrowerLastName;
    }

    public function setBorrowerLastName(string $borrowerLastName): self
    {
        $this->borrowerLastName = $borrowerLastName;

        return $this;
    }

    public function getBorrowerGroup(): ?string
    {
        return $this->borrowerGroup;
    }

    public function setBorrowerGroup(string $borrowerGroup): self
    {
        $this->borrowerGroup = $borrowerGroup;

        return $this;
    }
}
