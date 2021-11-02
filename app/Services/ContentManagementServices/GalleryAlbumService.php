<?php


namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\GalleryAlbum;
use App\Services\Common\LanguageCodeService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Class GalleryAlbumService
 * @package App\Services\ContentManagementServices
 */
class GalleryAlbumService
{
    /**
     * @param array $request
     * @return Collection|LengthAwarePaginator|array
     */
    public function getAllGalleryAlbums(array $request): Collection|LengthAwarePaginator|array
    {
        $titleEn = $request['title_en'] ?? "";
        $titleBn = $request['title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Builder $GalleryAlbumBuilder */
        $GalleryAlbumBuilder = GalleryAlbum::select([
            'gallery_albums.id',
            'gallery_albums.parent_gallery_album_id',
            'gallery_albums.featured',
            'gallery_albums.show_in',
            'gallery_albums.album_type',
            'gallery_albums.published_at',
            'gallery_albums.archived_at',
            'gallery_albums.institute_id',
            'gallery_albums.organization_id',
            'gallery_albums.organization_association_id',
            'gallery_albums.program_id',
            'gallery_albums.batch_id',
            'gallery_albums.title',
            'gallery_albums.title_en',
            'gallery_albums.main_image_path',
            'gallery_albums.thumb_image_path',
            'gallery_albums.grid_image_path',
            'gallery_albums.image_alt_title',
            'gallery_albums.image_alt_title_en',
            'gallery_albums.row_status',
            'gallery_albums.created_by',
            'gallery_albums.updated_by',
            'gallery_albums.created_at',
            'gallery_albums.updated_at'
        ]);

        $GalleryAlbumBuilder->orderBy('gallery_albums.id', $order);

        if (is_numeric($rowStatus)) {
            $GalleryAlbumBuilder->where('gallery_albums.row_status', $rowStatus);
        }

        if (!empty($titleEn)) {
            $GalleryAlbumBuilder->where('gallery_albums.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($titleBn)) {
            $GalleryAlbumBuilder->where('gallery_albums.title', 'like', '%' . $titleBn . '%');
        }

        /** @var Collection $galleryCategories */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $galleryCategories = $GalleryAlbumBuilder->paginate($pageSize);
        } else {
            $galleryCategories = $GalleryAlbumBuilder->get();
        }

        return $galleryCategories;
    }


    public function getOneGalleryAlbum(int $id): Model|Builder|null
    {
        /** @var Builder $GalleryAlbumBuilder */
        $GalleryAlbumBuilder = GalleryAlbum::select([
            'gallery_albums.id',
            'gallery_albums.parent_gallery_album_id',
            'gallery_albums.featured',
            'gallery_albums.show_in',
            'gallery_albums.album_type',
            'gallery_albums.published_at',
            'gallery_albums.archived_at',
            'gallery_albums.institute_id',
            'gallery_albums.organization_id',
            'gallery_albums.organization_association_id',
            'gallery_albums.program_id',
            'gallery_albums.batch_id',
            'gallery_albums.title',
            'gallery_albums.title_en',
            'gallery_albums.main_image_path',
            'gallery_albums.thumb_image_path',
            'gallery_albums.grid_image_path',
            'gallery_albums.image_alt_title',
            'gallery_albums.image_alt_title_en',
            'gallery_albums.row_status',
            'gallery_albums.created_by',
            'gallery_albums.updated_by',
            'gallery_albums.created_at',
            'gallery_albums.updated_at'
        ]);
        $GalleryAlbumBuilder->where('gallery_albums.id', $id);

        /** @var GalleryAlbum $GalleryAlbum */
        return $GalleryAlbumBuilder->first();
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
                "max:1800",
                "min:2"
            ],
            'image_alt_title' => [
                "required",
                "nullable",
                "string",
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
            'parent_gallery_album_id' => [
                'nullable',
                'int',
                'exists:gallery_albums,deleted_at,NULL'
            ],
            'featured' => [
                'nullable',
                'int',
                Rule::in(BaseModel::FEATURED)
            ],
            'show_in' => [
                "required",
                "integer",
                Rule::in(BaseModel::SHOW_INS)
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
            'batch_id' => [
                'nullable',
                'int',
            ],
            'program_id' => [
                'nullable',
                'int',
            ],
            'published_at' => [
                'nullable',
                'date_format:Y-m-d|H:i'
            ],
            'archived_at' => [
                'nullable',
                'date'
            ],

            'title_en' => [
                'nullable',
                'string',
                'max:200',
                'min:2'
            ],
            'title' => [
                'required',
                'string',
                'max:600',
                'min:2'
            ],

            'main_image_path' => [
                'nullable',
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
            'image_alt_title_en' => [
                'nullable',
                'string',
                'max:250',
                'min:2'
            ],
            'image_alt_title' => [
                'nullable',
                'string',
                'max:600',
                'min:2'
            ],
            'other_language_fields' => [
                'nullable',
                'array',
                'min:1',

            ],
            'other_language_fields.*' => [
                "required"
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]
        ];
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
            'title_en' => 'nullable|max:191|min:2',
            'title' => 'nullable|min:500|min:2',
            'page' => 'numeric|gt:0',
            'page_size' => 'numeric|gt:0',
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
