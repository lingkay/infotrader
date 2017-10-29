<?php

namespace Core\FixtureBundle\DataFixtures\ORM\Core;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Evangeliko\PostBundle\Entity\PostType;

class LoadPostType extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $user = $this->getReference('admin');
        $interests = ['Free', 'Paid'];
        foreach($interests as $interest){
            $pt = new PostType();
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