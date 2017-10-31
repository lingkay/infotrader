<?php
// AppBundle\Controller\Api\RestaurantApiController.php
namespace Core\ApiBundle\Controller\Api;
use Core\ApiBundle\Entity\AccessToken;
use Core\UserBundle\Entity\User;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\Annotations as Rest;
use Hashids\Hashids;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class UserApiController extends FOSRestController
{
  const MIN_HASH_LENGTH = 6;
  
  /**
   * @Rest\Get("/user_info/{hashid}", name="api.user")
   */
  public function getUserAction(User $user)
  {
    $view = View::create();

    if ($this->isGranted('ROLE_WIDGET')) {
      $token = $this->get('fos_oauth_server.access_token_manager')->findTokenByToken($this->get('security.token_storage')->getToken()->getToken());

      if ($token->getUser()->getId() !== $user->getId()) {
        throw new AccessDeniedException();
      }
      $context = new Context();
      $context->setGroups(array('widget'));
      $view->setContext($context);
    }
    $view->setData(array(
      'user' => $user,
    ));
    return $view;
  }

  /**
   * @Rest\Post("/user_register", name="api.user_register")
   */
  public function registerUserAction(Request $request)
  {

        $user = new User();
        $data = $request->request->all();
        
        $clientManager = $this->container->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();

        $client->setAllowedGrantTypes(["authorization_code","password","refresh_token","token","client_credentials"]);
        $clientManager->updateClient($client);

        $user->setOAuthClient($client);

        $password = $data['password'];
        $email = $data['email'];
        $username = $data['password'];
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setEnabled(1);
        $user->setUsername($username);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();


        $encoder = new Hashids($this->container->getParameter('secret'), self::MIN_HASH_LENGTH);
        $hashid = $encoder->encode($user->getId());
        $user->setHashid($hashid);
        $em->flush();

        return $user->getHashid();
  }
}