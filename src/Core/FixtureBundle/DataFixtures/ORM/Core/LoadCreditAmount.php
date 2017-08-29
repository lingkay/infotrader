<?php

namespace Core\FixtureBundle\DataFixtures\ORM\Core;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Evangeliko\AccountBundle\Entity\CreditAmount;

class LoadCreditAmount extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $user = $this->getReference('admin');
        $amts = [100.00, 500.00, 1000.00];
        foreach($amts as $amt){
            $pt = new CreditAmount();
            $pt->setPrice($amt)
               ->setUserCreate($user);
            
            $em->persist($pt);
        }
        $em->flush();
    }
    
    public function getOrder()
    {
        return 2;
    }
}