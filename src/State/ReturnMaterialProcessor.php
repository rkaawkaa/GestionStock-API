<?php


namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\DTO\ReturnMaterialRequest;
use App\Exception\MaterialNotFoundException;
use App\Repository\BorrowRepository;
use App\Repository\MaterialRepository;
use InvalidArgumentException;

class ReturnMaterialProcessor implements ProcessorInterface
{

    public function __construct(private MaterialRepository $materialRepository, private BorrowRepository $borrowRepository)
    {
    }

    /** @param ReturnMaterialRequest $data
     * @throws MaterialNotFoundException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): \App\Entity\Material
    {
        if ($data->materialId == null || $data->materialId < 0) {
            throw new InvalidArgumentException('Material id invalid');
        }

        $material = $this->materialRepository->find($data->materialId);
        if ($material == null) {
            throw new MaterialNotFoundException();
        }
        foreach ($this->borrowRepository->findBy(['borrowActive' => true, 'material' => $material]) as $borrow) {
            $borrow->setBorrowActive(false);
            if (isset($data->returnDate)) {
                $borrow->setBorrowPeriodEnd($data->returnDate);
            }
            if (isset($data->returnComment)) {
                $borrow->setBorrowReturnComment($data->returnComment);
            }
            $this->borrowRepository->save($borrow, true);
        }
        $material->setMaterialStatus('En attente');
        $material->setMaterialSubStatus('À envoyer au SIGE');
        if (isset($data->state)) {
            $material->setMaterialState($data->state);
        }

        if (isset($data->details)) {
            $material->setMaterialDetails($data->details);
        }

        $this->materialRepository->save($material, true);
        return $material;
    }
}