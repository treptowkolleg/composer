<?php

namespace App\Entity;

use Core\Component\UserComponent\PasswordService;
use Core\Model\DateTimeEntityTrait;
use Core\Model\IdEntityTrait;
use Core\Service\EncryptionService;

final class User
{
    use IdEntityTrait;
    use DateTimeEntityTrait;
    protected ?string $firstName;
    protected ?string $lastName;
    protected string $username;
    protected string $password;
    protected string $email;
    protected bool $active;
    protected ?string $userLocale;

    private EncryptionService $encryptionService;

    public function __construct()
    {
        $this->encryptionService = new EncryptionService();
    }

    public function __toString()
    {
        return $this->username;
    }

    public function getFullName(): string
    {
        return $this->getFirstName(true) . ' ' . $this->getLastName(true);
    }

    /**
     * @param bool $decrypt if parameter is true, first name will be decrypted.
     * @return string|null first name or null if not set.
     */
    public function getFirstName(bool $decrypt = false): ?string
    {
        $firstName = $this->firstName;
        if($decrypt)
        {
            $firstName = $this->encryptionService->decryptString($firstName);
        }
        return $firstName;
    }

    /**
     * @param string|null $firstName sets first name of current user object.
     * @return User user object to enable method chaining.
     */
    public function setFirstName(?string $firstName): User
    {
        $this->firstName = $this->encryptionService->encryptString($firstName);
        return $this;
    }

    /**
     * @param bool $decrypt if parameter is true, last name will be decrypted.
     * @return string|null last name or null if not set.
     */
    public function getLastName(bool $decrypt = false): ?string
    {
        $lastName = $this->lastName;
        if($decrypt)
        {
            $lastName = $this->encryptionService->decryptString($lastName);
        }
        return $lastName;
    }

    /**
     * @param string|null $lastName sets last name of current user object.
     * @return User user object to enable method chaining.
     */
    public function setLastName(?string $lastName): User
    {
        $this->lastName = $this->encryptionService->encryptString($lastName);
        return $this;
    }

    /**
     * @param bool $decrypt
     * @return string
     */
    public function getUsername(bool $decrypt = false): string
    {
        $username = $this->username;
        if($decrypt)
        {
            $username = $this->encryptionService->decryptString($username);
        }
        return $username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $this->encryptionService->encryptString($username);
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = PasswordService::hash($password);
        return $this;
    }

    /**
     * @param bool $decrypt
     * @return string
     */
    public function getEmail(bool $decrypt = false): string
    {
        $email = $this->email;
        if($decrypt)
        {
            $email = $this->encryptionService->decryptString($email);
        }
        return $email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $this->encryptionService->encryptString($email);
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return User
     */
    public function setActive(bool $active): User
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return string
     */
    public function getUserLocale(): string
    {
        return $this->userLocale;
    }

    /**
     * @param string $userLocale
     * @return User
     */
    public function setUserLocale(string $userLocale): User
    {
        $this->userLocale = $userLocale;
        return $this;
    }

}