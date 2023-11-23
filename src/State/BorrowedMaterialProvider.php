<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\DTO\BorrowedMaterial;
use App\Exception\BorrowerNotFoundException;
use App\Exception\MaterialNotFoundException;
use App\Repository\BorrowRepository;

final class BorrowedMaterialProvider implements ProviderInterface
{

    public function __construct(private BorrowRepository $repository)
    {
    }

    /**
     * @throws BorrowerNotFoundException
     * @throws MaterialNotFoundException
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|null|object
    {
        $borrowList = [];
        foreach ($this->repository->findBy(["borrowActive" => true]) as $borrow) {
            $material = $borrow->getMaterial();
            $borrower = $borrow->getBorrower();
            if ($borrower == null) {
                throw new BorrowerNotFoundException();
            }
            
            if ($material == null) {
                throw new MaterialNotFoundException();
            }
            $borrowList[] = new BorrowedMaterial(
                materialId: $material->getMaterialId(),
                materialName: $material->getMaterialName(),
                materialState: $material->getMaterialState(),
                materialDetails: $material->getMaterialDetails(),
                borrowerFirstName: $borrower->getBorrowerFirstName(),
                borrowerLastName: $borrower->getBorrowerLastName(),
                borrowerGroup: $borrower->getBorrowerGroup(),
                borrowAccessories: $borrow->getBorrowAccessories(),
                borrowPeriodStart: $borrow->getBorrowPeriodStart(),
                borrowPeriodEnd: $borrow->getBorrowPeriodEnd());
        }
        return $borrowList;
    }
}
