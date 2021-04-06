<?php

require_once "helper.php";
require_once "../model/units.php";
require_once "../model/interpreter.php";

if (!isset($_GET["t"])) {
    error("Must provide token");
}
if (!isset($_GET["d"])) {
    error("Must provide data");
}
if (!isset($_GET["i"])) {
    error("Must provide segment index");
}

$token = Upload_Token::get($_GET["t"]);
if ($token == null) {
    error("Token is not valid");
}

$segment_string = $_GET["d"];
$segment_index = $_GET["i"];
$segments = array_filter(explode(';', $segment_string));
foreach ($segments as $segment_str) {
    $parts = explode(',', $segment_str);
    if (count($parts) != 2) {
        error("invalid data string, ".count($segments));
    }
    $machine_hid = hexdec($parts[0]);
    $segment_value = hexdec($parts[1]);

    // create a machine if one doesn't exist
    $machine = Machine::getWhere("h_id = ?", [$machine_hid]);
    if ($machine == null) {
        // we need to create a machine
        $machine = new Machine();
        $machine->farm_pk = $token->farm_pk;
        $machine->h_id = $machine_hid;
        $machine->name = "new machine";
        $machine->save();
    }

    $machine_segments = Machine_Segments::getWhere("machine_pk = ? AND upload_token_pk = ?", [$machine->pk, $token->pk]);
    if ($machine_segments == null) {
        // we need to create a new machine_segments row
        $machine_segments = new Machine_Segments();
        $machine_segments->machine_pk = $machine->pk;
        $machine_segments->upload_token_pk = $token->pk;
        $machine_segments->save();
    }

    $segment = new Data_Segment();
    $segment->machine_segments_pk = $machine_segments->pk;
    $segment->idx = $segment_index;
    $segment->data = $segment_value;
    $segment->save();
}
echo "success";