<?php


namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\GalleryAlbum;
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
 * Class GalleryAlbumService
 * @package App\Services\ContentManagementServices
 */
class GalleryAlbumService
{
    /**
     * @param array $request
     * @param null $startTime
     * @return Collection|LengthAwarePaginator|array
     */
    public function getAllGalleryAlbums(array $request, $startTime = null): Collection|LengthAwarePaginator|array
    {
        $showIn = $request['show_in'] ?? "";
        $albumType = $request['album_type'] ?? "";
        $instituteId = $request['institute_id'] ?? "";
        $parentGalleryAlbumId = $request['parent_gallery_album_id'] ?? "";
        $onlyParentGalleryAlbum = $request['only_parent_gallery_album'] ?? "";
        $industryAssociationId = $request['industry_association_id'] ?? "";
        $organizationId = $request['organization_id'] ?? "";
        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $publishedAt = $request['published_at'] ?? "";
        $archivedAt = $request['archived_at'] ?? "";
        $isRequestFromClientSide = !empty($request[BaseModel::IS_CLIENT_SITE_RESPONSE_KEY]);

        /** @var Builder $galleryAlbumBuilder */
        $galleryAlbumBuilder = GalleryAlbum::select([
            'gallery_albums.id',
            'gallery_albums.parent_gallery_album_id',
            'gallery_albums.featured',
            'gallery_albums.show_in',
            'gallery_albums.album_type',
            'gallery_albums.published_at',
            'gallery_albums.archived_at',
            'gallery_albums.institute_id',
            'gallery_albums.organization_id',
            'gallery_albums.industry_association_id',
            'gallery_albums.program_id',
            'gallery_albums.course_id',
            'gallery_albums.title',
            'gallery_albums.main_image_path',
            'gallery_albums.thumb_image_path',
            'gallery_albums.grid_image_path',
            'gallery_albums.image_alt_title',
            'gallery_albums.row_status',
            'gallery_albums.created_by',
            'gallery_albums.updated_by',
            'gallery_albums.created_at',
            'gallery_albums.updated_at'

        ])->acl();

        $galleryAlbumBuilder->orderBy('gallery_albums.id', $order);

        if (is_numeric($showIn)) {
            $galleryAlbumBuilder->where('gallery_albums.show_in', $showIn);
        }
        if (is_numeric($rowStatus)) {
            $galleryAlbumBuilder->where('gallery_albums.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $galleryAlbumBuilder->where('gallery_albums.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $galleryAlbumBuilder->where('gallery_albums.title', 'like', '%' . $titleBn . '%');
        }
        if (is_numeric($instituteId)) {
            $galleryAlbumBuilder->where('gallery_albums.institute_id', $instituteId);
        }
        if (is_numeric($parentGalleryAlbumId)) {
            $galleryAlbumBuilder->where('gallery_albums.parent_gallery_album_id', $parentGalleryAlbumId);
        }
        if ($onlyParentGalleryAlbum == GalleryAlbum::ONLY_PARENT_GALLERY_ALBUM_TRUE) {
            $galleryAlbumBuilder->whereNull('gallery_albums.parent_gallery_album_id');
        }
        if (is_numeric($industryAssociationId)) {
            $galleryAlbumBuilder->where('gallery_albums.industry_association_id', $industryAssociationId);
        }
        if (is_numeric($organizationId)) {
            $galleryAlbumBuilder->where('gallery_albums.organization_id', $organizationId);
        }
        if (is_numeric($albumType)) {
            $galleryAlbumBuilder->where('gallery_albums.album_type', '=', $albumType);
        }

        if (!empty($publishedAt)) {
            $galleryAlbumBuilder->whereDate('gallery_albums.published_at', '=', $publishedAt);
        }
        if (!empty($archivedAt)) {
            $galleryAlbumBuilder->whereDate('gallery_albums.archived_at', '=', $archivedAt);
        }

        if ($isRequestFromClientSide) {
            $galleryAlbumBuilder->whereDate('gallery_albums.published_at', '<=', $startTime);
            $galleryAlbumBuilder->where(function ($builder) use ($startTime) {
                $builder->whereNull('gallery_albums.archived_at');
                $builder->orWhereDate('gallery_albums.archived_at', '>=', $startTime);
            });

            $galleryAlbumBuilder->active();
        }
        /** @var Collection $galleryAlbums */
        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $galleryAlbums = $galleryAlbumBuilder->paginate($pageSize);
        } else {
            $galleryAlbums = $galleryAlbumBuilder->get();
        }

        return $galleryAlbums;
    }


    /**
     * @param int $id
     * @return Model|Builder
     */
    public function getOneGalleryAlbum(int $id): Model|Builder
    {
        /** @var Builder $galleryAlbumBuilder */
        $galleryAlbumBuilder = GalleryAlbum::select([
            'gallery_albums.id',
            'gallery_albums.parent_gallery_album_id',
            'parent_gallery_albums.title as parent_gallery_album_title',
            'gallery_albums.featured',
            'gallery_albums.show_in',
            'gallery_albums.album_type',
            'gallery_albums.published_at',
            'gallery_albums.archived_at',
            'gallery_albums.institute_id',
            'gallery_albums.organization_id',
            'gallery_albums.industry_association_id',
            'gallery_albums.program_id',
            'gallery_albums.course_id',
            'gallery_albums.title',
            'gallery_albums.main_image_path',
            'gallery_albums.thumb_image_path',
            'gallery_albums.grid_image_path',
            'gallery_albums.image_alt_title',
            'gallery_albums.row_status',
            'gallery_albums.created_by',
            'gallery_albums.updated_by',
            'gallery_albums.created_at',
            'gallery_albums.updated_at'
        ]);
        $galleryAlbumBuilder->leftjoin('gallery_albums as parent_gallery_albums', function ($join) {
            $join->on('gallery_albums.parent_gallery_album_id', '=', 'parent_gallery_albums.id')
                ->whereNull('parent_gallery_albums.deleted_at');

        });

        $galleryAlbumBuilder->where('gallery_albums.id', $id);

        $galleryAlbumBuilder->with('galleryImagesVideos');
        $galleryAlbumBuilder->with('childGalleryAlbums');

        /** @var GalleryAlbum $GalleryAlbum */
        return $galleryAlbumBuilder->firstOrFail();
    }


    /**
     * @param array $data
     * @return GalleryAlbum
     */
    public function store(array $data): GalleryAlbum
    {
        $galleryCategory = new GalleryAlbum();
        $galleryCategory->fill($data);
        $galleryCategory->save();
        return $galleryCategory;
    }


    /**
     * @param GalleryAlbum $galleryCategory
     * @param array $data
     * @return GalleryAlbum
     */
    public function update(GalleryAlbum $galleryCategory, array $data): GalleryAlbum
    {
        $galleryCategory->fill($data);
        $galleryCategory->save();
        return $galleryCategory;
    }

    /**
     * @param GalleryAlbum $galleryCategory
     * @return bool
     */
    public function destroy(GalleryAlbum $galleryCategory): bool
    {
        return $galleryCategory->delete();
    }

    /**
     * @param array $data
     * @param GalleryAlbum $galleryAlbum
     * @return GalleryAlbum
     * @throws Throwable
     */
    public function publishOrArchiveGalleryAlbum(array $data, GalleryAlbum $galleryAlbum): GalleryAlbum
    {
        if ($data['status'] == BaseModel::STATUS_PUBLISH) {
            $galleryAlbum->published_at = Carbon::now()->format('Y-m-d H:i:s');
            $galleryAlbum->archived_at = null;

        }
        if ($data['status'] == BaseModel::STATUS_ARCHIVE) {
            $galleryAlbum->archived_at = Carbon::now()->format('Y-m-d H:i:s');
        }
        $galleryAlbum->saveOrFail();
        return $galleryAlbum;
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

    /**
     * @param array $request
     * @param string $languageCode
     * @return \Illuminate\Contracts\Validation\Validator
     */
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
            'image_alt_title' => [
                "nullable",
                "string",
                "max:500",
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
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];
        $rules = [
            'parent_gallery_album_id' => [
                'nullable',
                'int',
                'exists:gallery_albums,id,deleted_at,NULL'
            ],
            'featured' => [
                'required',
                'int',
                Rule::in(BaseModel::FEATURED)
            ],
            'show_in' => [
                "required",
                "integer",
                Rule::in(array_keys(BaseModel::SHOW_INS))
            ],
            'institute_id' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('show_in') == BaseModel::SHOW_IN_TSP;
                }),
                "nullable",
                "integer",
                "gt:0",
            ],
            'industry_association_id' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('show_in') == BaseModel::SHOW_IN_INDUSTRY_ASSOCIATION;
                }),
                "nullable",
                "integer",
                "gt:0",
            ],
            'organization_id' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->input('show_in') == BaseModel::SHOW_IN_INDUSTRY;
                }),
                "nullable",
                "integer",
                "gt:0",
            ],
            'album_type' => [
                'required',
                'integer',
                Rule::in(GalleryAlbum::GALLERY_ALBUM_TYPES)
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
            'course_id' => [
                'nullable',
                'int',
            ],
            'program_id' => [
                'nullable',
                'int',
            ],
            'title' => [
                'required',
                'string',
                'max:600',
                'min:2'
            ],
            'main_image_path' => [
                'required',
                'string',
            ],
            'thumb_image_path' => [
                'nullable',
                'string',
            ],
            'grid_image_path' => [
                'nullable',
                'string',
            ],
            'image_alt_title' => [
                'nullable',
                'string',
                'max:500',
                'min:2'
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

        $rules = [
            'title_en' => 'nullable|max:200|min:2',
            'only_parent_gallery_album' => [
                'nullable',
                Rule::in(GalleryAlbum::ONLY_PARENT_GALLERY_ALBUM)
            ],
            'parent_gallery_album_id' => [
                'nullable',
                'integer',
                'gt:0'
            ],
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
            'title' => 'nullable|max:600|min:2',
            'show_in' => 'nullable|integer |gt:0',
            'institute_id' => 'nullable|integer|gt:0',
            'industry_association_id' => 'nullable|integer|gt:0',
            'organization_id' => 'nullable|integer|gt:0',
            'page' => 'integer|gt:0',
            'page_size' => 'integer|gt:0',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "integer",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]
        ];
        return Validator::make($request->all(), $rules, $customMessage);
    }
}
