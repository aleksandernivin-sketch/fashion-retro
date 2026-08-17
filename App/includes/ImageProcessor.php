<?php

declare(strict_types=1);

/**
 * app/includes/ImageProcessor.php
 * 
 * Набор функций для ресайза, конвертации и очистки изображений.
 * Использует Imagick для поддержки AVIF, WebP и JPG.
 */

/**
 * Обрабатывает изображение: изменяет размер и сохраняет в трех форматах.
 */
function processImageSize(string $sourcePath, string $outputDir, string $baseName, int $width): array
{
    $results = [];
    $formats = ['avif', 'webp', 'jpg'];
    
    try {
        foreach ($formats as $ext) {
            $imagick = new Imagick($sourcePath);
            
            // Получаем текущие размеры
            $originalWidth = $imagick->getImageWidth();
            $originalHeight = $imagick->getImageHeight();
            
            // Рассчитываем высоту с сохранением пропорций
            $height = (int)round(($originalHeight * $width) / $originalWidth);
            
            // Ресайз
            $imagick->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1);
            
            // Настройка формата и качества
            $imagick->setImageFormat($ext);
            if ($ext === 'jpg') {
                $imagick->setImageCompressionQuality(85);
            } else {
                $imagick->setImageCompressionQuality(80);
            }
            
            $targetFile = "{$outputDir}/{$baseName}-{$width}w.{$ext}";
            $imagick->writeImage($targetFile);
            $results[] = $targetFile;
            
            $imagick->clear();
            $imagick->destroy();
        }
    } catch (Exception $e) {
        error_log("Error processing size {$width}w for {$sourcePath}: " . $e->getMessage());
    }
    
    return $results;
}

/**
 * Удаляет устаревшие ассеты (650w, 700w).
 */
function removeLegacyAssets(string $directory, string $baseName): array
{
    $removed = [];
    $legacySuffixes = ['650w', '700w'];
    $extensions = ['avif', 'webp', 'jpg'];
    
    foreach ($legacySuffixes as $suffix) {
        foreach ($extensions as $ext) {
            $file = "{$directory}/{$baseName}-{$suffix}.{$ext}";
            if (file_exists($file)) {
                if (unlink($file)) {
                    $removed[] = $file;
                }
            }
        }
    }
    
    return $removed;
}
