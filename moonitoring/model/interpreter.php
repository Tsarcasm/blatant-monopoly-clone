<?php
require_once "entity.php";

class Interpreter_Type extends Entity
{
    public $name;
    public $data_length;
    public $function;
    public $units;
}

class Sensor_Interpreter extends Entity
{
    public $machine_sensor_pk;
    public $interpreter_type_pk;
    public $name;
    public $description;

    public function getInterpreterType()
    {
        return Interpreter_Type::get($this->interpreter_type_pk);
    }

    public function applyFunction($segments)
    {
        // var_dump($segments);
        if ($segments == null) {
            return null;
        }
        $segdata = [];
        for ($i = 0; $i < count($segments); $i++) {
            $segdata[$i] = $segments[$i]->data;
        }
        // var_dump($segdata);
        $func = "interp_func_" . $this->getInterpreterType()->function;
        // var_dump($func($segdata));
        return $func($segdata);
    }

}

#define THERMISTORNOMINAL 10000
#define TEMPERATURENOMINAL 25
#define BCOEFFICIENT 3960

// interpreter functions go here
function interp_func_thermistor_air($segments)
{
    return thermistor_helper($segments, 10000.0, 10000.0, 3960);
    // if ($segments[0] == 0) {
    //     return $segments[0];
    // }

    // $resistance = 10000.0 * (4096.0 / doubleval($segments[0]) - 1.0);
    // $steinhart = 0.0;
    // $steinhart = $resistance / 10000; // (R/Ro)
    // $steinhart = log($steinhart); // ln(R/Ro)
    // $steinhart /= 3960; // 1/B * ln(R/Ro)
    // $steinhart += 1.0 / (25 + 273.15); // + (1/To)
    // $steinhart = 1.0 / $steinhart; // Invert
    // $steinhart -= 273.15; // convert absolute temp to C
    // return number_format($steinhart, 1);
}
function interp_func_thermistor_flow($segments)
{
    return thermistor_helper($segments, 50000.0, 10000.0, 3950.0, 0);
    // return thermistor_helper($segments, 50000.0, 10000.0, 3950.0, 0);
}

function interp_func_thermistor_amazon($segments)
{
    return thermistor_helper($segments, 10000.0, 10000.0, 3950.0);
    // return thermistor_helper($segments, 50000.0, 47000.0, 3950.0, -6000);
}
function interp_func_thermistor_amazon_50k($segments)
{
    return thermistor_helper($segments, 10000.0, 47000.0, 3950.0, -1000);
    // return thermistor_helper($segments, 50000.0, 47000.0, 3950.0, -6000);
}

function thermistor_helper($segments, $ro, $series_resistor, $constant, $r_offset = 0)
{
    if ($segments[0] == 0) {
        return $segments[0];
    }

    $resistance = $series_resistor * (4096.0 / doubleval($segments[0]) - 1.0);
    // $resistance = 63800.0;
    $resistance = $resistance + $r_offset;
    // return $resistance;
    $steinhart = 0.0;
    $steinhart = $resistance / $ro; // (R/Ro)
    $steinhart = log($steinhart); // ln(R/Ro)
    $steinhart /= $constant; // 1/B * ln(R/Ro)
    $steinhart += 1.0 / (25 + 273.15); // + (1/To)
    $steinhart = 1.0 / $steinhart; // Invert
    $steinhart -= 273.15; // convert absolute temp to C
    return number_format(round($steinhart * 5) / 5, 1);
    // return number_format($steinhart, 0);
}

function interp_func_stringify($segments)
{
    $str = "";

    foreach ($segments as $segment) {
        if ($segment >= 32 && $segment <= 126) {
            $str .= chr($segment);
        }
    }
    return $str;
}

function interp_func_flow($segments)
{
    // return $segments;
    if (count($segments) != 2) {
        return null;
    }
    if ($segments[1] == null) {
        $pulses = $segments[0];
    } else {
        $pulses = $segments[0] | ($segments[1] << 16);
    }
    // $pulses =  4976 | (10 << 16);
    // return $segments[0];
    // return $pulses;
    $litres = $pulses / 660.0; //(60.0 * 11.0);
    // return $litres;
    return number_format($litres, 2, '.', '');
}
