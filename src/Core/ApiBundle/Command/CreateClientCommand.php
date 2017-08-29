<?php
# src/Carmudi/AdminBundle/Command/CreateClientCommand.php
namespace Core\ApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Core\UserBundle\Entity\User;

class CreateClientCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('core:oauth-server:client:create')
            ->setDescription('Create Client Auth details')
            ->addOption(
                'grant-type',
                'password',
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Sets allowed grant type for client. Use this option multiple times to set multiple grant types..',
                null
            )
            ->addArgument(
                'user'
            )
            ->addArgument(
                'pass'
            )
            ->addArgument(
                'email'
            );
            
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('user');
        $plainpassword = $input->getArgument('pass');
        $email = $input->getArgument('email');

        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
       // $client->setRedirectUris($input->getOption('redirect-uri'));
        $client->setAllowedGrantTypes($input->getOption('grant-type'));
        $clientManager->updateClient($client);
        
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');
        $user = new User();
        $user->setUserName($username);
        $user->setPlainPassword($plainpassword);
        $user->setEmail($email);
        //automatically enables user
        $user->setEnabled(1);
        
        $em->persist($user);
        $em->flush();
        //$user_id = $user->getId();

        $output->writeln(
            sprintf(
                'Added a new client with public id <info>%s</info>, secret <info>%s</info>',
                $client->getPublicId(),
                $client->getSecret()
            )
        );

    }
}