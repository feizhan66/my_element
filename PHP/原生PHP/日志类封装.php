<?php

Class Log{

    /**
 * 以json格式记录调试日志到文件（可以指定日志文件名和存放目录）
 *
 * @param array $content
 * @param string $fileName
 * @param string $dir
 * @param bool $isDivide 开关，是否按照小时分割日志文件
 */
public static function save(array $content, $fileName = 'dbg', $dir = 'dbg', bool $isDivide = true)
{
    if (empty($fileName)) {
        $fileName = 'dbg';
    }
    if (empty($dir)) {
        $dir = 'dbg';
    }

    $logDir = rtrim(__DIR__ . '/logs/' . $dir, '/\\');
    $logFilePfx = $logDir . '/' . $fileName . '_' . date('Ymd');
    $logFile = $logFilePfx . ($isDivide ? '_' . date('H') : '') . '.log';
    if (!file_exists($logDir)) {
        mkdir($logDir, 0755, true);
    }

    $str = json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $record = '[' . date('Y-m-d H:i:s') . ']' . PHP_EOL . $str . PHP_EOL . PHP_EOL;
    file_put_contents($logFile, $record, FILE_APPEND);
}
}











