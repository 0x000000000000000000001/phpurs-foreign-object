<?php

$unsafeFreeze = function($m) use (&$unsafeFreeze) {
    return function() use ($m) {
        return $m;
    };
};

$exports['unsafeFreeze'] = $unsafeFreeze;
return $exports;
