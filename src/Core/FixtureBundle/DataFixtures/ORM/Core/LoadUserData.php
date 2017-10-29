<?php

namespace Core\FixtureBundle\DataFixtures\ORM\Core;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Core\UserBundle\Entity\User;

class LoadUserData  extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin')
            ->setPlainPassword('admin')
            ->setEmail('test@test.com')
            ->setName('Administrator')
            ->setEnabled(true);
        
        $em->persist($userAdmin);
        $em->flush();
        
        $this->addReference('admin', $userAdmin);
    }
    
    public function getOrder()
    {
        return 1;
    }
}