<?php

declare(strict_types=1);


namespace Backend\App\Command;

use Backend\Domain\Entity\Fleet;
use Backend\Domain\Entity\Location;
use Backend\Domain\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\Output;
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
            ->addArgument('lat', InputArgument::OPTIONAL, 'Location latitude')
            ->addArgument('lng', InputArgument::OPTIONAL, 'Location longitude')
            ->setHelp('This command allows you to localize a vehicle or set vehicle\'s location from a fleet')

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
        $lat = $input->getArgument('lat');
        $lng = $input->getArgument('lng');

        if ($lat && !is_numeric($lat)) {
            $output->writeln('<error>lat is incorrect</error>');

            return Command::FAILURE;
        }

        if ($lng && !is_numeric($lng)) {
            $output->writeln('<error>lng is incorrect</error>');

            return Command::FAILURE;
        }

        $lat = (float) $lat;
        $lng = (float) $lng;

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

        if ($lat && $lng) {
            return $this->parkVehicle($vehicle, $lat, $lng, $output);
        }

        return $this->localizeVehicle($vehicle, $output);
    }

    /**
     * @param Vehicle $vehicle
     * @param OutputInterface $output
     * @return int
     */
    private function localizeVehicle(Vehicle $vehicle, OutputInterface $output): int
    {
        $location = $vehicle->getLocation();

        if (!$location) {
            $output->writeln('<error>This vehicle is not anywhere. lol ?</error>');

            return Command::FAILURE;
        }

        $output->writeln($location->getLatitude() . " " . $location->getLongitude());

        return Command::SUCCESS;
    }

    /**
     * @param Vehicle $vehicle
     * @param float $lat
     * @param float $lng
     * @param OutputInterface $output
     * @return int
     */
    private function parkVehicle(Vehicle $vehicle, float $lat, float $lng, OutputInterface $output): int
    {
        $locationRepository = $this->entityManager->getRepository(Location::class);

        /** @var ?Location $location */
        $location = $locationRepository->findOneBy(['latitude' => $lat, 'longitude' => $lng]);

        if (!$location) {
            $output->writeln('<error>No location known with these coordinates</error>');

            return Command::FAILURE;
        }

        $vehicle->setLocation($location);

        $this->entityManager->persist($location);
        $this->entityManager->flush();

        $output->writeln(
            '<info>The vehicle is now parked at these coordinnates : ' . $lat . ' ' . $lng . '</info>'
        );

        return Command::SUCCESS;
    }
}
