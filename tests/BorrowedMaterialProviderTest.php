<?php

namespace App\Tests;

use ApiPlatform\Metadata\GetCollection;
use App\DTO\BorrowedMaterial;
use App\Entity\Borrow;
use App\Entity\Borrower;
use App\Entity\Material;
use App\Exception\BorrowerNotFoundException;
use App\Exception\MaterialNotFoundException;
use App\Repository\BorrowRepository;
use App\State\BorrowedMaterialProvider;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class BorrowedMaterialProviderTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_request_return_borrowed_material_from_repository()
    {
        $borrowRepository = $this->createMock(BorrowRepository::class);
        $material = new Material(5, 'MBP05', 'Neuf', 'Aucun défaut', 'Disponible', 'Néant');
        $borrow = new Borrow([], true, new \DateTime(), new \DateTime(), null, null);
        $borrower = new Borrower(7, 'John', 'Smith', 'LP CDTL B');
        $borrow->setMaterial($material);
        $borrow->setBorrower($borrower);
        $materialResult = new BorrowedMaterial(
            $material->getMaterialId(),
            $material->getMaterialName(),
            $material->getMaterialState(),
            $material->getMaterialDetails(),
            $borrower->getBorrowerFirstName(),
            $borrower->getBorrowerLastName(),
            $borrower->getBorrowerGroup(),
            $borrow->getBorrowAccessories(),
            $borrow->getBorrowPeriodStart(),
            $borrow->getBorrowPeriodEnd());
        $borrowRepository->method('findBy')->willReturn([$borrow]);
        $borrowRepository->expects($this->once())->method('findBy');
        $provider = new BorrowedMaterialProvider($borrowRepository);
        $result = $provider->provide(new GetCollection());
        $this->assertIsArray($result);
        $this->assertEquals($materialResult, $result[0]);
    }

    /**
     * @throws Exception|MaterialNotFoundException
     */
    public function test_null_borrower_throws_borrower_not_found_exception()
    {
        $this->expectException(BorrowerNotFoundException::class);
        $borrowRepository = $this->createMock(BorrowRepository::class);
        $material = new Material(5, 'MBP05', 'Neuf', 'Aucun défaut', 'Disponible', 'Néant');
        $borrow = new Borrow([], true, new \DateTime(), new \DateTime(), null, null);
        $borrow->setMaterial($material);
        $borrowRepository->method('findBy')->willReturn([$borrow]);
        $borrowRepository->expects($this->once())->method('findBy');
        $provider = new BorrowedMaterialProvider($borrowRepository);
        $provider->provide(new GetCollection());
    }

    /**
     * @throws Exception|BorrowerNotFoundException
     */
    public function test_null_material_throws_material_not_found_exception()
    {
        $this->expectException(MaterialNotFoundException::class);
        $borrowRepository = $this->createMock(BorrowRepository::class);
        $borrow = new Borrow([], true, new \DateTime(), new \DateTime(), null, null);
        $borrower = new Borrower(7, 'John', 'Smith', 'LP CDTL B');
        $borrow->setBorrower($borrower);
        $borrowRepository->method('findBy')->willReturn([$borrow]);
        $borrowRepository->expects($this->once())->method('findBy');
        $provider = new BorrowedMaterialProvider($borrowRepository);
        $provider->provide(new GetCollection());
    }

    /**
     * @throws Exception|BorrowerNotFoundException|MaterialNotFoundException
     */
    public function test_no_borrow_return_empty_array()
    {
        $borrowRepository = $this->createMock(BorrowRepository::class);
        $provider = new BorrowedMaterialProvider($borrowRepository);
        $borrowRepository->method('findBy')->willReturn([]);
        $result = $provider->provide(new GetCollection());
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }
}