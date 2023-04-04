<?php

require_once './entities/Storage.php';

class FileStorage extends Storage
{
    public function create(TelegraphText $text)
    {
        $i = 1;
        $text->slug = $text->slug . '_' . $text->published;
        if (file_exists($text->slug . '.txt')) {
            $text->slug = $text->slug . '_' . $i;
        }
        while (file_exists($text->slug . '.txt')) {
            $i++;
            $text->slug[strlen($text->slug) - 1] = $i;
        }
        $text->slug = $text->slug . '.txt';
        file_put_contents($text->slug, serialize($text));
        return $text->slug;
    }

    public function read($slug): TelegraphText
    {
        if (file_exists($slug)) {
            $loadedText = unserialize(file_get_contents($slug));

            return $loadedText;
        }
    }

    public function update($slug, TelegraphText $text)
    {
        if (file_exists($slug)) {
            file_put_contents($slug, serialize($text));
        }
    }

    public function delete($slug)
    {
        if (file_exists($slug)) {
            unlink($slug);
        }
    }

    public function list(): array
    {
        $list = scandir('./storage');
        for ($i = 2; $i < count($list) - 1; $i++) {
            $objectList[] = unserialize(file_get_contents('./storage/' . $list[$i]));
        }
        return $objectList;
    }
}