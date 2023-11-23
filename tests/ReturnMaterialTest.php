<?php

namespace App\Tests;

use ApiPlatform\Metadata\Post;
use App\DTO\ReturnMaterialRequest;
use App\Entity\Borrow;
use App\Entity\Borrower;
use App\Entity\Material;
use App\Exception\MaterialNotFoundException;
use App\Repository\BorrowRepository;
use App\Repository\MaterialRepository;
use App\State\ReturnMaterialProcessor;
use DateTime;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class ReturnMaterialTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function test_material_not_found_throws_material_not_found_exception()
    {
        $this->expectException(MaterialNotFoundException::class);
        $borrowRepository = $this->createMock(BorrowRepository::class);
        $materialRepository = $this->createMock(MaterialRepository::class);
        $materialRepository->method('find')->willReturn([]);
        $processor = new ReturnMaterialProcessor($materialRepository, $borrowRepository);
        $returnMaterialRequest = new ReturnMaterialRequest(1, 'Neuf', 'Néant', 'Aucun commentaire', new DateTime());
        $processor->process($returnMaterialRequest, new Post());
    }

    /**
     * @throws Exception|MaterialNotFoundException
     */
    public function test_invalid_material_id_throw_invalid_argument_exception()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Material id invalid');
        $borrowRepository = $this->createMock(BorrowRepository::class);
        $materialRepository = $this->createMock(MaterialRepository::class);
        $processor = new ReturnMaterialProcessor($materialRepository, $borrowRepository);
        $returnMaterialRequest = new ReturnMaterialRequest(-5, 'Neuf', 'Néant', 'Aucun commentaire', new DateTime());
        $processor->process($returnMaterialRequest, new Post());
    }

    /**
     * @throws Exception|MaterialNotFoundException
     */
    public function test_request_return_borrowed_material_from_repository()
    {
        $newState = 'Abimé';
        $newDetails = 'Petite rayure sur l\'écran';
        $borrowRepository = $this->createMock(BorrowRepository::class);
        $materialRepository = $this->createMock(MaterialRepository::class);
        $material = new Material(5, 'MBP05', 'Neuf', 'Aucun défaut', 'Emprunté', 'Néant');
        $borrow = new Borrow([], true, new \DateTime(), new \DateTime(), null, null);
        $borrower = new Borrower(7, 'John', 'Smith', 'LP CDTL B');
        $borrow->setMaterial($material);
        $borrow->setBorrower($borrower);
        $borrowRepository->method('findBy')->willReturn([$borrow]);
        $materialRepository->method('find')->willReturn($material);
        $borrowRepository->expects($this->once())->method('findBy');
        $materialRepository->expects($this->once())->method('find');
        $returnMaterialRequest = new ReturnMaterialRequest($material->getMaterialId(), $newState, $newDetails, $borrow->getBorrowReturnComment(), $borrow->getBorrowPeriodEnd());
        $provider = new ReturnMaterialProcessor($materialRepository, $borrowRepository);
        $result = $provider->process($returnMaterialRequest, new Post());

        $material->setMaterialStatus('En attente');
        $material->setMaterialSubStatus('À envoyer au SIGE');
        $material->setMaterialState($newState);
        $material->setMaterialDetails($newDetails);
        $this->assertEquals($material, $result);
    }
}