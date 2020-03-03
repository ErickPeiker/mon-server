<?php

namespace App\Controller;

use App\Base\Controller\BaseController;
use App\Base\Util\JwtUtil;
use App\Entity\User;
use App\Entity\Menu;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class LoginController extends BaseController
{
    private $jwtUtil;
    private $jwtTtl;
    private $userPasswordEncoder;

    public function __construct(
        JwtUtil $jwtUtil,
        UserPasswordEncoderInterface $userPasswordEncoder,
        string $jwtTtl
    )
    {
        $this->jwtUtil = $jwtUtil;
        $this->jwtTtl = $jwtTtl;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['email' => $email], false);

        abortIf(
            (!$user || !$this->userPasswordEncoder->isPasswordValid($user, $password)),
            400,
            'Email ou senha inválidos'
        );

        // $menus = array_unique(array_reduce($user->getGroups()->map(function ($group) {
            // return $group->getMenus()->filter(function ($menu) {
                // return !$menu->getMenu();
            // })->toArray();
        // })->toArray(), 'array_merge', array()), SORT_REGULAR);

        // if (in_array('ROLE_ADMIN', $user->getRoles())) {
            // $menus = $this->getDoctrine()->getRepository(Menu::class)->findBy(['menu' => null], ['sequence' => 'ASC'])->toArray(['toArrayMenus' => []]);
        // }
        $menus = $this->getDoctrine()->getRepository(Menu::class)->findBy(['menu' => null], ['sequence' => 'ASC'])->toArray(['toArrayMenus' => []]);

        $tokenData = [
            'id' => uniqid(),
            'created_at' => (new DateTime())->format(DATE_ISO8601),
            // 'expires_at' => (new DateTime())->modify($this->jwtTtl)->format(DATE_ISO8601),
            'user' => [
                'id' => $user->getId(),
                'roles' => $user->getRoles(),
            ],
            'menus' => $menus,
        ];
        // dd($tokenData);

        $user->setApiToken($this->jwtUtil->encode($tokenData));

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return new JsonResponse([
            'user' => $user->toArray(),
            'apiToken' => $user->getApiToken(),
        ]);
    }
}
