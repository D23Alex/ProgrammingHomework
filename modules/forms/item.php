<?php
namespace Forms;
class Item extends \Forms\Form {
    protected const FIELDS = [
        'price' => ['type' => 'float'],
        'category' => ['type' => 'string'],
        'title' => ['type' => 'string'],
        'description' => ['type' => 'string', 'optional' => TRUE],
        'amount' => ['type' => 'float', 'optional' => TRUE],
        'measure' => ['type' => 'string', 'optional' => TRUE],
        'price_per_one' => ['type' => 'float', 'optional' => TRUE],
        'uploaded' => ['type' => 'timestamp', 'optional' => TRUE],
    ];

    protected static function after_prepare_data(&$data, &$norm_data)
    {
        //TODO: разобраться с нулевым временем

    }
}