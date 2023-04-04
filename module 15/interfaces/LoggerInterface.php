<?php

interface LoggerInterface
{
    public function logMessage(string $text);

    public function lastMessages(int $number): array;

}