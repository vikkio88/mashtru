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

    public function insert($table, $data)
    {
        $data = array_merge(
            $data,
            ['created_at' => (new DateTime())->format('Y-m-d H:i:s')]
        );

        $row = $this->db->createRow(
            $table,
            $data
        );

        $this->db->begin();
        $row->save();
        return $this->db->commit();

    }

    public function update($table, $rowName, $value, $data)
    {

    }

    public function delete($table, $rowName, $value)
    {
        return $this->db->table($table)
            ->where($rowName, $value)
            ->delete();
    }
}