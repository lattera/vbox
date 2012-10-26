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

foreach ($vms as $key => $value) {
    vbox::pause($value);
}
