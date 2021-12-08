@if($module)
namespace App\Http\Requests\{{ str_replace("/","\\", $module)}}\{{$model['STUDLY']}};
@else
namespace App\Http\Requests\{{$model['STUDLY']}};
@endif

use App\Http\Requests\FormRequest;

class Update{{ $model['STUDLY'] }}Request extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
@foreach($fields as $field => $item)
            '{{ $field }}' => 'required',
@endforeach
        ];
    }
}
