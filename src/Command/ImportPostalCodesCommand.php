<?php


namespace App\Command;


use App\Entity\PostalCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportPostalCodesCommand
 * @package App\Command
 */
class ImportPostalCodesCommand extends Command
{
    protected static $defaultName = 'drk:import-postal';

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
            ->setDescription('Import csv with postal codes')
            ->setHelp('Import csv with postal codes')
            ->addArgument('file', InputArgument::REQUIRED , 'Postal codes');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('file');
        $addedPostalCodes = 0;

        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
                $normalizedPostalCode = str_pad($data[0], '5', '0', STR_PAD_LEFT);
                $postal = new PostalCode();

                $postal->setPostalCode($normalizedPostalCode);
                $postal->setLongitude($data[2]);
                $postal->setLatitude($data[3]);

                $this->entityManager->persist($postal);
                $addedPostalCodes++;
            }
            $this->entityManager->flush();

            fclose($handle);
        }

        $output->writeln($addedPostalCodes . ' Postleitzahlen importiert');

        return 0;
    }
}