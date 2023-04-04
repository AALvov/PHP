<?php

abstract class Storage
{
    public function create(TelegraphText $text)
    {


    }

    public function read($slug): TelegraphText
    {

    }

    public function update($slug, TelegraphText $text)
    {

    }

    public function delete($slug)
    {

    }

    public function list(): array
    {

    }
}

abstract class View
{
    public $storage;

    public function __construct(Storage $object)
    {
        $this->storage = $object;
    }

    public function displayTextById($id)
    {

    }

    public function displayTextByUrl($url)
    {

    }
}

abstract class User
{
    public $id, $name, $role;

    public function getTextsToEdit()
    {

    }
}

class TelegraphText
{
    public $text, $title, $author, $published, $slug, $storage;

    public function __construct($name, $filename, $storage)
    {
        $this->author = $name;
        $this->slug = $filename;
        $this->published = date('Y-m-d');
        $this->storage = $storage;

    }

    public function storeText()
    {
//        var_dump($this->slug);
//        $newText['text'] = $this->text;
//        $newText['title'] = $this->title;
//        $newText['author'] = $this->author;
//        $newText['published'] = $this->published;
        $this->slug = $this->storage->create($this);
    }


    public function loadText()
    {
        if (file_exists($this->slug)) {
            $loadedText = $this->storage->read($this->slug);
            $this->title = $loadedText->title;
            $this->text = $loadedText->text;
            $this->author = $loadedText->author;
            $this->published = $loadedText->published;
            return $this->text;
        }
        return false;

    }

    public function editText($newTitle, $newText)
    {
        $this->title = $newTitle;
        $this->text = $newText;
    }
}

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

$storage = new FileStorage();
$textOne = new TelegraphText('Олег Рой', './storage/test', $storage);
$textOne->editText('Паутина Лжи', 'Для некоторых людей все существующие в жизни ценности сводятся к ценникам на витрине с брендами.');
$textOne->storeText();
echo $textOne->loadText();
