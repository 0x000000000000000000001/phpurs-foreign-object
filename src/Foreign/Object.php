<?php

$_copyST = function($m) use (&$_copyST) {
    return function() use ($m) {
        $r = new \stdClass();
        foreach ($m as $k => $v) {
            $r->$k = $v;
        }
        return $r;
    };
};

$empty = new \stdClass();

$runST = function($f) use (&$runST) {
    return $f();
};

$_fmapObject = function($m0, $f = null) use (&$_fmapObject) {
    if (func_num_args() < 2) {
        $__args = func_get_args();
        return function(...$more) use ($__args, &$_copyST) {

            return $_fmapObject(...array_merge($__args, $more));
        };
    }
    $m = new \stdClass();
    foreach ($m0 as $k => $v) {
        $m->$k = $f($v);
    }
    return $m;
};

$_mapWithKey = function($m0, $f = null) use (&$_mapWithKey) {
    if (func_num_args() < 2) {
        $__args = func_get_args();
        return function(...$more) use ($__args, &$runST) {

            return $_mapWithKey(...array_merge($__args, $more));
        };
    }
    $m = new \stdClass();
    foreach ($m0 as $k => $v) {
        $m->$k = $f($k)($v);
    }
    return $m;
};

$_foldM = function($bind) use (&$_foldM) {
    return function($f) use ($bind) {
        return function($mz) use ($bind, $f) {
            return function($m) use ($bind, $f, $mz) {
                $acc = $mz;
                foreach ($m as $k => $v) {
                    $g = function($z) use ($f, $k, $v) {
                        return $f($z)($k)($v);
                    };
                    $acc = $bind($acc)($g);
                }
                return $acc;
            };
        };
    };
};

$_foldSCObject = function($m, $z = null, $f = null, $fromMaybe = null) use (&$_foldSCObject) {
    if (func_num_args() < 4) {
        $__args = func_get_args();
        return function(...$more) use ($__args, &$_fmapObject) {

            return $_foldSCObject(...array_merge($__args, $more));
        };
    }
    $acc = $z;
    foreach ($m as $k => $v) {
        $maybeR = $f($acc)($k)($v);
        $r = $fromMaybe(null)($maybeR);
        if ($r === null) return $acc;
        else $acc = $r;
    }
    return $acc;
};

$all = function($f, $m = null) use (&$all) {
    if (func_num_args() < 2) {
        $__args = func_get_args();
        return function(...$more) use ($__args, &$_mapWithKey) {

            return $all(...array_merge($__args, $more));
        };
    }
    foreach ($m as $k => $v) {
        if (!$f($k)($v)) return false;
    }
    return true;
};

$size = function($m) use (&$size) {
    $s = 0;
    foreach ($m as $k => $v) {
        $s++;
    }
    return $s;
};

$_lookup = function($no, $yes = null, $k = null, $m = null) use (&$_lookup) {
    if (func_num_args() < 4) {
        $__args = func_get_args();
        return function(...$more) use ($__args, &$_foldM) {

            return $_lookup(...array_merge($__args, $more));
        };
    }
    return property_exists($m, $k) ? $yes($m->$k) : $no;
};

$_lookupST = function($no, $yes = null, $k = null, $m = null) use (&$_lookupST) {
    if (func_num_args() < 4) {
        $__args = func_get_args();
        return function(...$more) use ($__args, &$_foldSCObject) {

            return $_lookupST(...array_merge($__args, $more));
        };
    }
    return function() use ($no, $yes, $k, $m) {
        return property_exists($m, $k) ? $yes($m->$k) : $no;
    };
};

$toArrayWithKey = function($f, $m = null) use (&$toArrayWithKey) {
    if (func_num_args() < 2) {
        $__args = func_get_args();
        return function(...$more) use ($__args, &$all) {

            return $toArrayWithKey(...array_merge($__args, $more));
        };
    }
    $r = [];
    foreach ($m as $k => $v) {
        $r[] = $f($k)($v);
    }
    return $r;
};

$keys = function($m) use (&$keys) {
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
