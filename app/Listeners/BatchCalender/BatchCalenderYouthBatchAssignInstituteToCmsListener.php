<?php

namespace App\Listeners\BatchCalender;

use App\Facade\RabbitMQFacade;
use App\Models\BaseModel;
use App\Services\Calender\CalenderEventService;
use App\Services\RabbitMQService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $alreadyConsumed = $this->rabbitMQService->checkEventAlreadyConsumed();
        if (!$alreadyConsumed) {
            $eventData = json_decode(json_encode($event), true);
            $data = $eventData['data'] ?? [];

            try {
                $this->calenderEventService->createEventAfterBatchAssign($data);

                /** Store the event as a Success event into Database */
                $this->rabbitMQService->sagaSuccessEvent(
                    BaseModel::SAGA_CMS_SERVICE,
                    BaseModel::SAGA_INSTITUTE_SERVICE,
                    get_class($this),
                    json_encode($data)
                );
            } catch (\Exception $e) {
                /** Store the event as an Error event into Database */
                $this->rabbitMQService->sagaErrorEvent(
                    BaseModel::SAGA_CMS_SERVICE,
                    BaseModel::SAGA_INSTITUTE_SERVICE,
                    get_class($this),
                    json_encode($data),
                    $e
                );
                $data['publisher_service'] = BaseModel::SAGA_CMS_SERVICE;

            }
        }
    }

}
