<?php

namespace App\DTO\Dashboard;

use App\Interfaces\DTOToArrayInterface;
use Illuminate\Database\Eloquent\Collection;

class DashboardDTO implements DTOToArrayInterface
{
    /**
     * @param string|null $folderSlug
     * @param array $foldersBreadcrumbs
     * @param array|Collection $folders
     * @param array|Collection $files
     */
    public function __construct(
        public string|null $folderSlug,
        public array $foldersBreadcrumbs,
        public array|Collection $folders,
        public array|Collection $files,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'folderSlug' => $this->folderSlug,
            'foldersBreadcrumbs' => $this->foldersBreadcrumbs,
            'folders' => $this->folders,
            'files' => $this->files,
        ];
    }
}
