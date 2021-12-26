<?php

namespace App\Listeners\BatchCalender;

use App\Facade\RabbitMQFacade;
use App\Services\RabbitMQService;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Connectors\RabbitMQConnector;

class BatchCalenderBatchAssignSuccessCmsToInstituteListener implements ShouldQueue
{
    private RabbitMQConnector $connector;
    private RabbitMQService $rabbitmqService;

    /** Set rabbitmq config where this event is going to publish */
    private const EXCHANGE_CONFIG_NAME = 'institute';
    private const QUEUE_CONFIG_NAME = 'batchCalender';
    private const RETRY_MECHANISM = false;

    /**
     * @throws Exception
     */
    public function __construct(RabbitMQConnector $connector, RabbitMQService $rabbitmqService)
    {
        $this->connector = $connector;
        $this->rabbitmqService = $rabbitmqService;
        RabbitMQFacade::publishEvent(
            $this->connector,
            $this->rabbitmqService,
            self::EXCHANGE_CONFIG_NAME,
            self::QUEUE_CONFIG_NAME,
            self::RETRY_MECHANISM
        );
    }

    public function handle()
    {

    }
}