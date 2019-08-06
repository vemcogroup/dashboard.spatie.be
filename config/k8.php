<?php

return [

  'master' => env('K8_MASTER', ''),
  'ca_cert' => env('K8_CA_CERT', ''),
  'token' => env('K8_TOKEN', ''),
  'namespace' => env('K8_NAMESPACE', ''),
];
