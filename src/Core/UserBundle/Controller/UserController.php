<?php

namespace Core\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use FOS\UserBundle\Controller\SecurityController;
use Doctrine\DBAL\DBALException;
use Core\ValidationException;

use Core\UserBundle\Entity\User;
use Evangeliko\AccountBundle\Entity\Account;
use Evangeliko\AccountBundle\Entity\Credit;
use Evangeliko\AccountBundle\Entity\AccountInterest;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

use DateTime;

class UserController extends SecurityController
{
	protected $request;

    public function loginAction(Request $request)
    {
        /** @var $session Session */
        $session = $request->getSession();
        $redirect  = $session->get('redirect');
        $account = $session->get('account');

        $session->remove('redirect');
        $session->remove('account');

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
            'redirect' => $redirect,
            'account' => $account
        ));
    }

    /**
     * Renders the login template with the given parameters. Overwrite this function in
     * an extended controller to provide additional data for the login template.
     *
     * @param array $data
     *
     * @return Response
     */
    protected function renderLogin(array $data)
    {
        $em = $this->getDoctrine()->getManager();

        $interests = $em->getRepository("EvangelikoAccountBundle:Interest")->findAll();

        $interest_list = [];

        foreach ($interests as $interest) {
            $interest_list[$interest->getName()] = $interest->getName();
        }

        $data['interest'] = $interest_list;

        return $this->render('CoreUserBundle:Security:login.html.twig', $data);
    } 

	public function registrationAction(Request $request)
	{
        $this->request = $request;

        $em = $this->getDoctrine()->getManager();
      
        $data = $this->request->request->all();

        $user = new User();

        try {

            $user_admin = $em->getRepository("CoreUserBundle:User")->findOneBy(['username' => 'admin']);

            $name = $data['first_name'].' '.$data['last_name'];

            $user->setUsername($data['email'])
                 ->setName($name)
                 ->setEmail($data['email'])
                 ->setEnabled(0);

            if (strlen($data['password']) <= 0)
                throw new ValidationException('Cannot leave password blank');

            if (strlen($data['retype']) <= 0)
                throw new ValidationException('Cannot leave password blank');

            if (strlen($data['password']) > 0) {
                if ($data['password'] != $data['retype'])
                    throw new ValidationException('Passwords do not match');

                $um = $this->container->get('fos_user.user_manager');
                $user->setPlainPassword($data['password']);
                $um->updatePassword($user);
            }

            $em->persist($user);

            $account = new Account();

            $account->setFirstName($data['first_name'])
                    ->setLastName($data['last_name'])
                    ->setEmail($data['email'])
                    ->setInterests($data['interest'])
                    ->setUsername(uniqid())
                    ->setUserCreate($user_admin);
                    
            $em->persist($account);
            $user->setAccount($account);

            foreach ($data['interest'] as $int) {
                $interest = $em->getRepository("EvangelikoAccountBundle:Interest")->findOneBy(['name' => $int]);

                $account_interest = new AccountInterest();

                $account_interest->setUserCreate($user_admin)
                                 ->setAccount($account)
                                 ->setInterest($interest);

                $em->persist($account_interest);
            }

            $credit = new Credit();

            $credit->setUserCreate($user_admin)
                   ->setAccount($account);

            $em->persist($credit);

            $em->flush();

            $this->sendActivationLinkAction($user->getID());

            $this->addFlash('success', "Registration Complete.");
            $url = $this->request->headers->get("referer");
            return new RedirectResponse($url);  

        } catch (ValidationException $e) {
            $this->addFlash('error', $e->getMessage());
            $url = $this->request->headers->get("referer");
            return new RedirectResponse($url);   
        } catch (DBALException $e) {
            $this->addFlash('error', 'Database error encountered. Possible duplicate.');
            $url = $this->request->headers->get("referer");
            return new RedirectResponse($url);
        }
	}

    public function reactivateLinkAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository("CoreUserBundle:User")->find($id);
        
        $this->sendActivationLinkAction($user->getID());

        $url = $this->generateUrl('core_user_login');
        return new RedirectResponse($url);
    }

    public function sendActivationLinkAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository("CoreUserBundle:User")->find($id);

        $mailer = $this->get('mailer');
        $date = new DateTime();
        $message = $mailer->createMessage()
                          ->setSubject("You have Completed Registration!")
                          ->setFrom("karlo@quadrantalpha.com")
                          ->setTo($user->getEmail())
                          ->setBody(
                                $this->renderView(
                                    "EvangelikoAccountBundle:Account:registration_email.html.twig",
                                    [
                                        'name' => $user->getAccount()->getFullName(),
                                        'date' => $date->format("d-m-Y"),
                                        'id' => $user->getID()
                                    ]
                                ),
                                'text/html'
                          );
        $mailer->send($message);
    }

    public function activateLinkAction(Request $request, $id, $date)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository("CoreUserBundle:User")->find($id);

        $date = new DateTime($date);
        $now = new DateTime();

        $interval = $now->diff($date);
        $session = $request->getSession();

        $session->remove('redirect');
        $session->remove('account');

        if ($interval->format('%a') != 0) {
            $session->set('redirect',true);
            $session->set('account',$user->getID());

            $url = $this->generateUrl('core_user_login');
            return new RedirectResponse($url);
        }else{
            $user->setEnabled(1);
            $em->flush();

            $url = $this->generateUrl('evangeliko_profile_about');
            return new RedirectResponse($url);  
        }
    }
}