<?php

namespace App\Services\ContentManagementServices;

use App\Models\BaseModel;
use App\Models\Publication;
use App\Services\Common\LanguageCodeService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Class PublicationService
 * @package App\Services
 */
class PublicationService
{

    /***
     * @param array $request
     * @param null $startTime
     * @return array
     */
    public function getPublicationList(array $request, $startTime = null): array
    {
        $title = $request['title'] ?? "";
        $titleEn = $request['title_en'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $author = $request['author'] ?? "";
        $authorEn = $request['author_en'] ?? "";
        $order = $request['order'] ?? "ASC";
        $rowStatus = $request['row_status'] ?? "";
        $instituteId = $request['institute_id'] ?? "";
        $organizationId = $request['organization_id'] ?? "";
        $industryAssociationId = $request['industry_association_id'] ?? "";
        $showIn = $request['show_in'] ?? "";
        $publishedAt = $request['published_at'] ?? "";
        $archivedAt = $request['archived_at'] ?? "";
        $isRequestFromClientSide = !empty($request[BaseModel::IS_CLIENT_SITE_RESPONSE_KEY]);


        /** @var Builder $publicationBuilder */
        $publicationBuilder = Publication::select(
            [
                'publications.id',
                'publications.show_in',
                'publications.institute_id',
                'publications.organization_id',
                'publications.industry_association_id',
                'publications.published_at',
                'publications.archived_at',
                'publications.title',
                'publications.title_en',
                'publications.author',
                'publications.author_en',
                'publications.description',
                'publications.description_en',
                'publications.industry_association_id',
                'publications.image_path',
                'publications.created_by',
                'publications.updated_by',
                'publications.created_at',
                'publications.updated_at',
                'publications.row_status'

            ]);

        /** If private API */
        if (!$isRequestFromClientSide) {
            $publicationBuilder->acl();
        }

        $publicationBuilder->orderBy('publications.id', $order);

        if (!empty($titleEn)) {
            $publicationBuilder->where('publications.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($title)) {
            $publicationBuilder->where('publications.title', 'like', '%' . $title . '%');
        }
        if (is_numeric($rowStatus)) {
            $publicationBuilder->where('publications.row_status', $rowStatus);
        }
        if (is_numeric($industryAssociationId)) {
            $publicationBuilder->where('publications.industry_association_id', $industryAssociationId);
        }
        if (!empty($author)) {
            $publicationBuilder->where('publications.author', 'like', '%' . $author . '%');
        }
        if (!empty($authorEn)) {
            $publicationBuilder->where('publications.author_en', 'like', '%' . $authorEn . '%');
        }
        if (is_numeric($industryAssociationId)) {
            $publicationBuilder->where('publications.industry_association_id', '=', $industryAssociationId);
        }
        if (is_numeric($instituteId)) {
            $publicationBuilder->where('publications.institute_id', '=', $instituteId);
        }

        if (is_numeric($organizationId)) {
            $publicationBuilder->where('publications.organization_id', '=', $organizationId);
        }

        if (is_numeric($showIn)) {
            $publicationBuilder->where('publications.show_in', '=', $showIn);
        }

        if (!empty($publishedAt)) {
            $publicationBuilder->whereDate('publications.published_at', '=', $publishedAt);
        }
        if (!empty($archivedAt)) {
            $publicationBuilder->whereDate('publications.archived_at', '=', $archivedAt);
        }

        /** If request from client side */
        if ($isRequestFromClientSide) {
            $publicationBuilder->whereDate('publications.published_at', '<=', $startTime);
            $publicationBuilder->where(function ($builder) use ($startTime) {
                $builder->whereNull('publications.archived_at');
                $builder->orWhereDate('publications.archived_at', '>=', $startTime);
            });

            $publicationBuilder->active();
        }
        /** @var Collection $publications */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $publications = $publicationBuilder->paginate($pageSize);

        } else {
            $publications = $publicationBuilder->get();
        }

        return $publications;
    }

    /**
     * @param int $id
     * @return Builder|Model
     */
    public function getOnePublication(int $id): Builder|Model
    {
        /** @var Builder $publicationBuilder */
        $publicationBuilder = Publication::select(
            [
                'publications.id',
                'publications.show_in',
                'publications.institute_id',
                'publications.organization_id',
                'publications.industry_association_id',
                'publications.published_at',
                'publications.archived_at',
                'publications.title',
                'publications.title_en',
                'publications.author',
                'publications.author_en',
                'publications.description',
                'publications.description_en',
                'publications.industry_association_id',
                'publications.image_path',
                'publications.created_by',
                'publications.updated_by',
                'publications.created_at',
                'publications.updated_at',
                'publications.row_status'
            ]
        );

        $publicationBuilder->where('publications.id', '=', $id);

        return $publicationBuilder->firstOrFail();


    }

    /**
     * @param array $data
     * @return Publication
     */
    public function store(array $data): Publication
    {
        $publication = new Publication();
        $publication->fill($data);
        $publication->save();
        return $publication;
    }

    /**
     * @param Publication $publication
     * @param array $data
     * @return Publication
     */
    public function update(Publication $publication, array $data): Publication
    {
        $publication->fill($data);
        $publication->save();
        return $publication;
    }

    /**
     * @param Publication $publication
     * @return bool
     */
    public function destroy(Publication $publication): bool
    {
        return $publication->delete();
    }

    /**
     * @param Publication $publication
     * @return bool
     */
    public function restore(Publication $publication): bool
    {
        return $publication->restore();
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
     * @param array $data
     * @param Publication $publication
     * @return Publication
     * @throws Throwable
     */
    public function publishOrArchivePublication(array $data, Publication $publication): Publication
    {
        if ($data['status'] == BaseModel::STATUS_PUBLISH) {
            $publication->published_at = Carbon::now()->format('Y-m-d H:i:s');
            $publication->archived_at = null;
        }
        if ($data['status'] == BaseModel::STATUS_ARCHIVE) {
            $publication->archived_at = Carbon::now()->format('Y-m-d H:i:s');
        }
        $publication->saveOrFail();

        return $publication;
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
                'required',
                'string',
                'max:500',
                'min:2'
            ],
            'description' => [
                'required',
                'string'
            ],

        ];
        return Validator::make($request, $rules, $customMessage);
    }
    /**
     * @param Request $request
     * return use Illuminate\Support\Facades\Validator;
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];
        $rules = [
            'show_in' => [
                "required",
                "integer",
                Rule::in(array_keys(BaseModel::SHOW_INS))
            ],
            'title_en' => [
                'nullable',
                'string',
                'max:400',
                'min:2',
            ],
            'title' => [
                'required',
                'string',
                'max: 400',
                'min:2'
            ],
            'author' => [
                'nullable',
                'string',
                'max: 600',
                'min:2'
            ],
            'author_en' => [
                'nullable',
                'string',
                'max: 400',
                'min:2'
            ],
            'description' => [
                'required',
                'string',
            ],
            'description_en' => [
                'nullable',
                'string',
            ],
            'image_path' => [
                'nullable',
                'string',
                'max: 1000',
                'min:2'
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
            'published_at' => [
                'nullable',
                'date',
            ],
            'archived_at' => [
                'nullable',
                'date',
                'after:published_at'
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                'nullable',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
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
            'order.in' => 'Order must be within ASC or DESC.[30000]',
        ];

        if ($request->filled('order')) {
            $request->offsetSet('order', strtoupper($request->get('order')));
        }

        return Validator::make($request->all(), [
            'show_in' => 'nullable|integer|gt:0',
            'title_en' => 'nullable|max:300|min:2',
            'title' => 'nullable|max:600|min:2',
            'institute_id' => 'nullable|integer|gt:0',
            'organization_id' => 'nullable|integer|gt:0',
            'industry_association_id' => 'nullable|integer|gt:0',
            'author' => 'nullable|max:600|min:2',
            'author_en' => 'nullable|max:600|min:2',
            'page' => 'nullable|integer|gt:0',
            'page_size' => 'nullable|integer|gt:0',
            'published_at' => [
                'nullable',
                'date'
            ],
            'archived_at' => [
                'nullable',
                'date'
            ],
            'order' => [
                'string',
                'nullable',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "nullable",
                "integer",
                Rule::in(BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE),
            ],
        ], $customMessage);
    }
}
