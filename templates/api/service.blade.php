@if($module)
    namespace App\Services\{{ str_replace("/","\\", $module)}};
@else
    namespace App\Services;
@endif

use App\Services\BaseService;
use App\Models\{{ $model['STUDLY'] }};
@if($module)
use App\Repositories\{{ str_replace("/","\\", $module)}}\{{ $model['STUDLY'] }}Repository;
@else
use App\Repositories\{{ $model['STUDLY'] }}Repository;
@endif

class {{ $model['STUDLY'] }}Service extends BaseService
{
    /**
    * @var App\Repositories\{{ $model['STUDLY'] }}Repository  {{ $model['CAMEL'] }}Repository.
    */
    protected ${{ $model['CAMEL'] }}Repository;

    /**
     * {{ $model['STUDLY'] }}Service construct
     */
    public function __construct({{ $model['STUDLY'] }}Repository ${{ $model['CAMEL'] }}Repository)
    {
        $this->{{ $model['CAMEL'] }}Repository = ${{ $model['CAMEL'] }}Repository;
        parent::__construct();
    }

    /**
     * @return App\Repositories\{{ $model['STUDLY'] }}Repository
     */
    public function getRepository()
    {
        return {{ $model['STUDLY'] }}Repository::class;
    }
}
