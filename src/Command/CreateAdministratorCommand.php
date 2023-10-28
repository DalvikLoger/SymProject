<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-administrator',
    description: 'Add a short description for your command',
)]
class CreateAdministratorCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent:: __construct('app:create-administrator');
        $this->entityManager = $entityManager;
    }
    protected function configure(): void
    {
        $this
            ->addArgument('full_name', InputArgument::OPTIONAL, 'Argument description')
            ->addArgument('email', InputArgument::OPTIONAL, 'Argument description')
            ->addArgument('password', InputArgument::OPTIONAL, 'Argument description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        $io = new SymfonyStyle($input, $output);

        $fullName = $input->getArgument('full_name');
        if (!$fullName) {
            $question = new Question('Quel est le nom de l\'administrateur : ');
            $fullName = $helper->ask($input, $output, $question);
        }

        $email = $input->getArgument('email');
        if (!$email) {
            $question = new Question('Quel est l\'email de ' . $fullName . ' : ');
            $email = $helper->ask($input, $output, $question);
        }

        $Password = $input->getArgument('password');
        if (!$Password) {
            $question = new Question('Quel est le mot de passe de ' . $fullName . ' : ');
            $Password = $helper->ask($input, $output, $question);
        }

        $user = (new User())
            ->setFullName($fullName)
            ->setEmail($email)
            ->setPassword($Password)
            ->setRoles(['ROLE_USER','ROLE_ADMIN']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
