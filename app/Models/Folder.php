<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parent_id',
        'name',
        'slug',
    ];

    /**
     * @param string $slug
     * @return int|null
     */
    public function getIdBySlug(string $slug) : ?int
    {
        return self::where("slug", $slug)->first()?->id;
    }

    /**
     * @param int|null $parentId
     * @return array
     */
    public function breadcrumbs(int|null $parentId = null): array
    {
        $links = [];

        do {
            $prevCrumb = self::where("id", $parentId)->first();

            $links[] = [
                'name' => $prevCrumb->name,
                'slug' => $prevCrumb->slug,
            ];

            $parentId = $prevCrumb?->parent_id;
        }
        while(!is_null($parentId));

        return array_reverse($links);

    }
}
