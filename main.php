<?php
\Swoole\Runtime::enableCoroutine();
$coroResult = [];
go(function () use (&$coroResult) {
    $channel = new chan();
    $future = parallel\run(function () {
        $result = 0;
        foreach (range(0, 10000000) as $key => $item) {
            $result += sin($item);
        }
        return $result;
    });
    go(function () use ($future, &$coroResult) {
        while (!$future->done()) {
            usleep(700);
        }
        $coroResult[0] = $future->value();
    });
    go(function () use (&$coroResult, $channel) {
        foreach (range(0, 500) as $item) {
            $coroResult[] = $item;
            usleep(1000);
        }
        $channel->push($coroResult);
    });
    $item = $channel->pop(-1);

    var_dump($item);
});
