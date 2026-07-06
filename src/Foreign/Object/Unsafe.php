<?php

$unsafeIndex = function($m, $k = null) use (&$unsafeIndex) {
    if (func_num_args() < 2) {
        $__args = func_get_args();
        return function(...$more) use ($__args, &$unsafeIndex) {

            return $unsafeIndex(...array_merge($__args, $more));
        };
    }
    return $m->$k;
};

$exports['unsafeIndex'] = $unsafeIndex;
return $exports;
