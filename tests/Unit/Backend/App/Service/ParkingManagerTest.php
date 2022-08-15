<?php

declare(strict_types=1);


namespace Tests\Unit\Backend\App\Service;

use Domain\Entity\Location;
use Domain\Entity\Vehicle;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\Service\ParkingManager;

class ParkingManagerTest extends TestCase
{
    /** @var EntityManager|MockObject */
    protected $entityManager;

    /** @var ParkingManager */
    protected $parkingManager;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManager::class);

        $this->parkingManager = new ParkingManager($this->entityManager);
    }

    public function testParkSuccess(): void
    {
        $location = new Location();
        $vehicle = new Vehicle();

        $this->entityManager
            ->expects($this->once())
            ->method('persist')
        ;

        $this->entityManager
            ->expects($this->once())
            ->method('flush')
        ;

        $result = $this->parkingManager->park($vehicle, $location);

        $this->assertSame(true, $result);
    }

    public function testParkFail(): void
    {
        $location = new Location();
        $vehicle = new Vehicle();
        $vehicle->setLocation($location);

        $this->entityManager
            ->expects($this->never())
            ->method('persist')
        ;

        $this->entityManager
            ->expects($this->never())
            ->method('flush')
        ;

        $result = $this->parkingManager->park($vehicle, $location);

        $this->assertSame(false, $result);
    }
}
