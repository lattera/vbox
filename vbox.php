<?php
require_once("classes/vbox.php");

$vms = array(
    "debian x64" => array(
        "name" => "Debian x64",
        "vncport" => 5902,
    ),
    "win7 x64" => array(
        "name" => "Win7 x64",
        "vncport" => 5901,
    ),
);

foreach ($argv as $key => $value) {
    if ($key < 1)
        continue;

    switch ($value) {
        case "start":
            foreach ($vms as $name => $obj)
                vbox::start($obj);
            break;
        case "stop":
            foreach ($vms as $name => $obj)
                vbox::stop($obj);
            break;
        case "pause":
            foreach ($vms as $name => $obj)
                vbox::pause($obj);
            break;
        case "restart":
            foreach ($vms as $name => $obj)
                vbox::restart($obj);
            break;
        default:
            echo "Unknown action\n";
            break;
    }
}
