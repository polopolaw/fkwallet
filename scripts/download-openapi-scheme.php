#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Скрипт для скачивания OpenAPI схемы с fkwallet.io
 * 
 * Использование:
 *   php scripts/download-openapi-scheme.php
 */

const OPENAPI_URL = 'https://fkwallet.io/openapi-scheme-ru.json';
const SCHEMA_FILE = __DIR__ . '/../schemas/openapi-scheme-ru.json';

function downloadOpenApiScheme(): bool
{
    echo "Скачивание OpenAPI схемы...\n";
    
    // Проверяем, существует ли директория schemas
    $schemasDir = dirname(SCHEMA_FILE);
    if (!is_dir($schemasDir)) {
        if (!mkdir($schemasDir, 0755, true)) {
            echo "Ошибка: не удалось создать директорию {$schemasDir}\n";
            return false;
        }
        echo "Создана директория {$schemasDir}\n";
    }
    
    // Скачиваем файл
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => [
                'User-Agent: FKWallet-OpenAPI-Updater/1.0',
                'Accept: application/json',
            ],
            'timeout' => 30,
        ],
    ]);
    
    $content = @file_get_contents(OPENAPI_URL, false, $context);
    
    if ($content === false) {
        $error = error_get_last();
        echo "Ошибка при скачивании файла: " . ($error['message'] ?? 'Неизвестная ошибка') . "\n";
        return false;
    }
    
    // Проверяем, что это валидный JSON
    $decoded = json_decode($content, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "Ошибка: скачанный файл не является валидным JSON: " . json_last_error_msg() . "\n";
        return false;
    }
    
    // Форматируем JSON для читаемости (опционально)
    $formatted = json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    
    // Проверяем, изменился ли файл
    $hasChanges = true;
    if (file_exists(SCHEMA_FILE)) {
        $existingContent = file_get_contents(SCHEMA_FILE);
        if ($existingContent === $formatted) {
            echo "Файл не изменился, обновление не требуется.\n";
            $hasChanges = false;
        }
    }
    
    // Сохраняем файл
    if ($hasChanges) {
        if (file_put_contents(SCHEMA_FILE, $formatted) === false) {
            echo "Ошибка: не удалось сохранить файл в " . SCHEMA_FILE . "\n";
            return false;
        }
        echo "Файл успешно обновлен: " . SCHEMA_FILE . "\n";
        echo "Размер файла: " . number_format(strlen($formatted)) . " байт\n";
    }
    
    return $hasChanges;
}

function main(): int
{
    try {
        return (int) downloadOpenApiScheme();
    } catch (\Throwable $e) {
        echo "Критическая ошибка: " . $e->getMessage() . "\n";
        echo "Трассировка:\n" . $e->getTraceAsString() . "\n";
        return 0;
    }
}

exit(main());

