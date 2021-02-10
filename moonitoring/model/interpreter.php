<?php
require_once "entity.php";

class Interpreter_Type extends Entity
{
    public $name;
    public $data_length;
    public $function;
    public $units;
}

class Interpreter extends Entity
{
    public $machine_source_pk;
    public $interpreter_type_pk;
    public $name;
    public $description;
}

