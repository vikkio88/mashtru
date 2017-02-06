<?php


namespace Libs\Helpers;


use DateTime;
use LessQL\Database;
use PDO;

class DbHelper
{
    protected $db;
    protected $pdo;
    private $config;

    public function __construct($config = [])
    {
        $this->config = $config;
        $this->pdo = new PDO(
            sprintf(
                'mysql:host=%s;dbname=%s',
                $this->config['host'],
                $this->config['db']
            ),
            $this->config['user'],
            $this->config['password']
        );
        $this->db = new Database($this->pdo);

    }

    public function table($tableName)
    {
        return $this->db->table($tableName);
    }
}