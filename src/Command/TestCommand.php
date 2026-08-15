<?php

namespace App\Command;

use App\Service\FilterService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test')]
class TestCommand extends Command
{
    public function __construct(
        protected FilterService $filterService
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $e =  $this->filterService->getAll();
        var_dump($e);
        return 0 ;
    }
}
