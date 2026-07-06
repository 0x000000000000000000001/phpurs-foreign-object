<?php

$new = function() use (&$new) {
    return new \stdClass();
};

$peekImpl = function($just, $nothing = null, $k = null, $m = null) use (&$peekImpl) {
    if (func_num_args() < 4) {
        $__args = func_get_args();
        return function(...$more) use ($__args, &$new) {

            return $peekImpl(...array_merge($__args, $more));
        };
    }
    return function() use ($just, $nothing, $k, $m) {
        return property_exists($m, $k) ? $just($m->$k) : $nothing;
    };
};

$poke = function($k, $v = null, $m = null) use (&$poke) {
    if (func_num_args() < 3) {
        $__args = func_get_args();
        return function(...$more) use ($__args, &$peekImpl) {

            return $poke(...array_merge($__args, $more));
        };
    }
    return function() use ($k, $v, $m) {
        $m->$k = $v;
        return $m;
    };
};

$delete = function($k, $m = null) use (&$delete) {
    if (func_num_args() < 2) {
        $__args = func_get_args();
        return function(...$more) use ($__args, &$poke) {

            return $delete(...array_merge($__args, $more));
        };
    }
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
