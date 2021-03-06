@if($module)
namespace App\Http\Resources\{{ str_replace("/","\\", $module)}};
@else
namespace App\Http\Resources;
@endif

use Illuminate\Http\Resources\Json\JsonResource;

class {{ $model['STUDLY'] }}Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
@foreach($fields as $field => $item)
            '{{ $field }}' => $this->{{ $field }},
@endforeach
        ];
    }
}

