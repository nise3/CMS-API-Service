<?php


namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\Gallery;
use App\Services\Common\LanguageCodeService;
use Carbon\Carbon;
use Faker\Provider\Base;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class GalleryService
{
    /**
     * @param array $request
     * @return Collection|LengthAwarePaginator|array
     */
    public function getAllGalleries(array $request): Collection|LengthAwarePaginator|array
    {

        $contentTitle = $request['content_title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Builder $galleryBuilder */
        $galleryBuilder = Gallery::select([
            'galleries.id',
            'galleries.gallery_category_id',
            'gallery_categories.title_en as gallery_category_title_en',
            'gallery_categories.title as gallery_category_title',
            'galleries.content_title',
            'galleries.institute_id',
            'galleries.organization_id',
            'galleries.content_type',
            'galleries.content_path',
            'galleries.is_youtube_video',
            'galleries.you_tube_video_id',
            'galleries.content_properties',
            'galleries.alt_title_en',
            'galleries.alt_title',
            'galleries.publish_date',
            'galleries.archive_date',
            'galleries.row_status',
            'galleries.created_by',
            'galleries.updated_by',
            'galleries.created_at',
            'galleries.updated_at'
        ]);
        $galleryBuilder->join('gallery_categories', function ($join) use ($rowStatus) {
            $join->on('galleries.gallery_category_id', '=', 'gallery_categories.id')
                ->whereNull('gallery_categories.deleted_at');
            if (is_numeric($rowStatus)) {
                $join->where('gallery_categories.row_status', $rowStatus);
            }
        });
        $galleryBuilder->orderBy('galleries.id', $order);

        if (is_numeric($rowStatus)) {
            $galleryBuilder->where('galleries.row_status', $rowStatus);
        }
        if (!empty($contentTitle)) {
            $galleryBuilder->where('galleries.content_title', 'like', '%' . $contentTitle . '%');
        }

        /** @var Collection $galleries */
        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $galleries = $galleryBuilder->paginate($pageSize);
        } else {
            $galleries = $galleryBuilder->get();
        }
        return $galleries;

    }

    /**
     * @param int $id
     * @return Gallery
     */
    public function getOneGallery(int $id): Gallery
    {
        /** @var Builder $galleryBuilder */
        $galleryBuilder = Gallery::select([
            'galleries.id',
            'galleries.gallery_category_id',
            'gallery_categories.title_en as gallery_category_title_en',
            'gallery_categories.title as gallery_category_title',
            'galleries.content_title',
            'galleries.institute_id',
            'galleries.organization_id',
            'galleries.content_type',
            'galleries.content_path',
            'galleries.is_youtube_video',
            'galleries.you_tube_video_id',
            'galleries.content_properties',
            'galleries.alt_title_en',
            'galleries.alt_title',
            'galleries.publish_date',
            'galleries.archive_date',
            'galleries.row_status',
            'galleries.created_by',
            'galleries.updated_by',
            'galleries.created_at',
            'galleries.updated_at'

        ]);
        $galleryBuilder->join('gallery_categories', function ($join) {
            $join->on('galleries.gallery_category_id', '=', 'gallery_categories.id');

        });
        $galleryBuilder->where('galleries.id', $id);

        /** @var Gallery $gallery */
        $gallery = $galleryBuilder->firstOrFail();
        return $gallery;
    }

    /**
     * @param array $data
     * @return Gallery
     */
    public function store(array $data): Gallery
    {
        if (!empty($data['you_tube_video_id'])) {
            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $data['you_tube_video_id'], $matches);
            $data['content_path'] = $data['you_tube_video_id'];
            $data['you_tube_video_id'] = $matches[1];
        }

        $gallery = new Gallery();
        $gallery->fill($data);
        $gallery->save();
        return $gallery;
    }

    /**
     * @param Gallery $gallery
     * @param array $data
     * @return Gallery
     */
    public function update(Gallery $gallery, array $data): Gallery
    {
        if (!empty($data['you_tube_video_id'])) {
            preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $data['you_tube_video_id'], $matches);
            $data['content_path'] = $data['you_tube_video_id'];
            $data['you_tube_video_id'] = $matches[1];
        }
        $gallery->fill($data);
        $gallery->save();
        return $gallery;
    }

    /**
     * @param Gallery $gallery
     * @return bool
     */
    public function destroy(Gallery $gallery): bool
    {
        return $gallery->delete();
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
                'exists:gallery_categories,id'
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
                Rule::in([Gallery::CONTENT_TYPE_IMAGE, Gallery::CONTENT_TYPE_VIDEO])
            ],
            'is_youtube_video' => [
                'int',
                'required_if:content_type,' . Gallery::CONTENT_TYPE_VIDEO,
                Rule::in([Gallery::IS_YOUTUBE_VIDEO_YES, Gallery::IS_YOUTUBE_VIDEO_NO])
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
        if ($request->content_type == Gallery::CONTENT_TYPE_VIDEO && $request->is_youtube_video == Gallery::IS_YOUTUBE_VIDEO_YES) {
            $rules['you_tube_video_id'] = [
                'required_if:is_youtube_video,' . Gallery::IS_YOUTUBE_VIDEO_YES,
                'regex:/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/'
            ];
        } else {
            $rules['content_path'] = [
                'required_without:id',
                'string'
            ];

        }

        $rules=array_merge($rules,BaseModel::OTHER_LANGUAGE_VALIDATION_RULES);

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
