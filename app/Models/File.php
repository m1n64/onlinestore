<?php

namespace App\Models;

use App\Classes\Constants\Messages;
use App\Services\Stoarge\Adapters\S3Adapter;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'folder_id',
        'name',
        'slug',
        'server_path',
        'mime_type',
        'size'
    ];

    protected $appends = ['full_file_path', 'download_link'];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param string $slug
     * @return int|null
     */
    public function getIdBySlug(string $slug): ?int
    {
        return self::whereSlug($slug)->first()?->id;
    }

    /**
     * @param string $slug
     * @return object|null
     */
    public function getFileBySlug(string $slug): ?object
    {
        return self::whereSlug($slug)->first();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isFileInSharing(int $id): bool
    {
        /*if (Cache::has(Messages::SHARING_FILES_NAME)) {
            $listOfFiles = Cache::get(Messages::SHARING_FILES_NAME);

            return in_array($id, $listOfFiles);
        }*/
        return Cache::has(Messages::SHARING_FILES_NAME . "--$id");
    }


    /**
     * @param int $id
     * @param bool $isSharing
     * @return void
     */
    public function setSharingStatus(int $id, bool $isSharing = true): void
    {
        $slug = self::find($id)?->slug;
        $cacheFileInd = Messages::SHARING_FILES_NAME . "--$id";
        $expired = now()->addRealHours(config('sharing.max_file_sharing_hours'));

        $isSharing ?
            Cache::put($cacheFileInd, ["file" => $slug, "expired"=> $expired], $expired) :
            Cache::delete($cacheFileInd);
    }
//    /**
//     * @param int $id
//     * @param bool $isSharing
//     * @return void
//     */
    /*public function setSharingStatus(int $id, bool $isSharing = true): void
    {
        if (Cache::has(Messages::SHARING_FILES_NAME)) {
            $listOfFiles = Cache::get(Messages::SHARING_FILES_NAME);

            if ($isSharing) {
                if (!in_array($id, $listOfFiles)) {
                    Cache::put(Messages::SHARING_FILES_NAME, [...$listOfFiles, $id]);
                }
            } else {
                $listOfFiles = array_filter($listOfFiles, static function ($element) use ($id) {
                    return $element === $id;
                });
                Cache::put(Messages::SHARING_FILES_NAME, [$listOfFiles]);
            }
        } else {
            Cache::put(Messages::SHARING_FILES_NAME, [$id]);
        }
    }*/

    /**
     * @return Attribute
     */
    protected function fullFilePath(): Attribute
    {
        return new Attribute(
            get: fn() => Storage::url($this->server_path)
        );
    }

    protected function downloadLink(): Attribute
    {
        return new Attribute(
            get: fn() => S3Adapter::downloadUrl($this->server_path, $this->name, $this->mime_type)
        );
    }
}
