<?php


namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\GalleryImageVideo;
use App\Services\Common\LanguageCodeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GalleryImageVideoService
{
    /**
     * @param array $request
     * @return Collection|LengthAwarePaginator|array
     */
    public function getGalleryImageVideoList(array $request): Collection|LengthAwarePaginator|array
    {


        $contentTitle = $request['content_title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var GalleryImageVideo|Builder $galleryImageVideoBuilder */
        $galleryImageVideoBuilder = GalleryImageVideo::select([
            'gallery_images_videos.id',
            'gallery_images_videos.gallery_album_id',
            'gallery_albums.title_en as gallery_album_title_en',
            'gallery_albums.title as gallery_album_title',
            'gallery_images_videos.featured',
            'gallery_images_videos.published_at',
            'gallery_images_videos.archived_at',
            'gallery_images_videos.institute_id',
            'gallery_images_videos.organization_id',
            'gallery_images_videos.industry_association_id',
            'gallery_images_videos.content_type',
            'gallery_images_videos.video_type',
            'gallery_images_videos.content_title',
            'gallery_images_videos.content_title_en',
            'gallery_images_videos.content_description',
            'gallery_images_videos.content_description_en',
            'gallery_images_videos.content_cover_image_url',
            'gallery_images_videos.content_grid_image_url',
            'gallery_images_videos.content_thumb_image_url',
            'gallery_images_videos.alt_title',
            'gallery_images_videos.alt_title_en',
            'gallery_images_videos.row_status',
            'gallery_images_videos.published_by',
            'gallery_images_videos.archived_by',
            'gallery_images_videos.created_by',
            'gallery_images_videos.updated_by',
            'gallery_images_videos.created_at',
            'gallery_images_videos.updated_at'
        ]);

        $galleryImageVideoBuilder->join('gallery_albums', function ($join) {
            $join->on('gallery_images_videos.gallery_album_id', '=', 'gallery_albums.id')
                ->whereNull('gallery_albums.deleted_at');
        });
        $galleryImageVideoBuilder->orderBy('gallery_images_videos.id', $order);

        if (is_numeric($rowStatus)) {
            $galleryImageVideoBuilder->where('gallery_images_videos.row_status', $rowStatus);
        }
        if (!empty($contentTitle)) {
            $galleryImageVideoBuilder->where('gallery_images_videos.content_title', 'like', '%' . $contentTitle . '%');
        }

        /** @var Collection $galleries */
        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;

            $galleries = $galleryImageVideoBuilder->paginate($pageSize);
        } else {
            $galleries = $galleryImageVideoBuilder->get();
        }

        return $galleries;

    }

    /**
     * @param int $id
     * @return GalleryImageVideo
     */
    public function getOneGalleryImageVideo(int $id): GalleryImageVideo
    {
        /** @var Builder $galleryImageVideoBuilder */
        $galleryImageVideoBuilder = GalleryImageVideo::select([
            'gallery_images_videos.id',
            'gallery_images_videos.gallery_category_id',
            'gallery_albums.title_en as gallery_category_title_en',
            'gallery_albums.title as gallery_category_title',
            'gallery_images_videos.content_title',
            'gallery_images_videos.institute_id',
            'gallery_images_videos.organization_id',
            'gallery_images_videos.content_type',
            'gallery_images_videos.content_path',
            'gallery_images_videos.is_youtube_video',
            'gallery_images_videos.you_tube_video_id',
            'gallery_images_videos.content_properties',
            'gallery_images_videos.alt_title_en',
            'gallery_images_videos.alt_title',
            'gallery_images_videos.publish_date',
            'gallery_images_videos.archive_date',
            'gallery_images_videos.row_status',
            'gallery_images_videos.created_by',
            'gallery_images_videos.updated_by',
            'gallery_images_videos.created_at',
            'gallery_images_videos.updated_at'

        ]);
        $galleryImageVideoBuilder->join('gallery_albums', function ($join) {
            $join->on('gallery_images_videos.gallery_category_id', '=', 'gallery_albums.id');

        });
        $galleryImageVideoBuilder->where('gallery_images_videos.id', $id);

        /** @var GalleryImageVideo $galleryImageVideo */
        $galleryImageVideo = $galleryImageVideoBuilder->firstOrFail();
        return $galleryImageVideo;
    }

    /**
     * @param array $data
     * @return GalleryImageVideo
     */
    public function store(array $data): GalleryImageVideo
    {
        if (!empty($data['you_tube_video_id'])) {
            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $data['you_tube_video_id'], $matches);
            $data['content_path'] = $data['you_tube_video_id'];
            $data['you_tube_video_id'] = $matches[1];
        }

        $galleryImageVideo = new GalleryImageVideo();
        $galleryImageVideo->fill($data);
        $galleryImageVideo->save();
        return $galleryImageVideo;
    }

    /**
     * @param GalleryImageVideo $galleryImageVideo
     * @param array $data
     * @return GalleryImageVideo
     */
    public function update(GalleryImageVideo $galleryImageVideo, array $data): GalleryImageVideo
    {
        if (!empty($data['you_tube_video_id'])) {
            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $data['you_tube_video_id'], $matches);
            $data['content_path'] = $data['you_tube_video_id'];
            $data['you_tube_video_id'] = $matches[1];
        }
        $galleryImageVideo->fill($data);
        $galleryImageVideo->save();
        return $galleryImageVideo;
    }

    /**
     * @param GalleryImageVideo $galleryImageVideo
     * @return bool
     */
    public function destroy(GalleryImageVideo $galleryImageVideo): bool
    {
        return $galleryImageVideo->delete();
    }

    public function languageFieldValidator(array $request, string $languageCode): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'required' => 'The :attribute_' . strtolower($languageCode) . ' in other language fields is required.[50000]',
            'max' => 'The :attribute_' . strtolower($languageCode) . ' in other language fields must not be greater than :max characters.[39003]',
            'min' => 'The :attribute_' . strtolower($languageCode) . ' in other language fields must be at least :min characters.[42003]',
            'language_code.in' => "The language with code " . $languageCode . " is not allowed",
            'language_code.regex' => "The language  code " . $languageCode . " must be lowercase"
        ];
        $request['language_code'] = $languageCode;
        $rules = [
            "language_code" => [
                "required",
                "regex:/[a-z]/",
                Rule::in(LanguageCodeService::getLanguageCode())
            ],
            'content_title' => [
                "required",
                "string",
                "max:1800",
                "min:2"
            ]
        ];
        return Validator::make($request, $rules, $customMessage);
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];
        $rules = [
            'gallery_category_id' => [
                'required',
                'int',
                'exists:gallery_albums,id'
            ],
            'content_title' => [
                'required',
                'string',
                'max:500',
                'min:2'
            ],
            'institute_id' => [
                'nullable',
                'int'
            ],
            'organization_id' => [
                'nullable',
                'int'
            ],
            'content_type' => [
                'required',
                'int',
                Rule::in([GalleryImageVideo::CONTENT_TYPE_IMAGE, GalleryImageVideo::CONTENT_TYPE_VIDEO])
            ],
            'is_youtube_video' => [
                'int',
                'required_if:content_type,' . GalleryImageVideo::CONTENT_TYPE_VIDEO,
                Rule::in([GalleryImageVideo::IS_YOUTUBE_VIDEO_YES, GalleryImageVideo::IS_YOUTUBE_VIDEO_NO])
            ],
            'content_properties' => [
                'nullable',
                'string'
            ],
            'alt_title_en' => [
                'nullable',
                'string'
            ],
            'alt_title' => [
                'nullable',
                'string'
            ],
            'publish_date' => [
                'nullable',
                'date',
                'before:archive_date'
            ],
            'archive_date' => [
                'nullable',
                'date',
                'after:publish_date'
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]
        ];
        if ($request->content_type == GalleryImageVideo::CONTENT_TYPE_VIDEO && $request->is_youtube_video == GalleryImageVideo::IS_YOUTUBE_VIDEO_YES) {
            $rules['you_tube_video_id'] = [
                'required_if:is_youtube_video,' . GalleryImageVideo::IS_YOUTUBE_VIDEO_YES,
                'regex:/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/'
            ];
        } else {
            $rules['content_path'] = [
                'required_without:id',
                'string'
            ];

        }

        $rules = array_merge($rules, BaseModel::OTHER_LANGUAGE_VALIDATION_RULES);

        return Validator::make($request->all(), $rules, $customMessage);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'order.in' => [
                'code' => 30000,
                "message" => 'Order must be within ASC or DESC',
            ],
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];

        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }

        return Validator::make($request->all(), [
            'page' => 'numeric|gt:0',
            'content_title' => 'nullable|max:500|min:2',
            'pageSize' => 'numeric|gt:0',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "numeric",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }
}
