<?php

namespace App\Presentation\CLI\Command;

use App\Application\Command\AddAlertCommand;
use App\Application\ServiceBus\CommandBus;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateAlertCommand extends Command
{
    protected static $defaultName = 'app:create-alert';

    /** @var CommandBus */
    private $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new alert.')
            ->setHelp('This command allows you to create a alert...')
            ->addArgument('type', InputArgument::REQUIRED, 'Alert type')
            ->addArgument('latitude', InputArgument::REQUIRED, 'Alert latitude')
            ->addArgument('longitude', InputArgument::REQUIRED, 'Alert longitude');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $identity = Uuid::uuid4()->toString();
        $command = new AddAlertCommand(
            $identity,
            (string) $input->getArgument('type'),
            (float) $input->getArgument('latitude'),
            (float) $input->getArgument('longitude')
        );

        $this->commandBus->handle($command);

        $output->writeln('Success: ' . $identity);
    }
}