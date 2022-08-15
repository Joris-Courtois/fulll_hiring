<?php

declare(strict_types=1);


namespace Tests\Unit\Backend\App\Service;

use Domain\Entity\Fleet;
use Domain\Entity\Vehicle;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\Service\FleetManager;

class FleetManagerTest extends TestCase
{
    /** @var FleetManager */
    protected $fleetManager;

    /** @var EntityManager|MockObject */
    protected $entityManager;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManager::class);

        $this->fleetManager = new FleetManager($this->entityManager);
    }


    public function testRegisterSuccess(): void
    {
        $fleet = new Fleet();
        $vehicle = new Vehicle();

        $this->entityManager
            ->expects($this->once())
            ->method('persist')
        ;

        $this->entityManager
            ->expects($this->once())
            ->method('flush')
        ;

        $result = $this->fleetManager->register($fleet, $vehicle);

        $this->assertSame(true, $result);
    }

    public function testRegisterFail(): void
    {
        $fleet = new Fleet();
        $vehicle = new Vehicle();
        $fleet->addVehicle($vehicle);

        $this->entityManager
            ->expects($this->never())
            ->method('persist')
        ;

        $this->entityManager
            ->expects($this->never())
            ->method('flush')
        ;

        $result = $this->fleetManager->register($fleet, $vehicle);

        $this->assertSame(false, $result);
    }
}
