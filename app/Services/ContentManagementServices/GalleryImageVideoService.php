<?php


namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\GalleryImageVideo;
use App\Services\Common\LanguageCodeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
            'gallery_images_videos.image_url',
            'gallery_images_videos.video_url',
            'gallery_images_videos.content_properties_json',
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
     * @return Model|Builder
     */
    public function getOneGalleryImageVideo(int $id): Builder|Model
    {
        /** @var Builder $galleryImageVideoBuilder */
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
            'gallery_images_videos.image_url',
            'gallery_images_videos.video_url',
            'gallery_images_videos.content_properties_json',
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

        $galleryImageVideoBuilder->where('gallery_images_videos.id', $id);

        /** @var GalleryImageVideo $galleryImageVideo */
        return $galleryImageVideoBuilder->firstOrFail();
    }

    /**
     * @param array $data
     * @return GalleryImageVideo
     */
    public function store(array $data): GalleryImageVideo
    {
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
                "max:600",
                "min:2"
            ],
            'content_description' => [
                "nullable",
                "string"
            ],
            'alt_title' => [
                "nullable",
                "string",
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
            'gallery_album_id' => [
                'required',
                'int',
                'exists:gallery_albums,id'
            ],
            'featured' => [
                'required',
                'int',
                Rule::in(BaseModel::FEATURED)
            ],
            'institute_id' => [
                'nullable',
                'int'
            ],
            'organization_id' => [
                'nullable',
                'int'
            ],
            'industry_association_id' => [
                'nullable',
                'int'
            ],
            'content_type' => [
                'required',
                'int',
                Rule::in(GalleryImageVideo::CONTENT_TYPES)
            ],
            'video_type' => [
                'int',
                'required_if:content_type,' . GalleryImageVideo::CONTENT_TYPE_VIDEO,
                Rule::in(GalleryImageVideo::VIDEO_TYPES)
            ],
            'content_title' => [
                'required',
                'string',
                'max:600',
                'min:2'
            ],
            'content_title_en' => [
                'nullable',
                'string',
                'max:250',
                'min:2'
            ],
            'content_description' => [
                'nullable',
                'string'
            ],
            'content_description_en' => [
                'nullable',
                'string'
            ],
            'content_properties_json' => [
                'nullable',
                'array'
            ],
            'image_url' => [
                'nullable',
                'required_if:content_type,' . GalleryImageVideo::CONTENT_TYPE_IMAGE
            ],
            'video_url' => [
                'nullable',
                'required_if:content_type,' . GalleryImageVideo::CONTENT_TYPE_VIDEO
            ],
            'content_properties_json.*' => [
                'nullable',
                'string'
            ],
            'content_cover_image_url' => [
                'nullable',
                'string'
            ],
            'content_grid_image_url' => [
                'nullable',
                'string'
            ],
            'content_thumb_image_url' => [
                'nullable',
                'string'
            ],
            'alt_title' => [
                'nullable',
                'string'
            ],
            'alt_title_en' => [
                'nullable',
                'string'
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]
        ];
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
            'content_title' => 'nullable|max:500|min:2',
            'page_size' => 'nullable|integer|gt:0',
            'page' => 'nullable|integer|gt:0',
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
