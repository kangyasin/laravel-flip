<?php

Route::group(['namespace' => 'Kangyasin\LaravelFlip\Http\Controllers', 'prefix' => 'flip'], function () {
    Route::post('bank/inquiry', 'SnapController@bank_inquiry')->name('bank_inquiry');
    Route::post('bank/disbursement', 'SnapController@bank_disbursement')->name('bank_disbursement');
    Route::get('balance', 'SnapController@balance')->name('balance');
    Route::get('disbursement/{id}', 'SnapController@disbursement')->name('disbursement');
    Route::get('special/disbursement/{id}', 'SnapController@special_disbursement_id')->name('special_disbursement_id');
    Route::get('special/disbursement/empotency-id/{id}', 'SnapController@disbursement')->name('special_disbursement_id_empotency');
    Route::get('city/{id}', 'SnapController@city_list')->name('city');
    Route::get('country/{id}', 'SnapController@country_list')->name('country');
    Route::get('city/country/{id}', 'SnapController@city_country_list')->name('city_country');
});
