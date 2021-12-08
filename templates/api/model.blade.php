namespace App\Models;

use App\Models\BaseModel;

class {{ $model['STUDLY'] }} extends BaseModel
{
    protected $fillable = [
@foreach($fields as $field => $item)
        '{{ $field }}',
@endforeach
    ];

    public $selectable = [
        '*',
    ];

    public $sortable = [
    ];
}
