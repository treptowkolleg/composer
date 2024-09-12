<?php
/*
 * Copyright (c) 2022. Benjamin Wagner
 */

namespace Core\Component\SessionComponent;


use App\Entity\User;
use App\Repository\UserRepository;
use Core\Model\RepositoryFactory\AbstractRepositoryFactory;

class Session
{

    private bool $sessionStarted = false;
    private string $appSecret;

    public function __construct(string $appSecret)
    {
        $this->appSecret = $appSecret;
    }

    /**
     * @return $this
     */
    public function init(): Session
    {
        if (session_status() == 1) {
            session_start();
            $this->sessionStarted = true;
        }
        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value): Session
    {
        $_SESSION[$this->appSecret . $key] = $value;
        return $this;
    }

    /**
     * @param $key
     * @param false $secondKey
     * @return mixed
     */
    public function get($key, bool $secondKey = false): mixed
    {
        if ($secondKey == true) {
            if (isset($_SESSION[$this->appSecret . $key][$secondKey])) {
                return $_SESSION[$this->appSecret . $key][$secondKey];
            }
        } else {
            if (isset($_SESSION[$this->appSecret . $key])) {
                return $_SESSION[$this->appSecret . $key];
            }
        }
        return false;
    }

    public function getUser()
    {
       $userRepository = new UserRepository();

       $user = false;
       if(self::get('user') != 0 and self::get('login') === true)
       {
           $user = $userRepository->find(self::get('user'));
       }
        return $user;
    }

    public function UserHasPermission(string $condition): bool
    {
        if($user = self::getUser()) {
            foreach ($user->getPermissions() as $permission) {
                if ($condition == $permission->getLabel()) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @return array
     */
    public function display(): array
    {
        return $_SESSION;
    }

    /**
     * @param $key
     * @return $this
     */
    public function clear($key): Session
    {
        unset($_SESSION[$this->appSecret . $key]);
        return $this;
    }

    /**
     * @return $this
     */
    public function destroy(): Session
    {
        if ($this->sessionStarted) {
            session_unset();
            session_destroy();
        }
        return $this;
    }

}
