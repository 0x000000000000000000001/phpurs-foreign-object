<?php

$unsafeIndex = function($m, $k) use (&$unsafeIndex) {
    return $m->$k;
};

$exports['unsafeIndex'] = $unsafeIndex;
return $exports;
