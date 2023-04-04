<?php

interface EventListenerInterface
{
    public function attachEvent($method, $function);

    public function detouchEvent($method);

}