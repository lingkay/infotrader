<?php

namespace Core\FixtureBundle\DataFixtures\ORM\Core;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Evangeliko\AccountBundle\Entity\Interest;

class LoadInterest extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $user = $this->getReference('admin');
        $interests = ['Cars', 'Lifestyle', 'Finance', 'Food', 'Travel and Leisure'];
        foreach($interests as $interest){
            $pt = new Interest();
            $pt->setName($interest)
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