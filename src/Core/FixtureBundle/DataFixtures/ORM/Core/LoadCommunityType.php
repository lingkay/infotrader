<?php

namespace Core\FixtureBundle\DataFixtures\ORM\Core;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Evangeliko\CommunityBundle\Entity\CommunityType;

class LoadCommunityType extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $user = $this->getReference('admin');
        $interests = ['Public', 'Private'];
        foreach($interests as $interest){
            $pt = new CommunityType();
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