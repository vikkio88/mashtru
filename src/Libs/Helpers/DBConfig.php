<?php


namespace Mashtru\Libs\Helpers;


class DBConfig
{
    private $host;
    private $db;
    private $user;
    private $password;

    function __construct($host, $dbName, $user, $password)
    {
        $this->host = $host;
        $this->db = $dbName;
        $this->user = $user;
        $this->password = $password;
    }

    public function toArray()
    {
        return [
            'host' => $this->host,
            'db' => $this->db,
            'user' => $this->user,
            'password' => $this->password
        ];
    }

}