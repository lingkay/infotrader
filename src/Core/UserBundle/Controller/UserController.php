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

class UserController extends SecurityController
{
	protected $request;

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
                 ->setEnabled(1);

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
}