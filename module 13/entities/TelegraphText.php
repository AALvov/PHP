<?php

class TelegraphText
{
    private $text, $title, $author, $published, $slug;
    public $storage;

    public function __construct($name, $filename, $storage)
    {
        $this->author = $name;
        $this->slug = $filename;
        $this->published = date('Y-m-d');
        $this->storage = $storage;

    }

    private function storeText()
    {
        $this->slug = $this->storage->create($this);
    }


    private function loadText()
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

    public function __set($name, $value)
    {
        switch ($name) {
            case 'author':
                if (strlen($value) > 120) {
                    echo "Длина строки не может быть больше 120 символов!" . PHP_EOL;
                    return;
                }
                $this->author = $value;
                break;
            case 'slug':
                if (!preg_match("#^[aA-zZ0-9\-_]+$#", $value)) {
                    echo "Недопустимые символы в названии файла!" . PHP_EOL;
                    return;
                }
                $this->slug = $value;
                break;
            case 'published':
                if (date('Y-m-d') > $value) {
                    echo 'Дата меньше сегодняшней!';
                    return;
                }
                $this->published = $value;
            case 'store':
                return $this->storeText();
        }
    }

    public function __get($name)
    {
        switch ($name) {
            case 'text':
                return $this->loadText();
            default:
                return $this->$name;

        }

    }
}