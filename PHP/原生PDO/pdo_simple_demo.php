<?php
$pdo = new \PDO('mysql:host=pc-3ns8fh64m7c7j5552.rwlb.rds.aliyuncs.com;dbname=test_pro', 'test_pro', 'test_pro@dasjdhjRdasd');
for ($i = 1; $i < 10; $i++) {
    $start = time();
    echo '开始时间戳: ', $start, PHP_EOL;
    $sql = "select * from bop_order where out_trade_no = ':out_trade_no' and transaction_id = ':transaction_id' ";

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':out_trade_no'   => '1120200822225312754861',
        ':transaction_id' => '1120200822225312754861',
    ]);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($res);
    $end = time();
    echo '结束时间戳: ', $end, PHP_EOL;
    echo '花时间: ', $end - $start, PHP_EOL;
}
