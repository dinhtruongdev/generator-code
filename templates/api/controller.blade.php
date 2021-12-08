@if($module)
namespace App\Http\Controllers\{{ str_replace("/","\\", $module)}};

use App\Http\Requests\{{ str_replace("/","\\", $module)}}\Create{{ $model['STUDLY'] }}Request;
use App\Http\Requests\{{ str_replace("/","\\", $module)}}\Update{{ $model['STUDLY'] }}Request;
use App\Http\Resources\{{ str_replace("/","\\", $module)}}\{{ $model['STUDLY'] }}Resource;
use App\Models\{{ $model['STUDLY'] }};
use App\Repositories\{{ str_replace("/","\\", $module)}}\{{ $model['STUDLY'] }}Repository;
@else
namespace App\Http\Controllers;

use App\Http\Requests\{{ $model['STUDLY'] }}\Create{{ $model['STUDLY'] }}Request;
use App\Http\Requests\{{ $model['STUDLY'] }}\Update{{ $model['STUDLY'] }}Request;
use App\Http\Resources\{{ $model['STUDLY'] }}Resource;
use App\Models\{{ $model['STUDLY'] }};
use App\Repositories\{{ $model['STUDLY'] }}Repository;
@endif
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

/**
 *  @OA\Tag(
 *      name="{{ $model['STUDLY'] }}",
 *      description="{{ $model['STUDLY'] }} Resource",
 * )
 *
 *  @OA\Schema(
 *      schema="{{ $model['CAMEL'] }}",
@foreach($fields as $field => $item)
 *      @OA\Property(
 *          property="{{ $field }}",
 *          type="number",
 *          example=1,
 *      ),
@endforeach
 *  )
 */
class {{ $model['STUDLY'] }}Controller extends Controller
{
    /**
     * @var App\Repositories\{{ $model['STUDLY'] }}Repository {{ $model['CAMEL'] }}Repository
     */
    protected ${{ $model['CAMEL'] }}Repository;

    public function __construct({{ $model['STUDLY'] }}Repository ${{ $model['CAMEL'] }}Repository)
    {
        $this->{{ $model['CAMEL'] }}Repository = ${{ $model['CAMEL'] }}Repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/{{ $model['CAMEL'] }}",
     *      tags={"{{ $model['STUDLY'] }}"},
     *      operationId="index{{ $model['STUDLY'] }}",
     *      summary="List {{ $model['STUDLY'] }}",
     *      @OA\Parameter(ref="#/components/parameters/page"),
     *      @OA\Parameter(ref="#/components/parameters/limit"),
     *      @OA\Parameter(ref="#/components/parameters/sort"),
     *      @OA\Parameter(ref="#/components/parameters/sortType"),
     *      @OA\Parameter(ref="#/components/parameters/condition"),
     *      @OA\Response(
     *          response=200,
     *          description="Listed",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/{{ $model['CAMEL'] }}")
     *              ),
     *              @OA\Property(
     *                  property="meta",
     *                  ref="#/components/schemas/meta"
     *              ),
     *              @OA\Property(
     *                  property="links",
     *                  ref="#/components/schemas/links"
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function index(Request $request)
    {
        $input = $request->all();
        ${{ $model['PLURAL_CAMEL'] }} = $this->{{ $model['CAMEL'] }}Repository->list($input);
        $result = {{ $model['STUDLY'] }}Resource::collection(${{ $model['PLURAL_CAMEL'] }});

        return response()->success(self::INDEX, $result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\{{ $model['STUDLY'] }}\Create{{ $model['STUDLY'] }}Request $request
     * @return \Illuminate\Http\Response
     *
     * @param Request $request
     * @return Response
     *
     *  @OA\Post(
     *      path="/api/{{ $model['CAMEL'] }}",
     *      tags={"{{ $model['STUDLY'] }}"},
     *      operationId="store{{ $model['STUDLY'] }}",
     *      summary="Create {{ $model['STUDLY'] }}",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/{{ $model['CAMEL'] }}"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Created",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/{{ $model['CAMEL'] }}",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function store(Create{{ $model['STUDLY'] }}Request $request, {{ $model['STUDLY'] }} ${{ $model['CAMEL'] }})
    {
        if (Gate::denies('modify', ${{ $model['CAMEL'] }})) {
            return response()->error(self::INVALID_PERMISSIONS, self::STORE, 401);
        }
        $input = $request->all();
        ${{ $model['CAMEL'] }} = $this->{{ $model['CAMEL'] }}Repository->create($input);
        $result =  new {{ $model['STUDLY'] }}Resource(${{ $model['CAMEL'] }});

        return response()->success(self::STORE, $result);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\{{ $model['STUDLY'] }}  ${{ $model['CAMEL'] }}
     * @return \Illuminate\Http\Response
     *
     *  @OA\Get(
     *      path="/api/{{ $model['CAMEL'] }}/{id}",
     *      tags={"{{ $model['STUDLY'] }}"},
     *      operationId="show{{ $model['STUDLY'] }}",
     *      summary="Get {{ $model['STUDLY'] }}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Getted",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/{{ $model['CAMEL'] }}",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function show(Request $request, {{ $model['STUDLY'] }} ${{ $model['CAMEL'] }})
    {
        if (Gate::denies('modify', ${{ $model['CAMEL'] }})) {
            return response()->error(self::INVALID_PERMISSIONS, self::SHOW, 401);
        }
        $input = $request->all();
        $result = new {{ $model['STUDLY'] }}Resource(${{ $model['CAMEL'] }});

        return response()->success(self::SHOW, $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\{{ $model['STUDLY'] }}\Update{{ $model['STUDLY'] }}Request $request
     * @param \App\Models\{{ $model['STUDLY'] }}  ${{ $model['CAMEL'] }}
     * @return \Illuminate\Http\Response
     *
     *  @OA\Put(
     *      path="/api/{{ $model['CAMEL'] }}/{id}",
     *      tags={"{{ $model['STUDLY'] }}"},
     *      operationId="update{{ $model['STUDLY'] }}",
     *      summary="Update {{ $model['STUDLY'] }}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/{{ $model['CAMEL'] }}"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Updated",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/{{ $model['CAMEL'] }}",
     *              ),
     *          ),
     *      ),
     *  )
     */
    public function update(Update{{ $model['STUDLY'] }}Request $request, {{ $model['STUDLY'] }} ${{ $model['CAMEL'] }})
    {
        if (Gate::denies('modify', ${{ $model['CAMEL'] }})) {
            return response()->error(self::INVALID_PERMISSIONS, self::UPDATE, 401);
        }
        $input = $request->all();
        $this->{{ $model['CAMEL'] }}Repository->update(${{ $model['CAMEL'] }}, $input);
        $result = new {{ $model['STUDLY'] }}Resource(${{ $model['CAMEL'] }});

        return response()->success(self::UPDATE, $result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\{{ $model['STUDLY'] }}  ${{ $model['CAMEL'] }}
     * @return \Illuminate\Http\Response
     *
     *  @OA\Delete(
     *      path="/api/{{ $model['CAMEL'] }}/{id}",
     *      tags={"{{ $model['STUDLY'] }}"},
     *      operationId="delete{{ $model['STUDLY'] }}",
     *      summary="Delete {{ $model['STUDLY'] }}",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Deleted",
     *      ),
     *  )
     */
    public function destroy({{ $model['STUDLY'] }} ${{ $model['CAMEL'] }})
    {
        if (Gate::denies('modify', ${{ $model['CAMEL'] }})) {
            return response()->error(self::INVALID_PERMISSIONS, self::REMOVE, 401);
        }
        $result = $this->{{ $model['CAMEL'] }}Repository->destroy(${{ $model['CAMEL'] }});

        return response()->success(self::REMOVE, $result);
    }
}
