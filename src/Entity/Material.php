<?php

namespace App\Entity;


use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\DTO\PendingMaterial;
use App\DTO\ReturnMaterialRequest;
use App\Repository\MaterialRepository;
use App\State\PendingMaterialProvider;
use App\State\ReturnMaterialProcessor;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(operations: [
    new Patch(uriTemplate: "return_material", input: ReturnMaterialRequest::class, output: Material::class, processor: ReturnMaterialProcessor::class),
    new Patch(),
    new Post(),
    new GetCollection(uriTemplate: 'pending_materials', output: PendingMaterial::class, provider: PendingMaterialProvider::class),
    new GetCollection()], paginationEnabled: false)]
#[ORM\Entity(repositoryClass: MaterialRepository::class)]
#[ApiFilter(SearchFilter::class, properties: ['materialStatus' => 'exact'])]
class Material
{
    #[ORM\Id, ORM\Column, ORM\GeneratedValue]
    private int $materialId;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $materialName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $materialState = null;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $materialDetails = 'Néant';

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $materialStatus = 'Disponible';

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $materialSubStatus = 'Néant';

    /**
     * @param int $materialId
     * @param string $materialName
     * @param string $materialState
     * @param string $materialDetails
     * @param string $materialStatus
     * @param string $materialSubStatus
     */
    public function __construct(int $materialId, string $materialName, string $materialState, string $materialDetails, string $materialStatus, string $materialSubStatus)
    {
        $this->materialId = $materialId;
        $this->materialName = $materialName;
        $this->materialState = $materialState;
        $this->materialDetails = $materialDetails;
        $this->materialStatus = $materialStatus;
        $this->materialSubStatus = $materialSubStatus;
    }

    public function getMaterialId(): ?int
    {
        return $this->materialId;
    }

    public function getMaterialName(): string
    {
        return $this->materialName;
    }

    public function setMaterialName(string $materialName): self
    {
        $this->materialName = $materialName;

        return $this;
    }

    public function getMaterialState(): ?string
    {
        return $this->materialState;
    }

    public function setMaterialState(?string $materialState): self
    {
        $this->materialState = $materialState;

        return $this;
    }

    public function getMaterialDetails(): ?string
    {
        return $this->materialDetails;
    }

    public function setMaterialDetails(string $materialDetails): self
    {
        $this->materialDetails = $materialDetails;

        return $this;
    }

    public function getMaterialStatus(): string
    {
        return $this->materialStatus;
    }

    public function setMaterialStatus(string $materialStatus): self
    {
        $this->materialStatus = $materialStatus;

        return $this;
    }

    public function getMaterialSubStatus(): string
    {
        return $this->materialSubStatus;
    }

    public function setMaterialSubStatus(string $materialSubStatus): self
    {
        $this->materialSubStatus = $materialSubStatus;

        return $this;
    }
}
