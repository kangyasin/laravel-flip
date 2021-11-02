<?php
return [
  'key' => env('FLIP_SECRET_KEY', 'SET_DEFAULT_FLIP_SECRET_KEY_HERE'),
  'key_prod' => env('FLIP_SECRET_KEY_PROD', 'SET_DEFAULT_FLIP_SECRET_KEY_PROD_HERE'),
  'production' => env('FLIP_PRODUCTION', false),
  'idempotency-key' => env('IDEMPOTENCY_KEY', 'SET_DEFAULT_FLIP_IDEMPOTENCY_KEY_PROD'),
  'middleware' => ['web', 'auth'],
  'prefix' => 'flip'
];
