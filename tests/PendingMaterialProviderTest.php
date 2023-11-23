<?php

namespace App\Tests;

use ApiPlatform\Metadata\GetCollection;
use App\DTO\PendingMaterial;
use App\Entity\Borrow;
use App\Entity\Material;
use App\Exception\BorrowNotFoundException;
use App\Repository\BorrowRepository;
use App\Repository\MaterialRepository;
use App\State\PendingMaterialProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class PendingMaterialProviderTest extends TestCase
{
    /**
     * @throws Exception|BorrowNotFoundException
     */
    public function test_no_pending_materials_return_empty_array()
    {
        $borrowRepository = $this->createMock(BorrowRepository::class);
        $borrowRepository->expects($this->never())->method('findBy');
        $materialRepository = $this->createMock(MaterialRepository::class);
        $provider = new PendingMaterialProvider($borrowRepository, $materialRepository);
        $result = $provider->provide(new GetCollection());
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * @throws Exception|BorrowNotFoundException
     */
    public function test_request_return_pending_material_from_repository()
    {
        $borrowRepository = $this->createMock(BorrowRepository::class);
        $materialRepository = $this->createMock(MaterialRepository::class);
        $material = new Material(5, 'MBP05', 'Neuf', 'Aucun défaut', 'En attente', 'Néant');
        $borrow = new Borrow([], true, new \DateTime(), new \DateTime(), null, null);
        $borrow->setMaterial($material);
        $pendingMaterial = new PendingMaterial(
            $material->getMaterialId(),
            $material->getMaterialName(),
            $material->getMaterialState(),
            $material->getMaterialDetails(),
            $material->getMaterialSubStatus(),
            $borrow->getBorrowReturnComment(),
            $borrow->getBorrowPeriodEnd(),
        );
        $materialRepository->method('findBy')->willReturn([$material]);
        $borrowRepository->method('findBy')->willReturn([$borrow]);
        $borrowRepository->expects($this->once())->method('findBy');
        $materialRepository->expects($this->once())->method('findBy');
        $provider = new PendingMaterialProvider($borrowRepository, $materialRepository);
        $result = $provider->provide(new GetCollection());
        $this->assertIsArray($result);
        $this->assertEquals($pendingMaterial, $result[0]);
    }

    /**
     * @throws Exception
     */
    public function test_no_borrow_found_throws_borrow_not_found_exception()
    {
        $this->expectException(BorrowNotFoundException::class);
        $borrowRepository = $this->createMock(BorrowRepository::class);
        $materialRepository = $this->createMock(MaterialRepository::class);
        $material = new Material(5, 'MBP05', 'Neuf', 'Aucun défaut', 'En attente', 'Néant');
        $materialRepository->method('findBy')->willReturn([$material]);
        $borrowRepository->method('findBy')->willReturn([]);
        $borrowRepository->expects($this->once())->method('findBy');
        $materialRepository->expects($this->once())->method('findBy');
        $provider = new PendingMaterialProvider($borrowRepository, $materialRepository);
        $provider->provide(new GetCollection());
    }
}