<?php

interface LoggerInterface
{
    public function logMessage(string $text);

    public function lastMessages(int $number): array;

}

interface EventListenerInterface
{
    public function attachEvent($method, $function);

    public function detouchEvent($method);

}

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

abstract class View
{
    public $storage;

    public function __construct(Storage $object)
    {
        $this->storage = $object;
    }

    abstract protected function displayTextById($id);

    abstract protected function displayTextByUrl($url);

}

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
                break;
            case 'text':
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
echo $textOne->text;
