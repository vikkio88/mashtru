<?php


namespace Mashtru\Libs\Interfaces;


interface Job
{
    /**
     * @param array $parameters
     * @return int
     */
    public function fire(array $parameters = []);

    /**
     * @return array
     */
    public function toArray();
}