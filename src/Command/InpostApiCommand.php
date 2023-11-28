<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Service\Inpost;
use App\Validator\Inpost\ResourceValidator;

#[AsCommand(
    name: 'inpostApi',
    description: 'Fetch and deserialize data from the Inpost API.',
)]
class InpostApiCommand extends Command
{
    public function __construct(
        private \App\Service\Inpost $service
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('resource', InputArgument::REQUIRED, 'Resource name')
            ->addArgument('city', InputArgument::REQUIRED, 'City name')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * 
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $resource = $input->getArgument('resource');
        $city = $input->getArgument('city');
        $io = new SymfonyStyle($input, $output);

        try {
            $resourceValidator = new ResourceValidator();
            $resourceValidator->validate($resource);

            if (!$city) {
                throw new \InvalidArgumentException('City parameter is required.');
            }

            $queryParam = 'city';

            $data = $this->service->getData($resource, $queryParam, $city);
            $message = 'No results found for the provided query.';
            if (count($data['items'])) {
                $message = 'Data fetched and deserialized successfully.';
                dump($data);
            }

            $io->success($message);
            return Command::SUCCESS;
        } catch (\InvalidArgumentException $e) {
            $io->error('Invalid input: ' . $e->getMessage());
            return Command::INVALID;
        } catch (\Exception $e) {
            $io->error('An error occurred while processing the data: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
