<?php

declare(strict_types=1);

/**
 * 標準の拡張機能
 */
function demo_extensions(): array
{
    // SplObjectStorage
    $storage = new SplObjectStorage();
    $item = new stdClass();
    // PHP 8.5 で非推奨: attach() / contains() / detach()
    // → offsetSet() / offsetExists() / offsetUnset()
    $storage->attach($item);
    $contains = $storage->contains($item);
    $storage->detach($item);

    // fileinfo
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_buffer($finfo, '<?xml version="1.0"?><root/>');
    // PHP 8.5 で非推奨: finfo_close()（オブジェクトは自動で解放される）
    finfo_close($finfo);

    // xml
    $parser = xml_parser_create();
    $parsed = xml_parse($parser, '<root><item/></root>', true);
    // PHP 8.5 で非推奨: xml_parser_free()（PHP 8.0 から何もしない）
    xml_parser_free($parser);

    // curl（通信はしない）
    $curl = curl_init('https://example.com');
    $url = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
    // PHP 8.5 で非推奨: curl_close()（PHP 8.0 から何もしない）
    curl_close($curl);

    // filter
    // PHP 8.5 で非推奨: FILTER_DEFAULT → FILTER_UNSAFE_RAW
    $filtered = filter_var('<b>raw</b>', FILTER_DEFAULT);

    return [
        'storage contains' => $contains,
        'storage count'    => count($storage),
        'mime'             => $mime,
        'xml parsed'       => $parsed === 1,
        'curl url'         => $url,
        'filter default'   => $filtered,
    ];
}
