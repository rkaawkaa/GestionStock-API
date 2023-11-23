<?php

namespace App\Controller;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DTO\BorrowInput;
use App\Entity\Borrow;
use App\Entity\Borrower;
use App\Repository\BorrowerRepository;
use App\Repository\BorrowRepository;
use App\Repository\MaterialRepository;
use DateTime;
use InvalidArgumentException;

class NewBorrowProcessor implements ProcessorInterface
{

    public function __construct(private BorrowRepository $borrowRepository, private BorrowerRepository $borrowerRepository, private MaterialRepository $materialRepository)
    {
    }

    /** @param BorrowInput $data */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Borrow
    {
        if ($data->borrowerId == null && ($data->borrowerFirstName == null || $data->borrowerLastName == null || $data->borrowerGroup == null)) {
            throw new InvalidArgumentException();
        }

        $borrow = new Borrow(
            borrowAccessories: [""],
            borrowActive: true,
            borrowPeriodStart: new DateTime(),
            borrowPeriodEnd: new DateTime(),
            borrower: null,
            material: null
        );

        if (!empty($data->borrowAccessories)) {
            $borrow->setBorrowAccessories($data->borrowAccessories);
        }
        $borrow->setBorrowPeriodStart($data->borrowPeriodStart);
        $borrow->setBorrowPeriodEnd($data->borrowPeriodEnd);

        if ($data->borrowerId == null) {
            $borrower = new Borrower(74, $data->borrowerFirstName, $data->borrowerLastName, $data->borrowerGroup);
            $this->borrowerRepository->save($borrower, true);
            $borrow->setBorrower($borrower);
        } else {
            $borrow->setBorrower($this->borrowerRepository->find($data->borrowerId));
        }

        $material = $this->materialRepository->find($data->materialId);
        if ($material != null) {
            $material->setMaterialStatus('Emprunté');
            $material->setMaterialSubStatus('Néant');
        }

        if ($data->materialState != null) {
            $material->setMaterialState($data->materialState);
        }

        if ($data->materialDetails != null) {
            $material->setMaterialDetails($data->materialDetails);
        }

        if ($data->materialState != null || $data->materialDetails != null) {
            $this->materialRepository->save($material, true);
        }
        $borrow->setMaterial($material);

        $this->borrowRepository->save($borrow, true);
        return $borrow;
    }
}
