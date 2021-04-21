<?php

class Cache {

    public static function getVersion($key) {
        $version = 1;
        if (Doo::conf()->cache_enabled == TRUE) {
            $version = Doo::cache()->getIn("sn_cache", $key);

            if (!$version) {
                $version = 1;
                Doo::cache()->setIn("sn_cache", $key, $version);
            }
        }

        return $version;
    }

    public static function increase($key) {
        if (Doo::conf()->cache_enabled == TRUE) {
            $version = Doo::cache()->getIn("sn_cache", $key);

            if (!$version) {
                $version = 1;
                Doo::cache()->setIn("sn_cache", $key, $version);
            } else {
                $version++;
                Doo::cache()->setIn("sn_cache", $key, $version);
            }
        }
    }

    public static function delete($key) {
        if (Doo::conf()->cache_enabled == TRUE) {
            Doo::cache()->flushIn("sn_cache", $key);
        }
    }
}
?>