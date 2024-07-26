<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteUserCommand extends Command
{
    protected static $defaultName = 'app:delete-user';

    private $entityManager;
    private $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Deletes an existing user.')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user to delete.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');

        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            $output->writeln('User not found.');
            return Command::FAILURE;
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        $output->writeln('User deleted successfully!');

        return Command::SUCCESS;
    }
}
