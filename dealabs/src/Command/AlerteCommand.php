<?php
/**
 * Created by PhpStorm.
 * User: Elsword XIII
 * Date: 23/06/2020
 * Time: 11:19
 */

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AlerteCommand extends Command
{
    protected static $defaultName = 'app:send-alertes';

    protected function configure()
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return 0;
    }
}