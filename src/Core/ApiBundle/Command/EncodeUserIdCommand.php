<?php

namespace Core\ApiBundle\Command;

use Hashids\Hashids;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EncodeUserIdCommand extends ContainerAwareCommand
{
  const MIN_HASH_LENGTH = 6;
  protected function configure()
  {
    $this
      ->setName('app:user:encode-id')
      ->setDescription('Encodes the user ID to a unique string')
      ->addArgument('user', InputArgument::REQUIRED, 'The user ID');
  }
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $em = $this->getContainer()->get('doctrine.orm.entity_manager');
    $userID = (int) $input->getArgument('user');
    if (!($user = $em->getRepository('CoreUserBundle:User')->find($userID))) {
      $output->writeln(sprintf('Could not find user with ID "%d"', $userID));
      return false;
    }
    // encode the user's ID
    $encoder = new Hashids($this->getContainer()->getParameter('secret'), self::MIN_HASH_LENGTH);
    $hashid = $encoder->encode($user->getId());
    $user->setHashid($hashid);
    $em->flush();
    $output->writeln(sprintf('Created hashid for user: %s', $hashid));
  }
}