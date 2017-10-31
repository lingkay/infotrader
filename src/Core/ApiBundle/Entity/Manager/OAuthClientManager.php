<?php
// AppBundle\Entity\Manager\OAuthClientManager.php

namespace Core\ApiBundle\Entity\Manager;
use Core\ApiBundle\Entity\Client;
use Doctrine\ORM\NonUniqueResultException;
use FOS\OAuthServerBundle\Entity\ClientManager;

class OAuthClientManager extends ClientManager
{
  public function findOAuthClientByUserHashid($hashid)
  {
    $test =  $this->repository->createQueryBuilder('cl')
      ->from('CoreUserBundle:User', 'u')
      ->join('u.oauthClient', 'c')
      ->where('cl = c')
      ->andWhere('u.hashid = :hashid')
      ->setParameter('hashid', $hashid)
      ->getQuery()
      ->getOneOrNullResult();

    return $test;
  }


}