<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\MailSendEvent::class => [
            \App\Listeners\MailSendListener::class
        ],
        \App\Events\SmsSendEvent::class => [
            \App\Listeners\SmsSendListener::class
        ],
        \App\Events\BatchCalender\BatchCalenderBatchAssignSuccessEvent::class => [
            \App\Listeners\BatchCalender\BatchCalenderBatchAssignSuccessCmsToInstituteListener::class
        ],
        \App\Events\BatchCalender\BatchCalenderBatchAssignRollbackEvent::class => [
            \App\Listeners\BatchCalender\BatchCalenderBatchAssignRollbackCmsToInstituteListener::class
        ],
    ];
}
