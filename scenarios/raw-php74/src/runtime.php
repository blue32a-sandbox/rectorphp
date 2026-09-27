<?php

declare(strict_types=1);

/**
 * リソースと例外
 */
function demo_runtime(): array
{
    // curl（通信はしない）
    $curl = curl_init('https://example.com');
    $closed = false;
    // PHP 8.0 から: curl_init() はリソースではなく CurlHandle オブジェクトを返す
    if (is_resource($curl)) {
        curl_close($curl);
        $closed = true;
    }

    try {
        new DateTimeImmutable('not a date');
        $parsed = true;
    } catch (Exception $e) {
        $parsed = false;
    }

    // PHP 8.0 で非推奨: libxml_disable_entity_loader()（外部エンティティは既定で読み込まない）
    libxml_disable_entity_loader(true);
    $xml = simplexml_load_string('<user><name>alice</name></user>');

    return [
        'curl closed' => $closed,
        'parsed'      => $parsed,
        'xml name'    => (string) $xml->name,
    ];
}
