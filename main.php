<?php


$var = parallel\run(function () {
    $coroResult = [];
    go(function () use (&$coroResult) {
        sleep(1);
        $coroResult[] = 1;
    });

    return $coroResult;
})->value();

var_dump($var);