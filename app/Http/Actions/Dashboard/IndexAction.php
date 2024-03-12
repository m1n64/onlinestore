<?php

namespace App\Http\Actions\Dashboard;

use App\DTO\Dashboard\DashboardDTO;
use App\Models\File;
use App\Models\Folder;

class IndexAction
{
    /**
     * @param Folder $folders
     * @param File $files
     */
    public function __construct(
        protected Folder $folders,
        protected File   $files,
    )
    {}

    /**
     * @param int $userId
     * @param string|null $folderSlug
     * @return DashboardDTO
     */
    public function __invoke(int $userId, string|null $folderSlug): DashboardDTO
    {
        $parentId = null;
        $breadCrumbs = [];

        if (!is_null($folderSlug)) {
            $parentId = $this->folders->getIdBySlug($folderSlug);
            $breadCrumbs = $this->folders->breadcrumbs($parentId);
        }

        $folders = $this->folders->where("parent_id", $parentId)->where("user_id", $userId)->get();
        $files = $this->files->append(['full_image_path'])->where("folder_id", $parentId)->where("user_id", $userId)->get();

        return new DashboardDTO($folderSlug, $breadCrumbs, $folders, $files);
    }
}
