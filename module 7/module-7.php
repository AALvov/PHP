<?php

$searchRoot = 'C:/xampp/htdocs/welcome/test_search';
$searchName = 'test.txt';
$searchResult = [];

function search($root, $name, &$result)
{
    $dir = scandir($root);
    for ($i = 2; $i < count($dir); $i++) {
        if (is_dir($root . '/' . $dir[$i])) {
            $newRoot = $root . "/" . $dir[$i];
            search($newRoot, $name, $result);
        } else {
            if ($dir[$i] == $name) {
                $result[] = $root . "/" . $dir[$i];
            }
        }
    }
}


function isValidSize($roots)
{
    return filesize($roots) > 0;
}

search($searchRoot, $searchName, $searchResult);


$newResult = array_filter($searchResult, 'isValidSize');


if (empty($searchResult)) {
    echo "Поиск не дал результатов" . PHP_EOL;
} else {
    print_r($newResult);
}
