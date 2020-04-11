<?php
declare(strict_types=1);

namespace DrkDD\SchreibMit\Command;

use Doctrine\ORM\EntityManagerInterface;
use DrkDD\SchreibMit\Entity\Admin;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Kommando zum Anlegen eines administrativen Nutzers für das Backend
 *
 * Class CreateNewAdminCommand
 * @package DrkDD\SchreibMit\Command
 */
class CreateNewAdminCommand extends Command
{
    protected static $defaultName = 'drk:create-admin';

    /** @var EntityManagerInterface */
    protected $entityManager;
    /** @var TranslatorInterface */
    protected $translator;

    /**
     * CreateNewAdminCommand constructor.
     * @param EntityManagerInterface $em
     * @param TranslatorInterface    $translator
     * @param null|string            $name
     */
    public function __construct(EntityManagerInterface $em, TranslatorInterface $translator, $name = null)
    {
        $this->entityManager = $em;
        $this->translator = $translator;

        parent::__construct($name);
    }

    /**
     *
     */
    protected function configure(): void
    {
        $this
            ->setDescription(
                $this->translator->trans('command.create_admin.description')
            )
            ->setHelp(
                $this->translator->trans('command.create_admin.help')
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $nameQuestion = new Question(
            $this->translator->trans('command.create_admin.question_name')
        );
        $username = $helper->ask($input, $output, $nameQuestion);

        $passwordQuestion = new Question(
            $this->translator->trans('command.create_admin.question_password')
        );
        $passwordQuestion->setHidden(true);
        $passwordQuestion->setHiddenFallback(false);

        $password = $helper->ask($input, $output, $passwordQuestion);

        $admin = new Admin();
        $admin->setUsername($username);
        $admin->setPlainPassword($password);

        $this->entityManager->persist($admin);
        $this->entityManager->flush();

        $output->writeln(
            $this->translator->trans('command.create_admin.success')
        );

        return 0;
    }
}