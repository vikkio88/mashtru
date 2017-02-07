<?php


namespace Mashtru\Libs\Models;


use DateTime;

class JobEntity extends Model
{
    const TIME_FORMAT = 'Y-m-d H:i:s';

    private function now()
    {
        return new DateTime();
    }

    private function nowF()
    {
        return $this->now()->format(self::TIME_FORMAT);
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
        $nextFireTime = $this->now()->add($job->delta_minutes):
        return $this->update(
            $job->id,
            ['fire_time' => $nextFireTime]
        );
    }
}