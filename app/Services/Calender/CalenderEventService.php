<?php


namespace App\Services\Calender;


use App\Models\BaseModel;
use App\Models\CalenderEvent;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class CalenderEventService
{

    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllCalenderEvents(array $request, Carbon $startTime): array
    {
        $type = $request['type'] ?? "";
        $month = $request['month'] ?? "";
        $year = $request['year'] ?? "";
        $date = $request['date'] ?? "";
        $fromDate = $request['from_date'] ?? "";
        $toDate = $request['to_date'] ?? "";
        $youthId = $request['youth_id'] ?? "";
        $instituteId = $request['institute_id'] ?? "";
        $organizationId = $request['organization_id'] ?? "";
        $batchId = $request['batch_id'] ?? "";
        $industryAssociationId = $request['industry_association_id'] ?? "";
        $title = $request['title'] ?? "";
        $titleEn = $request['title_en'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Builder $calenderEventsBuilder */
        $calenderEventsBuilder = CalenderEvent::select([
            'calender_events.id',
            'calender_events.title',
            'calender_events.title_en',
            'calender_events.youth_id',
            'calender_events.batch_id',
            'calender_events.institute_id',
            'calender_events.organization_id',
            'calender_events.start_date',
            'calender_events.end_date',
            'calender_events.start_time',
            'calender_events.end_time',
            'calender_events.color',
            'calender_events.created_at',
            'calender_events.updated_at'
        ]);
        $calenderEventsBuilder->orderBy('calender_events.id', $order);

        if ($type) {
            $now = CarbonImmutable::now();
            if ($type == CalenderEvent::CALENDER_TYPE_YEAR) {
                $year = $year ?: $now->year;
                $calenderEventsBuilder->where(function ($builder) use ($year){
                    $builder->whereYear('start_date', $year)->orWhereYear('end_date', $year);
                });

            } elseif ($type == CalenderEvent::CALENDER_TYPE_MONTH) {
                $month = $month ?: $now->month;
                $year = $year ?: $now->year;

                $startDate = Carbon::createFromDate($year, $month)->startOfMonth();
                $endDate = Carbon::createFromDate($year, $month)->endOfMonth();
                $calenderEventsBuilder->where(function ($builder) use ($startDate,$endDate){
                    $builder->whereBetween('start_date', [$startDate, $endDate])->orWhereBetween('end_date', [$startDate, $endDate]);
                });

            } elseif ($type == CalenderEvent::CALENDER_TYPE_DAY) {
                $date = $date ?: $now;
                $calenderEventsBuilder->where(function ($builder) use ($date){
                    $builder->whereDate('start_date', $date)->orWhereDate('end_date', $date);
                });

            } elseif ($type == CalenderEvent::CALENDER_TYPE_WEEK) {
                $date =  $date ? CarbonImmutable::createFromDate($date) : $now;

                $fromDate = $date->startOfWeek();
                $toDate = $date->endOfWeek();
                $calenderEventsBuilder->where(function ($builder) use ($fromDate,$toDate){
                    $builder->whereBetween('start_date', [$fromDate, $toDate])->orWhereBetween('end_date', [$fromDate, $toDate]);
                });

            } elseif ($type == CalenderEvent::CALENDER_TYPE_SCHEDULE) {

                $fromDate = $fromDate ?: $now->startOfMonth();
                $toDate = $toDate ?: $now->endOfMonth();
                $calenderEventsBuilder->where(function ($builder) use ($fromDate, $toDate){
                    $builder->whereBetween('start_date', [$fromDate, $toDate])->orWhereBetween('end_date', [$fromDate, $toDate]);
                });
            }
        }

        if (!empty($title)) {
            $calenderEventsBuilder->where('calender_events.title', 'like', '%' . $title . '%');
        }

        if (!empty($titleEn)) {
            $calenderEventsBuilder->where('calender_events.title_en', 'like', '%' . $titleEn . '%');
        }

        if (!empty($youthId)) {
            $calenderEventsBuilder->where('calender_events.youth_id', $youthId);
        }

        if (!empty($instituteId)) {
            $calenderEventsBuilder->where('calender_events.institute_id', $instituteId);
        }

        if (!empty($batchId)) {
            $calenderEventsBuilder->where('calender_events.batch_id', $batchId);
        }

        if (!empty($organizationId)) {
            $calenderEventsBuilder->where('calender_events.organization_id', $organizationId);
        }


        if (!empty($industryAssociationId)) {
            $calenderEventsBuilder->where('calender_events.industry_association_id', $industryAssociationId);
        }


        /** @var Collection $calenderEvents */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $calenderEvents = $calenderEventsBuilder->paginate($pageSize);
            $paginateData = (object)$calenderEvents->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $calenderEvents = $calenderEventsBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $calenderEvents->toArray()['data'] ?? $calenderEvents->toArray();
        $response['response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];
        return $response;

    }


    /**
     * @param int $id
     * @return CalenderEvent
     */
    public function getOneCalenderEvent(int $id): CalenderEvent
    {
        /** @var Builder|CalenderEvent $calenderEventBuilder */
        $calenderEventBuilder = CalenderEvent::select([
            'calender_events.id',
            'calender_events.title',
            'calender_events.title_en',
            'calender_events.youth_id',
            'calender_events.batch_id',
            'calender_events.institute_id',
            'calender_events.organization_id',
            'calender_events.start_date',
            'calender_events.end_date',
            'calender_events.start_time',
            'calender_events.end_time',
            'calender_events.color',
            'calender_events.created_at',
            'calender_events.updated_at'
        ]);
        $calenderEventBuilder->where('calender_events.id', $id);

        /** @var CalenderEvent $calenderEvent */
        return $calenderEventBuilder->firstOrFail();
    }

    /**
     * @param array $data
     * @return CalenderEvent
     * @throws \Throwable
     */
    public function store(array $data): CalenderEvent
    {
        $calenderEvent = app(CalenderEvent::class);
        $calenderEvent->fill($data);
        throw_if(!$calenderEvent->save(), 'RuntimeException', 'Calender event has not been Saved to db.', 500);
        return $calenderEvent;
    }

    /**
     * @param CalenderEvent $calenderEvent
     * @param array $data
     * @return CalenderEvent
     * @throws \Throwable
     */
    public function update(CalenderEvent $calenderEvent, array $data): CalenderEvent
    {
        $calenderEvent->fill($data);
        throw_if(!$calenderEvent->save(), 'RuntimeException', 'Calender event has not been deleted.', 500);
        return $calenderEvent;
    }

    /**
     * @param CalenderEvent $calenderEvent
     * @return bool
     * @throws \Throwable
     */
    public function destroy(CalenderEvent $calenderEvent): bool
    {
        throw_if(!$calenderEvent->delete(), 'RuntimeException', 'Calender event has not been deleted.', 500);
        return true;
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'title' => [
                'required',
                'string',
                'max:500'
            ],
            'title_en' => [
                'nullable',
                'string',
                'max:250'
            ],
            'start_date' => [
                'required',
                'date'
            ],
            'end_date' => [
                'required',
                'date',
                'after:start_date'
            ],
            'start_time' => [
                'nullable',
                'date_format:H:i'
            ],
            'end_time' => [
                'nullable',
                'date_format:H:i'
            ],
            'color' => [
                'string'
            ]
        ];
        return Validator::make($request->all(), $rules);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'order.in' => 'Order must be within ASC or DESC.[30000]',
            'row_status.in' => 'Row status must be within 1 or 0.[30000]'
        ];

        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }

        return Validator::make($request->all(), [
            'type' => [
                'required',
                'string',
                Rule::in(CalenderEvent::CALENDER_TYPES)
            ],
            'month' => [
                'nullable',
                'int',
                'min:1',
                'max:12'
            ],
            'year' => [
                'nullable',
                'int',
                'digits:4'
            ],
            'date' => [
                'nullable',
                'date'
            ],
            'from_date' => [
                'nullable',
                'date'
            ],
            'to_date' => [
                'nullable',
                'date'
            ],
            'youth_id' => [
                'nullable',
                'int'
            ],
            'institute_id' => [
                'nullable',
                'int'
            ],
            'organization_id' => [
                'nullable',
                'int'
            ],
            'batch_id' => [
                'nullable',
                'int'
            ],
            'industry_association_id' => [
                'nullable',
                'int'
            ],
            'title' => [
                'nullable',
                'string'
            ],
            'title_en' => [
                'nullable',
                'string'
            ],
            'page_size' => 'int|gt:0',
            'page' => 'int|gt:0',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "int",
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }
}
