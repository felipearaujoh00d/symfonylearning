<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SoundAlarmCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:sound-alarm')
            ->addArgument('message', InputArgument::REQUIRED, 'Message to be broadcast')
            ->addOption('yell')
            ->setDescription('Sound alarm on security breach');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = 'Alarm: ' . $input->getArgument('message');

        if ($input->getOption('yell')) {
            $message = strtoupper($message) . ' !!!';
        }

        $output->write($message);
    }
}
