<?php
/**
 * This file is part of Xpto system
 *
 * @copyright Xpto
 * @license   proprietary
 */
namespace Xpto\Service\Auth;

use Silex\Application;
use DateInterval;
use DateTime;
use Domain\Service\Auth\Login as LoginServiceInterface;
use Domain\Entity\Users\Profile as ProfileModel;
use Domain\Entity\Users\User as UserModel;
use Xpto\Entity\Login\Token as UserToken;
use Common\Password;
use Xpto\Repository\Users\Profile as ProfileRepository;
use Xpto\Repository\Users\User as UserRepository;
use InvalidArgumentException;
use Rhumsaa\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 * @author Marcel Araujo <ceceldada@gmail.com>
 */
class Login implements LoginServiceInterface
{
    /**
     * @var string
     */
    const AUTH_VALIDATE_CREDENTIALS = 'auth.validate.credentials';

    /**
     * @var string
     */
    const AUTH_VALIDATE_TOKEN = 'auth.validate.token';

    /**
     * @var string
     */
    const AUTH_NEW_TOKEN = 'auth.new.token';

    /**
     * @var string
     */
    const AUTH_USER_GET = 'auth.user.get';

    /**
     * @var array
     */
    protected $config = [];

    /**
     * Entity Manager
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::register()
     */
    public function register(Application $app)
    {
        $service = $this;
        $this->em = $app['orm.em'];

        $app[self::AUTH_VALIDATE_CREDENTIALS] = $app->protect(
            function ($user, $pass) use ($service) {
                return $service->validateCredentials($user, $pass);
            }
        );

        $app[self::AUTH_VALIDATE_TOKEN] = $app->protect(
            function ($token) use ($service) {
                return $service->validateToken($token);
            }
        );

        $app[self::AUTH_NEW_TOKEN] = $app->protect(
            function ($user, $request) use ($service) {
                return $service->getNewTokenForUser($user, $request);
            }
        );

        $app[self::AUTH_USER_GET] = $app->protect(
            function ($token) use ($app, $service) {
                /* @var $profile \Xpto\Entity\Users\Profile */
                $profile = $service->loadUserByToken($token);

                // Store the user data into container
                $app['user'] = $profile->getUser();

                return $profile;
            }
        );
    }

    /**
     * (non-PHPdoc)
     * @see \Silex\ServiceProviderInterface::boot()
     */
    public function boot(Application $app)
    {

    }

    /**
     * Auth user
     *
     * @param  string $username
     * @param  string $password
     * @return UserModel
     */
    public function validateCredentials($username, $password)
    {
        $repository = new UserRepository($this->em);
        $user = $repository->findByEmail($username);

        if (Password::verify($password, $user->getPassword()) === false) {
            throw new InvalidArgumentException('Password is invalid', Response::HTTP_UNAUTHORIZED);
        }

        return $user;
    }

    /**
     * Validate the token
     *
     * @param  string $token
     * @return boolean
     */
    public function validateToken($token = null)
    {
        if ($token === null) {
            return false;
        }

        $user = $this->em->getRepository('Xpto\Entity\Login\Token')->findOneBy(
            [
                'content' => $this->getToken($token),
                'status' => UserToken::ACTIVE
            ]
        );

        return $user !== null;
    }

    /**
     * Get token from split string
     *
     * @param  $token string
     * @return string
     */
    public function getToken($token)
    {
        $arr = explode(' ', $token);
        $token = array_pop($arr);

        return $token;
    }


    /**
     * Create a new token for the user
     *
     * @param  UserModel $user
     * @param  Request $request
     * @return string
     */
    public function getNewTokenForUser(UserModel $user, Request $request)
    {
        $hash = Uuid::uuid4()->toString();

        $expiration = new DateInterval('P7D');

        $token = new UserToken();
        $token->setUser($user);
        $token->setContent($hash);
        $token->setStatus(UserToken::ACTIVE);
        $token->setExpiration((new DateTime())->add($expiration));
        $token->setAddress($request->getClientIp());
        $token->setAgent($request->headers->get('User-Agent'));

        $this->em->persist($token);
        $this->em->flush();

        return $hash;
    }

    /**
     * Load user by token
     *
     * @param  string $token
     * @return ProfileModel
     */
    public function loadUserByToken($token)
    {
        $token = $this->getToken($token);

        $userRepository = new UserRepository($this->em);
        $user = $userRepository->findByToken($token);

        $profileRepository = new ProfileRepository($this->em);
        $profile = $profileRepository->findByUser($user);

        return $profile;
    }

    /**
     * Save Token
     *
     * @param  UserToken $token
     * @return UserToken
     */
    public function save(UserToken $token)
    {
        $this->em->persist($token);
        $this->em->flush();

        return $token;
    }
}
