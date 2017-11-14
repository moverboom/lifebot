<?php
/**
 * Created by PhpStorm.
 * User: matthijs
 * Date: 14-11-17
 * Time: 20:30
 */

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class HaveIBeenPwndCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('lifebot:pwnd')
            ->setDescription('Fetches possible new account breaches from haveibeenpwnd.com');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $haveIBeenPwnd = $this->getContainer()->get('api.haveibeenpwnd');
        $haveIBeenPwnd->getAccountBreaches($this->getContainer()->getParameter('haveibeenpwnd_accounts'));
    }
}