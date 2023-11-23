<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\NewBorrowProcessor;
use App\DTO\BorrowedMaterial;
use App\DTO\BorrowInput;
use App\Repository\BorrowRepository;
use App\State\AvailableMaterialProvider;
use App\State\BorrowedMaterialProvider;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(operations: [
    new GetCollection(uriTemplate: "borrowed_materials", output: BorrowedMaterial::class, provider: BorrowedMaterialProvider::class),
    new GetCollection(uriTemplate: "available_materials", output: Material::class, provider: AvailableMaterialProvider::class),
    new GetCollection(),
    new Post(uriTemplate: "new_borrow", input: BorrowInput::class, processor: NewBorrowProcessor::class)], paginationEnabled: false)]
#[ORM\Entity(repositoryClass: BorrowRepository::class)]
class Borrow
{
    /**
     * @param array $borrowAccessories
     * @param bool $borrowActive
     * @param DateTime $borrowPeriodStart
     * @param DateTime $borrowPeriodEnd
     * @param Borrower|null $borrower
     * @param Material|null $material
     */
    public function __construct(array $borrowAccessories, bool $borrowActive, DateTime $borrowPeriodStart, DateTime $borrowPeriodEnd, ?Borrower $borrower, ?Material $material)
    {
        $this->borrowAccessories = $borrowAccessories;
        $this->borrowActive = $borrowActive;
        $this->borrowPeriodStart = $borrowPeriodStart;
        $this->borrowPeriodEnd = $borrowPeriodEnd;
        $this->borrower = $borrower;
        $this->material = $material;
    }

    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private int $borrowId;

    #[ORM\Column(type: 'simple_array', nullable: false)]
    private array $borrowAccessories;

    #[ORM\Column(type: 'boolean', nullable: false)]
    private bool $borrowActive;

    #[ORM\Column(type: 'date', nullable: false)]
    private DateTime $borrowPeriodStart;

    #[ORM\Column(type: 'date', nullable: false)]
    private DateTime $borrowPeriodEnd;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: 'borrower_id', nullable: true)]
    private ?Borrower $borrower;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(referencedColumnName: 'material_id', nullable: true)]
    private ?Material $material;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $borrowReturnComment = 'Néant';

    public function getBorrowId(): int
    {
        return $this->borrowId;
    }

    /**
     * @param int $borrowId
     */
    public function setBorrowId(int $borrowId): void
    {
        $this->borrowId = $borrowId;
    }

    public function getBorrowAccessories(): array
    {
        return $this->borrowAccessories;
    }

    public function setBorrowAccessories(?array $borrowAccessories): self
    {
        $this->borrowAccessories = $borrowAccessories;

        return $this;
    }

    public function isBorrowActive(): ?bool
    {
        return $this->borrowActive;
    }

    public function setBorrowActive(bool $borrowActive): self
    {
        $this->borrowActive = $borrowActive;

        return $this;
    }

    public function getBorrowPeriodStart(): ?DateTime
    {
        return $this->borrowPeriodStart;
    }

    public function setBorrowPeriodStart(DateTime $borrowPeriodStart): self
    {
        $this->borrowPeriodStart = $borrowPeriodStart;

        return $this;
    }

    public function getBorrowPeriodEnd(): ?DateTime
    {
        return $this->borrowPeriodEnd;
    }

    public function setBorrowPeriodEnd(DateTime $borrowPeriodEnd): self
    {
        $this->borrowPeriodEnd = $borrowPeriodEnd;

        return $this;
    }

    public function getBorrower(): ?Borrower
    {
        return $this->borrower;
    }

    public function setBorrower(?Borrower $borrower): self
    {
        $this->borrower = $borrower;

        return $this;
    }

    public function getMaterial(): ?Material
    {
        return $this->material;
    }

    public function setMaterial(?Material $material): self
    {
        $this->material = $material;

        return $this;
    }

    public function getBorrowReturnComment(): string
    {
        return $this->borrowReturnComment;
    }

    public function setBorrowReturnComment(string $borrowReturnComment): self
    {
        $this->borrowReturnComment = $borrowReturnComment;

        return $this;
    }
}
