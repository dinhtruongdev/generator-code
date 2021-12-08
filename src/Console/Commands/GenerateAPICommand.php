<?php

namespace Generator\Console\Commands;

use Carbon\Carbon;
use Schema;

class GenerateAPICommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:api {model} {--module=} {--field=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API';

     /**
     * @var array
     */
    protected $types = ['controller', 'migration', 'model', 'route', 'repository', 'create_request', 'update_request', 'resource', 'service'];

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->module = $this->option('module');
        $this->configSchema();

        if (config('generator.autoload')) {
            exec('composer dump-autoload');
        }
    }

    /**
     * Generate file by type.
     *
     * @param string $type
     * @return void
     */
    public function generate($type)
    {
        switch ($type) {
            case 'controller':
                if (! file_exists(base_path('app/Http/Controllers', 0777, true))) {
                    mkdir(base_path('app/Http/Controllers', 0777, true));
                }

                if($this->module) {
                    if (!file_exists(base_path('app/Http/Controllers/'.$this->module.'/'.$this->model['STUDLY'].'Controller.php'))) {
                        $dir = 'app/Http/Controllers/'.$this->module.'/';
                        $name = $dir . $this->model['STUDLY'] . 'Controller.php';
                    }
                } else {
                    $dir = 'app/Http/Controllers/';
                    $name = $dir . $this->model['STUDLY'] . 'Controller.php';
                }
                break;
            // case 'migration':
            //     $dir = 'database/migrations/';
            //     $name = $dir . Carbon::now()->format('Y_m_d_u') . '_create_' . $this->model['PLURAL_SNAKE'] . '_table.php';
            //     break;
            case 'model':
                $dir = 'app/Models/';
                $name = $dir . $this->model['STUDLY'] . '.php';
                break;
            case 'route':
                $name = 'routes/api.php';
                break;
            case 'repository':
                if (! file_exists(base_path('app/Repositories'))) {
                    mkdir(base_path('app/Repositories', 0777, true));
                }
                if($this->module) {
                    if (!file_exists(base_path('app/Repositories/'.$this->module.'/'.$this->model['STUDLY'].'Repository.php'))) {
                        $dir = 'app/Repositories/'.$this->module.'/';
                        $name = $dir . $this->model['STUDLY'] . 'Repository.php';
                    }
                } else {
                    $dir = 'app/Repositories/';
                    $name = $dir . $this->model['STUDLY'] . 'Repository.php';
                }
                break;
            case 'create_request':
                if($this->module) {
                    if (!file_exists(base_path('app/Http/Requests/'. $this->module . '/' . $this->model['STUDLY'] . '/' .$this->module.$this->model['STUDLY'].'Request.php'))) {
                        $dir = 'app/Http/Requests/'.$this->module .'/'. $this->model['STUDLY'] . '/';
                        $name = $dir . 'Create' . $this->model['STUDLY'] . 'Request.php';
                    }
                } else {
                    $dir = 'app/Http/Requests/';
                    $name = $dir . 'Create' . $this->model['STUDLY'] . 'Request.php';
                }
                break;
            case 'update_request':
                if($this->module) {
                    if (!file_exists(base_path('app/Http/Requests/'. $this->module . '/' . $this->model['STUDLY'] . '/' .$this->module.$this->model['STUDLY'].'Request.php'))) {
                        $dir = 'app/Http/Requests/'.$this->module .'/'. $this->model['STUDLY'] . '/';
                        $name = $dir . 'Update' . $this->model['STUDLY'] . 'Request.php';
                    }
                } else {
                    $dir = 'app/Http/Requests/';
                    $name = $dir . 'Update' . $this->model['STUDLY'] . 'Request.php';
                }
                break;
            case 'resource':
                if (! file_exists(base_path('app/Http/Resources'))) {
                    mkdir(base_path('app/Http/Resources', 0777, true));
                }
                if($this->module) {
                    if (!file_exists(base_path('app/Http/Resources/'.$this->module.'/'.$this->model['STUDLY'].'Resource.php'))) {
                        $dir = 'app/Http/Resources/'.$this->module.'/';
                        $name = $dir . $this->model['STUDLY'] . 'Resource.php';
                    }
                } else {
                    $dir = 'app/Http/Resources/';
                    $name = $dir . $this->model['STUDLY'] . 'Resource.php';
                }
                break;
            // case 'service':
            //     if (!file_exists(base_path("app/Services"))) {
            //         mkdir(base_path("app/Services", 0777, true));
            //     }
            //     if($this->module) {
            //         if (!file_exists(base_path('app/Services/'.$this->module.'/'.$this->model['STUDLY'].'Service.php'))) {
            //             $dir = 'app/Services/'.$this->module.'/';
            //             $name = $dir . $this->model['STUDLY'] . 'Service.php';
            //         }
            //     } else {
            //         $dir = 'app/Services/';
            //         $name = $dir . $this->model['STUDLY'] . 'Service.php';
            //     }
            //     break;
            default:
                return false;
                break;
        }

        $content =
            view("api-templates::$type")
            ->with([
                'config' => config('generator'),
                'fields' => $this->fields,
                'model' => $this->model,
                'module' => $this->module,
            ])
            ->render();

        if (isset($dir)) {
            $this->checkDirectory($dir);
            file_put_contents($name, '<?php' . PHP_EOL . PHP_EOL . $content);
        } else {
            file_put_contents($name, PHP_EOL . $content, FILE_APPEND | LOCK_EX);
        }
    }
}
