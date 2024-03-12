<?php

namespace App\Services\Stoarge\Adapters;

use Aws\S3\S3Client;

class S3Adapter
{
    /**
     * @param string $path
     * @param string $fileName
     * @param string $mimeType
     * @return string
     */
    public static function downloadUrl(string $path, string $fileName, string $mimeType): string
    {
        $client = new S3Client([
            'version' => 'latest',
            'region'  => getenv('AWS_DEFAULT_REGION'),
            'endpoint' => getenv('AWS_DOWNLOAD_URL'),
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key'    => getenv('MINIO_ACCESS_KEY'),
                'secret' => getenv('MINIO_SECRET_KEY'),
            ],
        ]);

        $command = $client->getCommand('GetObject', [
            'Bucket' => getenv('AWS_BUCKET'),
            'Key'    => $path,
            'ResponseContentDisposition' => 'attachment; filename="' . $fileName . '"',
            'ResponseContentType' => $mimeType,
        ]);

        $request = $client->createPresignedRequest($command, '+30 minutes');

        return (string) $request->getUri();
    }
}
