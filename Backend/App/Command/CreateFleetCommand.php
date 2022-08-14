<?php

declare(strict_types=1);

namespace Backend\App\Command;

use Backend\Domain\Entity\Fleet;
use Backend\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateFleetCommand extends Command
{
    protected static $defaultDescription = 'Creates a fleet for an user';

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('fleet:create')
            ->addArgument('userId', InputArgument::REQUIRED, 'User Id')
            ->setHelp('This command allows you to create a fleet for an user if it does not already exist')

        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $userRepository = $this->entityManager->getRepository(User::class);

        $userId = $input->getArgument('userId');

        if(!is_numeric($userId) || 1 > (int) $userId ) {
            $output->writeln('<error>UserId is not a valid number</error>');

            return Command::FAILURE;
        }

        $userId = (int) $userId;

        /** @var ?User $user */
        $user = $userRepository->find($userId);

        if (!$user) {
            $output->writeln('<error>No user with UserId :' . $userId . '</error>');

            return Command::FAILURE;
        }

        if (null !== $user->getFleet()) {
            $output->writeln('<error>User has already a fleet</error>');

            return Command::FAILURE;
        }

        $fleet = new Fleet;
        $user->setFleet($fleet);

        $this->entityManager->persist($fleet);
        $this->entityManager->persist($user);

        $this->entityManager->flush();

        $output->writeln($fleet->getId());

        return Command::SUCCESS;
    }
}