<?php
class vbox {
    public static function start($vm) {
        if (vbox::isOnline($vm))
            return true;

        $args = "";

        if ($vm["vncport"] > 0)
            $args .= " -n -m " . $vm["vncport"];

        system("nohup VBoxHeadless -s '" . $vm["name"] . "'" . $args . " > /dev/null 2>&1 &");

        return true;
    }

    public static function stop($vm) {
        if (!vbox::isOnline($vm))
            return true;

        /* Windows needs the power button pressed multiple times for it to register */
        $count = 1;
        if ($vm["type"] == "windows")
            $count = 3;

        for ($i = 0; $i < $count; $i++) {
            system("VBoxManage controlvm '" . $vm["name"] . "' acpipowerbutton > /dev/null 2>&1");
            sleep(10);
        }

        return true;
    }

    public static function pause($vm) {
        if (!vbox::isOnline($vm))
            return true;

        system("VBoxManage controlvm '" . $vm["name"] . "' savestate");

        return true;
    }

    public static function restart($vm) {
        if (vbox::stop($vm) == false)
            return false;

        return vbox::start($vm);
    }

    public static function zsnap($vm) {
        $online = vbox::isOnline($vm);

        if (!array_key_exists("dataset", $vm))
            return true;

        if ($online)
            if (vbox::pause($vm) == false)
                return false;

        $timestamp = strftime("%F_%T");

        system("sudo zfs snapshot '" . $vm["dataset"] . "@" . $timestamp . "'");

        if ($online)
            return vbox::start($vm);

        return true;
    }

    public static function isOnline($vm) {
        $fp = popen("VBoxManage list runningvms", "r");

        while ($line = trim(fgets($fp))) {
            $name = substr($line, 1, strpos($line, "\"", 1)-1);
            if ($name == $vm["name"]) {
                pclose($fp);
                return true;
            }
        }

        pclose($fp);
        return false;
    }
}
