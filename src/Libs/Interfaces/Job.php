<?php


namespace Mashtru\Libs\Interfaces;


interface Job
{
    public function fire(array $parameters = []);
}