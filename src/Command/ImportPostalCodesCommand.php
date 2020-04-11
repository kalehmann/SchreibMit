<?php
declare(strict_types=1);

namespace DrkDD\SchreibMit\Command;

use DrkDD\SchreibMit\Entity\PostalCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Kommando zum Importieren der Postleizahlen-Geodatenbank von Launix.
 *
 * Class ImportPostalCodesCommand
 * @package DrkDD\SchreibMit\Command
 */
class ImportPostalCodesCommand extends Command
{
    protected static $defaultName = 'drk:import-postal';

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var TranslatorInterface */
    protected $translator;

    /**
     * ImportPostalCodesCommand constructor.
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
                $this->translator->trans('command.import_postal.description')
            )
            ->setHelp(
                $this->translator->trans('command.import_postal.help')
            )
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                $this->translator->trans('command.import_postal.argument_file')
            );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $addedPostalCodes = 0;
        $filename = $input->getArgument('file');
        $postalRepo = $this->entityManager->getRepository(PostalCode::class);

        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
                $normalizedPostalCode = str_pad($data[0], 5, '0', STR_PAD_LEFT);
                $postal = $postalRepo->find($normalizedPostalCode) ?? new PostalCode();

                $postal->setPostalCode($normalizedPostalCode);
                $postal->setLongitude((float)$data[2]);
                $postal->setLatitude((float)$data[3]);

                $this->entityManager->persist($postal);
                $addedPostalCodes++;
            }
            $this->entityManager->flush();

            fclose($handle);
        }

        $output->writeln(
            $addedPostalCodes .
            $this->translator->trans('command.import_postal.success')
        );

        return 0;
    }
}