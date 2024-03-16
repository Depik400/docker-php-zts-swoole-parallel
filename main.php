<?php
$coroResult = [];
go(function () use (&$coroResult) {

    $future = parallel\run(function () {
        $result = 0;
        foreach (range(0, 10000000) as $key => $item) {
            $result += $item;
            if ($key % 1000 === 0) {
                $result /= 1000;
            }
        }
        return $result;
    });
    go(function () use ($future, &$coroResult) {
        while (!$future->done()) {
            usleep(1000);
        }
        $coroResult[0] = $future->value();
    });
    go(function () use (&$coroResult) {
        foreach (range(0, 500) as $item) {
            $coroResult[] = $item;
            usleep(1000);
        }
    });
});

var_dump($coroResult);