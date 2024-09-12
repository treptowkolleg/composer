<?php
/*
 * Copyright (c) 2022. Benjamin Wagner
 */

namespace Core\Component\DataStorageComponent;

use Core\Component\ConfigComponent\Config;
use Core\Model\AbstractModel;

class EntityManagerComponent extends AbstractModel
{

    /**
     * @var array|null[]
     */
    private array $dsn = [
        'host' => 'localhost',
        'dbname' => null,
        'charset' =>'utf8',
    ];
    /**
     * @var string|null
     */
    private ?string $username = null;

    /**
     * @var string|null
     */
    private ?string $password = null;

    private Config $config;

    /**
     * @param array $dsn
     * @param string|null $username
     * @param string|null $password
     * @param string|null $options
     * @param string $type
     */
    public function __construct(array $dsn = [], string $username = null, string $password = null, string $options = null, string $type = 'mysql')
    {
        $this->config = new Config('config/env.yaml');
        $databaseConfig = $this->config->getConfig('database');
        $this->dsn['host'] = $databaseConfig['DB_HOST'];
        $this->dsn['dbname'] = $databaseConfig['DB_NAME'];
        $this->username = $databaseConfig['DB_USER'];
        $this->password = $databaseConfig['DB_PASS'];

        parent::__construct($this->getDsn(), $this->getUsername(), $this->getPassword(), $options, $type);
    }

    /**
     * @return array|null[]
     */
    private function getDsn(): array
    {
        return $this->dsn;
    }

    /**
     * @return string|null
     */
    private function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @return string|null
     */
    private function getPassword(): ?string
    {
        return $this->password;
    }

}
