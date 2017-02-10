<?php


namespace Mashtru\Models;


use Carbon\Carbon;

class JobEntity extends Model
{
    const TIME_FORMAT = 'Y-m-d H:i:s';

    private function now()
    {
        return Carbon::now();
    }

    private function nowF()
    {
        return $this->now()->format(self::TIME_FORMAT);
    }

    public function create($data)
    {
        $data['fire_time'] = $this->now()
            ->addMinutes($data['delta_minutes'])
            ->format(self::TIME_FORMAT);
        return parent::create($data);
    }

    public function getNext()
    {
        $this->table()->where('active', true)
            ->where(
                'fire_time <=',
                $this->nowF()
            )->fetchAll();
    }

    public function getByName($name)
    {
        return $this->table()->where('name', $name)->fetch();
    }

    public function deleteByName($name)
    {
        return $this->table()->where('name', $name)->delete();
    }

    public function updateFireTime($job)
    {
        $nextFireTime = $this->now()->addMinutes($job->delta_minutes);
        return $this->update(
            $job->id,
            ['fire_time' => $nextFireTime->format(self::TIME_FORMAT)]
        );
    }

    public function uninstall()
    {
        $this->pdo->query('DROP TABLE IF EXISTS ' . $this->tableName);
    }

    public function install()
    {
        if (!$this->alreadyInstalled()) {
            $this->pdo->query(
                'CREATE TABLE ' . $this->tableName . '(
                id SMALLINT NOT NULL AUTO_INCREMENT,
                name VARCHAR(255),
                class_name VARCHAR(255) DEFAULT NULL ,
                args TEXT DEFAULT NULL ,
                delta_minutes INT DEFAULT NULL,
                active BOOL DEFAULT 1,
                fire_time TIMESTAMP NULL DEFAULT NULL,
                updated_at TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
                created_at TIMESTAMP NOT NULL,
                PRIMARY KEY(id),
                INDEX `name` (`name`)
            );
            '
            );
        }
    }

    private function alreadyInstalled()
    {
        try {
            $this->getOne(1);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}