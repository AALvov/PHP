<?php

require_once './interfaces/LoggerInterface.php';
require_once './interfaces/EventListenerInterface.php';

abstract class Storage implements LoggerInterface, EventListenerInterface
{
    abstract protected function create(TelegraphText $text);

    abstract protected function read($slug): TelegraphText;

    abstract protected function update($slug, TelegraphText $text);

    abstract protected function delete($slug);

    abstract protected function list(): array;

    public function logMessage(string $text)
    {
// TODO: Implement logMessage() method.
    }

    public function lastMessages(int $number): array
    {
// TODO: Implement lastMessages() method.
    }

    public function attachEvent($method, $function)
    {
// TODO: Implement attachEvent() method.
    }

    public function detouchEvent($method)
    {
// TODO: Implement detouchEvent() method.
    }
}