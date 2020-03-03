<?php

declare(strict_types=1);

namespace App\Base\Security;

use App\Entity\User;
use App\Repository\RouteRepository;
use App\Base\Util\JwtUtil;
// use DateTime;
use Exception;
use InvalidArgumentException;
use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

class JwtUserAuthenticator implements SimplePreAuthenticatorInterface
{
    private $jwtUtil;
    private $routeRepository;
    private $route;

    public function __construct(JwtUtil $jwtUtil, RouteRepository $routeRepository)
    {
        $this->jwtUtil = $jwtUtil;
        $this->routeRepository = $routeRepository;
    }

    public function createToken(Request $request, $providerKey)
    {
        $token = $request->headers->get('Authorization');
        abortIf(!$token, 401, 'Token inválido');

        $this->route = $this->routeRepository->findOneBy(['path' => $request->get('_route')]);

        return new PreAuthenticatedToken('anon.', $token, $providerKey);
    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        if (!$userProvider instanceof JwtUserProvider) {
            throw new InvalidArgumentException('Invalid provider');
        }

        $tokenData = $this->validateToken($token);

        $user = $userProvider->loadUserByUsername($tokenData->user->id);
        abortIf(
            (!$user instanceof User || $user->getApiToken() !== $token->getCredentials()),
            401,
            'Acesso negado'
        );

        $this->validateUser($user);

        return new PreAuthenticatedToken($user, $user->getUsername(), $providerKey, $user->getRoles());
    }

    private function validateToken(TokenInterface $token): stdClass
    {
        try {
            $tokenData = $this->jwtUtil->decode($token->getCredentials());
        } catch (Exception $e) {
            abort(401, 'Token inválido');
        }

        // $expiresAt = new DateTime($tokenData->expires_at);
        // if ($expiresAt < new DateTime()) {
            // abort(401, 'Token expirado')
        // }

        return $tokenData;
    }

    private function validateUser(User $user)
    {
        $contains = false;
        foreach ($user->getGroups() as $group) {
            if ($group->getRoutes()->contains($this->route)) {
                $contains = true;
                break;
            }
        }

        abortIf((!$contains && !in_array('ROLE_ADMIN', $user->getRoles())), 401, 'Acesso negado');
    }
}
