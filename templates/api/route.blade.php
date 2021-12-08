@if($module)
// start router {{ $model['KEBAB'] }}
Route::group(['namespace' => 'Api\{{ str_replace("/","\\", $module) }}'], function(){
    Route::apiResource('{{ $model['KEBAB'] }}', '{{ $model['STUDLY'] }}Controller');
});
// end router {{ $model['KEBAB'] }}
@else
// start router {{ $model['KEBAB'] }}
Route::group(['namespace' => 'Api'], function(){
    Route::apiResource('{{ $model['KEBAB'] }}', '{{ $model['STUDLY'] }}Controller');
});
// end router {{ $model['KEBAB'] }}
@endif