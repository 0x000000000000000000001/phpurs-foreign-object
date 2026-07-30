<?php

$new = function() {
    return new \stdClass();
};

$peekImpl = function($just, $nothing, $k, $m) use (&$peekImpl) {
    return function() use ($just, $nothing, $k, $m) {
        return property_exists($m, $k) ? $just($m->$k) : $nothing;
    };
};

$poke = function($k, $v, $m) use (&$poke) {
    return function() use ($k, $v, $m) {
        $m->$k = $v;
        return $m;
    };
};

$delete = function($k, $m) use (&$delete) {
    return function() use ($k, $m) {
        unset($m->$k);
        return $m;
    };
};

$exports['new'] = $new;
$exports['peekImpl'] = $peekImpl;
$exports['poke'] = $poke;
$exports['delete'] = $delete;
return $exports;
