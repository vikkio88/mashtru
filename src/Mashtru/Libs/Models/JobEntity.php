<?php


namespace Mashtru\Libs\Models;


use DateTime;

class JobEntity extends Model
{
    const TIME_FORMAT = 'Y-m-d H:i:s';


    public function getNext()
    {
        $now = new DateTime();
        $this->table()->where('active', true)
            ->where(
                'fire_time <=',
                $now->format(self::TIME_FORMAT)
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
}