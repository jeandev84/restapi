<?php

// https://phpspreadsheet.readthedocs.io/en/latest/
// https://ae-nekrasov.ru/development/sozdanie-excel-v-php/
// set_include_path(__DIR__);
require __DIR__.'/../vendor/autoload.php';

$obj = new Excphp();

/*
 * Simple generate doc
*/
$obj->genDoc();


/*
 * Complex generate doc
*/

$arrToWrite = array(
    1 => array(
        "NAME" => "Монтаж металлоконструкций",
        "PRICE" => 100,
        "QUANTITY" => 5,
        "UNIT" => "шт."
    ),
    2 => array(
        "NAME" => "Вывоз мусора",
        "PRICE" => 1000,
        "QUANTITY" => 2,
        "UNIT" => "шт."
    ),
    3 => array(
        "NAME" => "Монтаж кабеля",
        "PRICE" => 120,
        "QUANTITY" => 100,
        "UNIT" => "м.п."
    ),
    4 => array(
        "NAME" => "Монтаж опор освещения",
        "PRICE" => 2500,
        "QUANTITY" => 10,
        "UNIT" => "шт."
    ),
    5 => array(
        "NAME" => "Благоустройство территории",
        "PRICE" => 5500,
        "QUANTITY" => 100,
        "UNIT" => "м2."
    ),
    6 => array(
        "NAME" => "Проектирование",
        "PRICE" => 6000,
        "QUANTITY" => 1,
        "UNIT" => "копмл."
    ),
    7 => array(
        "NAME" => "Щебень фракция 5-20",
        "PRICE" => 5000,
        "QUANTITY" => 10,
        "UNIT" => "м3."
    ),
    8 => array(
        "NAME" => "Цемент",
        "PRICE" => 1000,
        "QUANTITY" => 10,
        "UNIT" => "уп."
    ),
    9 => array(
        "NAME" => "Алебастр",
        "PRICE" => 300,
        "QUANTITY" => 5,
        "UNIT" => "уп."
    ),
);


$obj = new Excphp();

$obj->genDoc($arrToWrite);