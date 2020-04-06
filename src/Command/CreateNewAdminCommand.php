<?php


namespace DrkDD\SchreibMit\Command;


use Doctrine\ORM\EntityManagerInterface;
use DrkDD\SchreibMit\Entity\Admin;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class CreateNewAdminCommand extends Command
{
    protected static $defaultName = 'drk:create-admin';

    /** @var EntityManagerInterface */
    protected $entityManager;

    public function __construct(EntityManagerInterface $em, $name = null)
    {
        parent::__construct($name);

        $this->entityManager = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create an Admin user for the backend')
            ->setHelp('Create an Admin user for the backend');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $nameQuestion = new Question('Name of the admin? : ');
        $username = $helper->ask($input, $output, $nameQuestion);

        $passwordQuestion = new Question('Password : ');
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(false);

        $password = $helper->ask($input, $output, $passwordQuestion);

        $admin = new Admin();
        $admin->setUsername($username);
        $admin->setPlainPassword($password);

        $this->entityManager->persist($admin);
        $this->entityManager->flush();

        $output->writeln('Admin created');

        return 0;
    }
}