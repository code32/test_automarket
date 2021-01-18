<?php

namespace App\Command;

use App\Repository\CarRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreativeSalesCommand extends Command
{
    protected static $defaultName = 'app:creative-sales';

    protected $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('all cars with a mileage of more than 150,000 km will reduce it by 30%.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $this->carRepository->mileageReduction(150000, 30);
        } catch (\Doctrine\ORM\ORMException $e) {
            $io->error($e->getMessage());
        }

        $io->success('Creative sales successfully completed');

        return Command::SUCCESS;
    }
}
