<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\DTO\PendingMaterial;
use App\Exception\BorrowNotFoundException;
use App\Repository\BorrowRepository;
use App\Repository\MaterialRepository;

final class PendingMaterialProvider implements ProviderInterface
{

    public function __construct(private BorrowRepository $borrowRepository, private MaterialRepository $materialRepository)
    {
    }

    /**
     * @throws BorrowNotFoundException
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|null|object
    {
        $pendingMaterials = $this->materialRepository->findBy(['materialStatus' => 'En attente']);
        $resultsMaterials = [];
        foreach ($pendingMaterials as $material) {
            // On récupère le commentaire de retour du dernier emprunt associé au matériel
            $borrow = $this->borrowRepository->findBy(['material' => $material], ['borrowPeriodEnd' => 'DESC'])[0];
            if ($borrow == null) {
                throw new BorrowNotFoundException();
            }
            $resultsMaterials[] = new PendingMaterial(
                materialId: $material->getMaterialId(),
                materialName: $material->getMaterialName(),
                materialState: $material->getMaterialState(),
                materialDetails: $material->getMaterialDetails(),
                materialSubStatus: $material->getMaterialSubStatus(),
                borrowReturnComment: $borrow->getBorrowReturnComment(),
                returnDate: $borrow->getBorrowPeriodEnd());
        }
        return $resultsMaterials;
    }
}
