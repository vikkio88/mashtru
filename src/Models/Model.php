<?php


namespace Mashtru\Models;


use DateTime;
use LessQL\Database;
use PDO;
use PDOException;

abstract class Model
{
    const DUPLICATE_ERROR_CODE = 1062;
    protected $tableName;
    protected $db;
    protected $pdo;
    private $config;

    public function __construct(array $config, $table)
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
        $this->tableName = $table;
    }

    protected function table()
    {
        return $this->db->table($this->tableName);
    }

    public function getOne($id)
    {
        return $this->table()
            ->where('id', $id)
            ->fetch();
    }

    public function getAll()
    {
        return $this->table()->fetchAll();
    }

    public function create($data)
    {
        $data = array_merge(
            $data,
            ['created_at' => (new DateTime())->format('Y-m-d H:i:s')]
        );

        $row = $this->db->createRow(
            $this->tableName,
            $data
        );
        try {
            $this->db->begin();
            $row->save();
            return $this->db->commit();
        } catch (PDOException $e) {
            $this->db->rollback();
            if ($e->errorInfo[1] == Model::DUPLICATE_ERROR_CODE) {
                return false;
            }
            throw $e;
        }
    }

    public function update($id, $data)
    {
        return $this->table()
            ->where('id', $id)
            ->update($data);
    }

    public function delete($id)
    {
        return $this->table()
            ->where('id', $id)
            ->delete();
    }

    public function truncate()
    {
        $this->pdo->exec(sprintf('TRUNCATE TABLE %s', $this->tableName));
    }

}