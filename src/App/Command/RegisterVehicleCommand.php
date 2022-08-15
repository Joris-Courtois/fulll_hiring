<?php

declare(strict_types=1);


namespace App\Command;

use App\Service\FleetManager;
use Domain\Entity\Fleet;
use Domain\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterVehicleCommand extends Command
{
    protected static $defaultDescription = 'Register a vehicle in a fleet';

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /** @var FleetManager */
    protected $fleetManager;

    public function __construct(EntityManagerInterface $entityManager, FleetManager $fleetManager)
    {
        $this->entityManager = $entityManager;
        $this->fleetManager = $fleetManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('fleet:register-vehicle')
            ->addArgument('fleetId', InputArgument::REQUIRED, 'Fleet Id')
            ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'Vehicle Plate Number')
            ->setHelp('This command allows you to register a vehicle in a fleet')

        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
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

        $registrationSuccess = $this->fleetManager->register($fleet, $vehicle);

        if (false === $registrationSuccess) {
            $output->writeln('<error>The vehicle has already been registered in this fleet</error>');

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
