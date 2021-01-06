<?php

namespace App\Services;

use Exception;
use App\Events\Alarms\QueueAlarm;
use Smsapi\Client\SmsapiHttpClient;
use Smsapi\Client\Feature\Sms\Bag\SendSmssBag;

class SendQueueWaitSmsAlert
{
    protected $event;

    public function handle(QueueAlarm $event)
    {
        $this->event = $event;
        $to = explode(',', config('alert.to'));

        try {
            $apiToken = config('smsapi.token');
            $message = 'Queue: ' . $event->name . ', have a wait time: "' . $event->wait['format'] . ' (' . $event->wait['total']. ' sec.)", please take action.';

            $sms = SendSmssBag::withMessage($to, $message);
            $sms->from = 'Alarm';
            $sms->normalize = true;

            $service = (new SmsapiHttpClient())->smsapiComService($apiToken);

            $service->smsFeature()->sendSmss($sms);
        } catch (Exception $exception) {

        }

    }
}
