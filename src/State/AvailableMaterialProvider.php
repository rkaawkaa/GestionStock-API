<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\MaterialRepository;

final class AvailableMaterialProvider implements ProviderInterface
{

    public function __construct(private MaterialRepository $materialRepository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|null|object
    {
        return $this->materialRepository->findBy(["materialStatus" => 'Disponible']);
    }
}
