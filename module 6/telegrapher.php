<?php

$textStorage = [];

function add(array &$storage, string $title, string $text): void
{
    $storage[] = [
        'title' => $title,
        'text' => $text
    ];

}

function remove(int $number, array &$storage): bool
{
    if (array_key_exists($number, $storage)) {
        unset($storage[$number]);
        return true;
    }
    return false;


}

function edit(int $number, string $title, string $text, &$storage): bool
{
    if (array_key_exists($number, $storage)) {
        $storage[$number]['title'] = $title;
        $storage[$number]['text'] = $text;

        return true;
    }

    return false;

}

add($textStorage, 'Мигрант, или Brevi Finietur', 'Дело не в страхе, — сказал себе Крокодил. — Дело в том, ради чего его преодолеваешь. Я преодолел страх смерти, потому что есть вещи важнее, чем моя жизнь. Аира преодолел страх ошибки, потому что есть вещи ценнее, чем его правота.');
add($textStorage, 'Отверженные', 'Я не пойму вас, но я буду вас слушать. Когда слышишь любимые голоса, нет нужды понимать слова.');
print_r($textStorage);

var_dump(remove(0, $textStorage));
var_dump(remove(5, $textStorage));
print_r($textStorage);
var_dump(edit(1, 'В.Гюго Отвереженные', 'Я не пойму вас, но я буду вас слушать. Когда слышишь любимые голоса, нет нужды понимать слова.', $textStorage));
var_dump(edit(5, 'dawdawdaw', 'Я не пойму вас, но я буду вас слушать. Когда слышишь любимые голоса, нет нужды понимать слова.', $textStorage));

print_r($textStorage);
