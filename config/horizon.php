<?php

return [
  'default_wait_max' => env('HORIZON_DEFAULT_WAIT_MAX', 60),
  'metric_data_wait_max' => env('HORIZON_METRIC_DATA_WAIT_MAX', 60),
  'realtime_wait_max' => env('HORIZON_REALTIME_WAIT_MAX', 60),
  'queue_max' => env('HORIZON_QUEUE_MAX', 100000),
];
