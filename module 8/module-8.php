<?php

class TelegraphText
{
    public $text, $title, $author, $published, $slug;

    public function __construct($name, $filename)
    {
        $this->author = $name;
        $this->slug = $filename;
        $this->published = date('Y-m-d H:i:s');
    }

    public function storeText()
    {
        $newText['text'] = $this->text;
        $newText['title'] = $this->title;
        $newText['author'] = $this->author;
        $newText['published'] = $this->published;
        if (file_exists($this->slug)) {
            file_put_contents($this->slug, serialize($newText));
        } else {
            return false;
        }
    }

    public function loadText()
    {
        if (file_exists($this->slug)) {
            $loadedText = unserialize(file_get_contents($this->slug));
            $this->title = $loadedText['title'];
            $this->text = $loadedText['text'];
            $this->author = $loadedText['author'];
            $this->published = $loadedText['published'];
            return $this->text;
        } else {
            return false;
        }
    }

    public function editText($newTitle, $newText)
    {
        $this->title = $newTitle;
        $this->text = $newText;
    }
}

$textOne = new TelegraphText('Олег Рой', 'test.txt');
$textOne->editText('Паутина Лжи', 'Для некоторых людей все существующие в жизни ценности сводятся к ценникам на витрине с брендами.');
$textOne->storeText();

var_dump($textOne->loadText());
