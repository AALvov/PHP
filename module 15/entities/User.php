<?php

require_once './interfaces/EventListenerInterface.php';

abstract class User implements EventListenerInterface
{
    protected $id, $name, $role;

    abstract protected function getTextsToEdit();

    public function attachEvent($method, $function)
    {
        // TODO: Implement attachEvent() method.
    }

    public function detouchEvent($method)
    {
        // TODO: Implement detouchEvent() method.
    }

}