@if($module)
namespace App\Repositories\{{ str_replace("/","\\", $module)}};
@else
namespace App\Repositories;
@endif

use App\Repositories\BaseRepository;
use App\Models\{{ $model['STUDLY'] }};

class {{ $model['STUDLY'] }}Repository extends BaseRepository
{
    /**
     * @return App\Models\{{ $model['STUDLY'] }}
     */
    public function getmodel()
    {
        return {{ $model['STUDLY'] }}::class;
    }
}
