<?php

$unsafeFreeze = function($m) {
    return function() use ($m) {
        return $m;
    };
};

$exports['unsafeFreeze'] = $unsafeFreeze;
return $exports;
