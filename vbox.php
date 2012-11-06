#!/usr/bin/env php
<?php
require_once("classes/vbox.php");

$vms = array();
$actions = array();
$selected_vms = array();

for ($i = 1; $i < count($argv); $i++) {
    $arg=explode("=", $argv[$i]);
    if (count($arg) < 2) {
        echo "[-] Bad argument formatting. Expected <arg>=<value>. Given: " . $argv[$i] . "\n";
        exit(1);
    }

    switch ($arg[0]) {
        case "db":
            require_once($arg[1]);
            break;
        case "vm":
            $selected_vms[$arg[1]] = $arg[1];
            break;
        case "action":
            $actions[] = $arg[1];
            break;
        default:
            echo "[-] Unknown argument: " . $arg[0] . "\n";
            exit(1);
    }
}

foreach ($actions as $action) {
    switch ($action) {
        case "start":
            foreach ($vms as $name => $obj)
                if (!count($selected_vms) || array_key_exists($obj["name"], $selected_vms))
                    vbox::start($obj);
            break;
        case "stop":
            foreach ($vms as $name => $obj)
                if (!count($selected_vms) || array_key_exists($obj["name"], $selected_vms))
                    vbox::stop($obj);
            break;
        case "pause":
            foreach ($vms as $name => $obj)
                if (!count($selected_vms) || array_key_exists($obj["name"], $selected_vms))
                    vbox::pause($obj);
            break;
        case "zsnap":
            foreach ($vms as $name => $obj)
                if (!count($selected_vms) || array_key_exists($obj["name"], $selected_vms))
                    vbox::zsnap($obj);
            break;
        case "restart":
            foreach ($vms as $name => $obj)
                if (!count($selected_vms) || array_key_exists($obj["name"], $selected_vms))
                    vbox::restart($obj);
            break;
    }
}
