<?php

namespace App\Listeners\BatchCalender;

use App\Events\BatchCalender\BatchCalenderBatchAssignRollbackEvent;
use App\Events\BatchCalender\BatchCalenderBatchAssignSuccessEvent;
use Illuminate\Database\QueryException;
use Throwable;
use PDOException;
use App\Models\BaseModel;
use App\Services\Calender\CalenderEventService;
use App\Services\RabbitMQService;
use Illuminate\Contracts\Queue\ShouldQueue;

class BatchCalenderYouthBatchAssignInstituteToCmsListener implements ShouldQueue
{
    public CalenderEventService $calenderEventService;
    public RabbitMQService $rabbitMQService;

    public function __construct(CalenderEventService $calenderEventService, RabbitMQService $rabbitMQService)
    {
        $this->calenderEventService = $calenderEventService;
        $this->rabbitMQService = $rabbitMQService;
    }

    function handle($event)
    {
        $eventData = json_decode(json_encode($event), true);
        $data = $eventData['data'] ?? [];
        try {
            $this->rabbitMQService->receiveEventSuccessfully(
                BaseModel::SAGA_INSTITUTE_SERVICE,
                BaseModel::SAGA_CMS_SERVICE,
                get_class($this),
                json_encode($event)
            );

            $alreadyConsumed = $this->rabbitMQService->checkEventAlreadyConsumed();
            if (!$alreadyConsumed) {
                $this->calenderEventService->createEventAfterBatchAssign($data);

                /** Store the event as a Success event into Database */
                $this->rabbitMQService->sagaSuccessEvent(
                    BaseModel::SAGA_INSTITUTE_SERVICE,
                    BaseModel::SAGA_CMS_SERVICE,
                    get_class($this),
                    json_encode($data)
                );
                /** Trigger EVENT to Institute Service via RabbitMQ */
                event(new BatchCalenderBatchAssignSuccessEvent($data));
            }
        } catch (Throwable $e){
            if ($e instanceof QueryException && $e->getCode() == BaseModel::DATABASE_CONNECTION_ERROR_CODE) {
                /** Technical Recoverable Error Occurred. RETRY mechanism with DLX-DLQ apply now by sending a rejection */
                throw new PDOException("Database Connectivity Error");
            } else {
                /** Technical Non-recoverable Error "OR" Business Rule violation Error Occurred. Compensating Transactions apply now */
                /** Store the event as an Error event into Database */
                $this->rabbitMQService->sagaErrorEvent(
                    BaseModel::SAGA_INSTITUTE_SERVICE,
                    BaseModel::SAGA_CMS_SERVICE,
                    get_class($this),
                    json_encode($data),
                    $e
                );

                /** Trigger EVENT to Institute Service via RabbitMQ */
                $data['publisher_service'] = BaseModel::SAGA_CMS_SERVICE;
                event(new BatchCalenderBatchAssignRollbackEvent($data));
            }
        }
    }

}
