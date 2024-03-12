<?php

namespace App\Http\Actions\Storage\Api\Files;

use App\Classes\Helpers\SizesHelper;
use App\Http\Requests\Storage\Api\Files\CreateRequest;
use App\Models\File as FileModel;
use App\Models\Folder;
use App\Traits\JsonResponseTrait;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CreateAction
{
    use JsonResponseTrait;

    /**
     * @param FileModel $files
     * @param Snowflake $snowflake
     * @param Folder $folders
     */
    public function __construct(
        protected FileModel     $files,
        protected Snowflake $snowflake,
        protected Folder    $folders,
    )
    {
    }

    /**
     * @param CreateRequest $request
     * @return Response|Application|ResponseFactory
     */
    public function __invoke(CreateRequest $request): Response|Application|ResponseFactory
    {
        $userSize = $request->user()->files_size;
        $userMaxFilesSize = $request->user()->max_files_size;
        $userId = $request->user()->id;

        $files = [];

        foreach ($request->file("files") as $file) {
            $fileSizeInMb = SizesHelper::convertBytesToMb($file->getSize());

            if ($userMaxFilesSize > -1) {
                if (($userSize + $fileSizeInMb) >= $userMaxFilesSize) {
                    return $this->error(
                        message: "File {$file->getClientOriginalName()} don't uploaded. You don't have free space.",
                        data: [
                            "files" => $files,
                            "userSize" => $userSize,
                        ]
                    );
                }
            }

            $userFolder = "{$userId}{$request->user()->unique_folder_id}";
            $uploadFolder = "$userFolder";
            $fileName = $this->snowflake->id();

            Storage::putFileAs($uploadFolder, $file, $fileName);

            $files[] = $this->files::create([
                'user_id' => $userId,
                'folder_id' => $this->folders->getIdBySlug($request->folderSlug),
                'name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => SizesHelper::convertBytesToMb($file->getSize()),
                'slug' => $fileName,
                'server_path' => "$userFolder/$fileName"
            ]);

            $userSize += $fileSizeInMb;
            $userSize = round($userSize, 2);

            $request->user()->setFilesSize($userSize);
        }

        return $this->success(data: [
            "files" => $files,
            "userSize" => $userSize,
        ]);
    }
}
