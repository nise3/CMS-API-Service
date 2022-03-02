<?php


namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\GalleryAlbum;
use App\Models\GalleryImageVideo;
use App\Services\Common\LanguageCodeService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

/**
 *
 */
class GalleryImageVideoService
{
    /**
     * @param array $request
     * @param null $startTime
     * @return Collection|LengthAwarePaginator|array
     */
    public function getGalleryImageVideoList(array $request, $startTime = null): Collection|LengthAwarePaginator|array
    {
        $publishedAt = $request['published_at'] ?? "";
        $archivedAt = $request['archived_at'] ?? "";
        $searchText = $request['search_text'] ?? "";
        $albumType = $request['album_type'] ?? "";
        $instituteId = $request['institute_id'] ?? "";
        $industryAssociationId = $request['industry_association_id'] ?? "";
        $organizationId = $request['organization_id'] ?? "";
        $galleryAlbumId = $request['gallery_album_id'] ?? "";
        $title = $request['title'] ?? "";
        $titleEn = $request['title_en'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $isRequestFromClientSide = !empty($request[BaseModel::IS_CLIENT_SITE_RESPONSE_KEY]);

        /** @var GalleryImageVideo|Builder $galleryImageVideoBuilder */
        $galleryImageVideoBuilder = GalleryImageVideo::select([
            'gallery_images_videos.id',
            'gallery_images_videos.gallery_album_id',
            'gallery_albums.title_en as gallery_album_title_en',
            'gallery_albums.title as gallery_album_title',
            'gallery_images_videos.featured',
            'gallery_images_videos.published_at',
            'gallery_images_videos.archived_at',
            'gallery_albums.institute_id',
            'gallery_albums.organization_id',
            'gallery_albums.industry_association_id',
            'gallery_images_videos.content_type',
            'gallery_images_videos.video_type',
            'gallery_images_videos.title',
            'gallery_images_videos.title_en',
            'gallery_images_videos.description',
            'gallery_images_videos.description_en',
            'gallery_images_videos.image_path',
            'gallery_images_videos.video_url',
            'gallery_images_videos.video_id',
            'gallery_images_videos.content_properties_json',
            'gallery_images_videos.content_grid_image_path',
            'gallery_images_videos.content_thumb_image_path',
            'gallery_images_videos.image_alt_title',
            'gallery_images_videos.image_alt_title_en',
            'gallery_images_videos.row_status',
            'gallery_images_videos.published_by',
            'gallery_images_videos.archived_by',
            'gallery_images_videos.created_by',
            'gallery_images_videos.updated_by',
            'gallery_images_videos.created_at',
            'gallery_images_videos.updated_at'

        ])->acl();

        $galleryImageVideoBuilder->join('gallery_albums', function ($join) {
            $join->on('gallery_images_videos.gallery_album_id', '=', 'gallery_albums.id')
                ->whereNull('gallery_albums.deleted_at');
        });

        $galleryImageVideoBuilder->orderBy('gallery_images_videos.id', $order);

        if (is_numeric($rowStatus)) {
            $galleryImageVideoBuilder->where('gallery_images_videos.row_status', $rowStatus);
        }
        if (is_numeric($instituteId)) {
            $galleryImageVideoBuilder->where('gallery_albums.institute_id', $instituteId);
        }
        if (is_numeric($galleryAlbumId)) {
            $galleryImageVideoBuilder->where('gallery_images_videos.gallery_album_id', $galleryAlbumId);
        }
        if (is_numeric($industryAssociationId)) {
            $galleryImageVideoBuilder->where('gallery_albums.industry_association_id', $industryAssociationId);
        }
        if (is_numeric($organizationId)) {
            $galleryImageVideoBuilder->where('gallery_albums.organization_id', $organizationId);
        }

        if (!empty($publishedAt)) {
            $galleryImageVideoBuilder->whereDate('gallery_images_videos.published_at', '=', $publishedAt);
        }
        if (!empty($archivedAt)) {
            $galleryImageVideoBuilder->whereDate('gallery_images_videos.archived_at', '=', $archivedAt);
        }

        if (!empty($title)) {
            $galleryImageVideoBuilder->where('gallery_images_videos.title', 'like', '%' . $title . '%');
        }
        if (!empty($titleEn)) {
            $galleryImageVideoBuilder->where('gallery_images_videos.title_en', 'like', '%' . $titleEn . '%');
        }

        if ($isRequestFromClientSide) {
            $galleryImageVideoBuilder->whereDate('gallery_images_videos.published_at', '<=', $startTime);
            $galleryImageVideoBuilder->where(function ($builder) use ($startTime) {
                $builder->whereNull('gallery_images_videos.archived_at');
                $builder->orWhereDate('gallery_images_videos.archived_at', '>=', $startTime);
            });

            $galleryImageVideoBuilder->active();
        }
        if (is_numeric($albumType)) {
            $galleryImageVideoBuilder->where('gallery_albums.album_type', '=', $albumType);
        }

        if (!empty($searchText)) {
            $galleryImageVideoBuilder->where(function ($builder) use ($searchText) {
                $builder->orWhere('gallery_images_videos.title', 'like', '%' . $searchText . '%');
                $builder->orWhere('gallery_images_videos.title_en', 'like', '%' . $searchText . '%');
                $builder->orWhere('gallery_images_videos.description', 'like', '%' . $searchText . '%');
                $builder->orWhere('gallery_images_videos.description_en', 'like', '%' . $searchText . '%');
            });
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
            'gallery_albums.institute_id',
            'gallery_albums.organization_id',
            'gallery_albums.industry_association_id',
            'gallery_images_videos.content_type',
            'gallery_images_videos.video_type',
            'gallery_images_videos.title',
            'gallery_images_videos.title_en',
            'gallery_images_videos.description',
            'gallery_images_videos.description_en',
            'gallery_images_videos.image_path',
            'gallery_images_videos.video_url',
            'gallery_images_videos.video_id',
            'gallery_images_videos.content_properties_json',
            'gallery_images_videos.content_grid_image_path',
            'gallery_images_videos.content_thumb_image_path',
            'gallery_images_videos.image_alt_title',
            'gallery_images_videos.image_alt_title_en',
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


    /**
     * @param array $data
     * @param GalleryImageVideo $galleryImageVideo
     * @return GalleryImageVideo
     * @throws Throwable
     */
    public function publishOrArchiveGalleryImageVideo(array $data, GalleryImageVideo $galleryImageVideo): GalleryImageVideo
    {
        if ($data['status'] == BaseModel::STATUS_PUBLISH) {
            $galleryImageVideo->published_at = Carbon::now()->format('Y-m-d H:i:s');
            $galleryImageVideo->archived_at = null;
        }
        if ($data['status'] == BaseModel::STATUS_ARCHIVE) {
            $galleryImageVideo->archived_at = Carbon::now()->format('Y-m-d H:i:s');
        }
        $galleryImageVideo->saveOrFail();
        return $galleryImageVideo;
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function publishOrArchiveValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'status' => [
                'integer',
                Rule::in(BaseModel::PUBLISH_OR_ARCHIVE_STATUSES)
            ]

        ];
        return Validator::make($request->all(), $rules);
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
            'title' => [
                "required",
                "string",
                "max:600",
                "min:2"
            ],
            'description' => [
                "nullable",
                "string"
            ],
            'image_alt_title' => [
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
        $requestData = $request->all();
        $customMessage = [
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
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
            'title' => [
                'required',
                'string',
                'max:600',
                'min:2'
            ],
            'published_at' => [
                'nullable',
                'date',
            ],
            'archived_at' => [
                'nullable',
                'date',
                'after:published_at'
            ],
            'description' => [
                'nullable',
                'string'
            ],
            'content_properties_json' => [
                'nullable',
                'array'
            ],
            'image_path' => [
                'nullable',
                'required_if:content_type,' . GalleryImageVideo::CONTENT_TYPE_IMAGE
            ],
            'content_grid_image_path' => [
                'nullable',
                'string'
            ],
            'content_thumb_image_path' => [
                'nullable',
                'string'
            ],
            'image_alt_title' => [
                'nullable',
                'string'
            ],
            'image_alt_title_en' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]
        ];
        if (!empty($requestData['content_type']) && $requestData['content_type'] == GalleryImageVideo::CONTENT_TYPE_VIDEO && !empty($requestData['video_type'])) {
            $rules['video_url'] = [
                'required',
                'string',
                'max:800'
            ];
            $rules['video_id'] = [
                'required',
                'max:300'
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
            'order.in' => 'Order must be within ASC or DESC.[30000]',
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];

        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }

        return Validator::make($request->all(), [
            'institute_id' => 'nullable|integer|gt:0',
            'industry_association_id' => 'nullable|integer|gt:0',
            'gallery_album_id' => 'nullable|integer|gt:0',
            'organization_id' => 'nullable|integer|gt:0',
            'title' => 'nullable|max:500|min:2',
            'title_en' => 'nullable|max:250|min:2',
            'page_size' => 'nullable|integer|gt:0',
            'page' => 'nullable|integer|gt:0',
            'published_at' => [
                'nullable',
                'date'
            ],
            'archived_at' => [
                'nullable',
                'date'
            ],
            'album_type' => [
                'nullable',
                'integer',
                Rule::in(GalleryAlbum::GALLERY_ALBUM_TYPES)
            ],
            'search_text' => [
                'nullable',
                'string'
            ],
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
