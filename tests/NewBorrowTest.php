<?php

namespace App\Tests;

use ApiPlatform\Metadata\Post;
use App\Controller\NewBorrowProcessor;
use App\DTO\BorrowInput;
use App\Repository\BorrowerRepository;
use App\Repository\BorrowRepository;
use App\Repository\MaterialRepository;
use DateTime;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class NewBorrowTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function test_processor_create_a_new_borrow()
    {
        $borrowRepository = $this->createMock(BorrowRepository::class);
        $borrowerRepository = $this->createMock(BorrowerRepository::class);
        $materialRepository = $this->createMock(MaterialRepository::class);
        $borrowRepository->expects($this->once())->method('save');
        $processor = new NewBorrowProcessor($borrowRepository, $borrowerRepository, $materialRepository);
        $borrow = new BorrowInput(borrowPeriodStart: new DateTime(), borrowPeriodEnd: new DateTime(), materialId: 1, borrowerId: 1);
        $processor->process($borrow, new Post());
    }

    /**
     * @throws Exception
     */
    public function test_processor_didnt_create_a_new_borrower()
    {
        $borrowRepository = $this->createMock(BorrowRepository::class);
        $borrowerRepository = $this->createMock(BorrowerRepository::class);
        $materialRepository = $this->createMock(MaterialRepository::class);
        $borrowerRepository->expects($this->never())->method('save');
        $processor = new NewBorrowProcessor($borrowRepository, $borrowerRepository, $materialRepository);
        $borrow = new BorrowInput(borrowPeriodStart: new DateTime(), borrowPeriodEnd: new DateTime(), materialId: 1, borrowerId: 1);
        $processor->process($borrow, new Post());
    }

    /**
     * @throws Exception
     */
    public function test_processor_throws_invalid_arguments_exception_when_missing_material_id()
    {
        $this->expectException(InvalidArgumentException::class);
        $borrowRepository = $this->createMock(BorrowRepository::class);
        $borrowerRepository = $this->createMock(BorrowerRepository::class);
        $materialRepository = $this->createMock(MaterialRepository::class);
        $processor = new NewBorrowProcessor($borrowRepository, $borrowerRepository, $materialRepository);
        $borrow = new BorrowInput(borrowPeriodStart: new DateTime(), borrowPeriodEnd: new DateTime(), materialId: 1);
        $processor->process($borrow, new Post());
    }

    /**
     * @throws Exception
     */
    public function test_processor_throws_invalid_arguments_exception_when_missing_either_names_or_group()
    {
        $this->expectException(InvalidArgumentException::class);
        $borrowRepository = $this->createMock(BorrowRepository::class);
        $borrowerRepository = $this->createMock(BorrowerRepository::class);
        $materialRepository = $this->createMock(MaterialRepository::class);
        $processor = new NewBorrowProcessor($borrowRepository, $borrowerRepository, $materialRepository);
        $borrow = new BorrowInput(borrowPeriodStart: new DateTime(), borrowPeriodEnd: new DateTime(), materialId: 1, borrowerFirstName: 'Arthur', borrowerGroup: 'LP CDTL DFS B');
        $processor->process($borrow, new Post());
    }
    

}