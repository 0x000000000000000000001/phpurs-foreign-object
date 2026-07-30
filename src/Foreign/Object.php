<?php

$_copyST = function($m) {
    return function() use ($m) {
        $r = new \stdClass();
        foreach ($m as $k => $v) {
            $r->$k = $v;
        }
        return $r;
    };
};

$empty = new \stdClass();

$runST = function($f) {
    return $f();
};

$_fmapObject = function($m0, $f) use (&$_fmapObject) {
    $m = new \stdClass();
    foreach ($m0 as $k => $v) {
        $m->$k = $f($v);
    }
    return $m;
};

$_mapWithKey = function($m0, $f) use (&$_mapWithKey) {
    $m = new \stdClass();
    foreach ($m0 as $k => $v) {
        $m->$k = $f($k)($v);
    }
    return $m;
};

$_foldM = function($bind, $f, $mz, $m) use (&$_foldM) {
    $acc = $mz;
    foreach ($m as $k => $v) {
        $g = function($z) use ($f, $k, $v) {
            return $f($z)($k)($v);
        };
        $acc = $bind($acc)($g);
    }
    return $acc;
};

$_foldSCObject = function($m, $z, $f, $fromMaybe) use (&$_foldSCObject) {
    $acc = $z;
    foreach ($m as $k => $v) {
        $maybeR = $f($acc)($k)($v);
        $r = $fromMaybe(null)($maybeR);
        if ($r === null) return $acc;
        else $acc = $r;
    }
    return $acc;
};

$all = function($f, $m) use (&$all) {
    foreach ($m as $k => $v) {
        if (!$f($k)($v)) return false;
    }
    return true;
};

$size = function($m) {
    $s = 0;
    foreach ($m as $k => $v) {
        $s++;
    }
    return $s;
};

$_lookup = function($no, $yes, $k, $m) use (&$_lookup) {
    return property_exists($m, $k) ? $yes($m->$k) : $no;
};

$_lookupST = function($no, $yes, $k, $m) use (&$_lookupST) {
    return function() use ($no, $yes, $k, $m) {
        return property_exists($m, $k) ? $yes($m->$k) : $no;
    };
};

$toArrayWithKey = function($f, $m) use (&$toArrayWithKey) {
    $r = [];
    foreach ($m as $k => $v) {
        $r[] = $f($k)($v);
    }
    return $r;
};

$keys = function($m) {
    $r = [];
    foreach ($m as $k => $v) {
        $r[] = (string)$k;
    }
    return $r;
};

$exports['_copyST'] = $_copyST;
$exports['empty'] = $empty;
$exports['runST'] = $runST;
$exports['_fmapObject'] = $_fmapObject;
$exports['_mapWithKey'] = $_mapWithKey;
$exports['_foldM'] = $_foldM;
$exports['_foldSCObject'] = $_foldSCObject;
$exports['all'] = $all;
$exports['size'] = $size;
$exports['_lookup'] = $_lookup;
$exports['_lookupST'] = $_lookupST;
$exports['toArrayWithKey'] = $toArrayWithKey;
$exports['keys'] = $keys;
return $exports;
