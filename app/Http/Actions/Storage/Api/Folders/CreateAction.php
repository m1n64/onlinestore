<?php

namespace App\Http\Actions\Storage\Api\Folders;

use App\Models\Folder;
use Illuminate\Support\Str;

class CreateAction
{
    /**
     * @param Folder $folders
     */
    public function __construct(
        protected Folder $folders,
    )
    {
    }

    /**
     * @param string $name
     * @param string|null $folderSlug
     * @param int $userId
     * @return Folder
     */
    public function __invoke(string $name, string|null $folderSlug, int $userId): Folder
    {
        $parentId = null;
        if (!is_null($folderSlug)) {
            $parentId = $this->folders->getIdBySlug($folderSlug);
        }

        return $this->folders::create([
            "user_id" => $userId,
            "name" => $name,
            "parent_id" => $parentId,
            "slug" => Str::random(10),
        ]);
    }
}
