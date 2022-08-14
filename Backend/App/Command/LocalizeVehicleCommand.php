<?php

declare(strict_types=1);


namespace Backend\App\Command;

use Backend\Domain\Entity\Fleet;
use Backend\Domain\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LocalizeVehicleCommand extends Command
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('fleet:localize-vehicle')
            ->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet Id')
            ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'Vehicle Plate Number')
            ->setHelp('This command allows you to localize a vehicle from a fleet')

        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $vehicleRepository = $this->entityManager->getRepository(Vehicle::class);
        $fleetRepository = $this->entityManager->getRepository(Fleet::class);

        $fleetId = $input->getArgument('fleetId');
        $plateNumber = $input->getArgument('vehiclePlateNumber');

        if (!is_numeric($fleetId) || 1 > (int) $fleetId) {
            $output->writeln('<error>fleetId is not a valid number</error>');

            return Command::FAILURE;
        }

        /** @var ?Fleet $fleet */
        $fleet = $fleetRepository->find((int) $fleetId);

        if (!$fleet) {
            $output->writeln('<error>No fleet with fleetId :' . $fleetId . '</error>');

            return Command::FAILURE;
        }

        /** @var ?Vehicle $vehicle */
        $vehicle = $vehicleRepository->findOneBy(['plateNumber' => $plateNumber]);

        if (!$vehicle) {
            $output->writeln('<error>No vehicle with plate number :' . $plateNumber . '</error>');

            return Command::FAILURE;
        }

        if (!$fleet->hasVehicle($vehicle)) {
            $output->writeln('<error>This vehicle is not registered in this fleet</error>');

            return Command::FAILURE;
        }

        $location = $vehicle->getLocation();

        if (!$location) {
            $output->writeln('<error>This vehicle is not anywhere. lol ?</error>');

            return Command::FAILURE;
        }

        $output->writeln($location->getLatitude() . " " . $location->getLongitude());

        return Command::SUCCESS;
    }
}
