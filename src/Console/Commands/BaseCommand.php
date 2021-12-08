<?php

namespace Generator\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class BaseCommand extends Command
{

   /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:all {model} {--field=*} {--module=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate All';

    /**
     * @var array
     */
    protected $fields;

    /**
     * @var string
     */
    protected $model;

    /**
     * @var string
     */
    protected $module;

    /**
     * @var string
     */
    protected $table;

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
        $model = $this->argument('model');
        $fields = $this->option('field');
        $module = $this->option('module');
        $this->call('generate:api', [
            'model' => $model,
            '--field' => $fields,
            '--module' => $module
        ]);
    }

    /**
     * Config schema.
     *
     * @return void
     */
    public function configSchema()
    {
        $choices = $this->choice('What types of file do you want to generate', array_merge(['all'], $this->types), 0, null, true);

        $model = Str::of($this->argument('model'))->singular();

        $this->model = [
            'PLURAL_UPPER' => $model->plural()->upper(),
            'PLURAL_LOWER' => $model->plural()->lower(),
            'PLURAL_UC' => $model->plural()->ucfirst(),
            'PLURAL_STUDLY' => $model->plural()->studly(),
            'PLURAL_CAMEL' => $model->plural()->camel(),
            'PLURAL_KEBAB' => $model->plural()->kebab(),
            'PLURAL_SNAKE' => $model->plural()->snake(),
            'UPPER' => $model->upper(),
            'LOWER' => $model->lower(),
            'UC' => $model->ucfirst(),
            'STUDLY' => $model->studly(),
            'CAMEL' => $model->camel(),
            'KEBAB' => $model->kebab(),
            'SNAKE' => $model->snake(),
        ];

        $this->table = $this->model['PLURAL_SNAKE'];

        if (Schema::hasTable($this->table)) {
            $this->info('Table "' . $this->table . '" already existed');
            $fields = Schema::getColumnListing($this->table);
            if (!count($fields)) {
                $this->error('No fields found');

                return;
            }
            foreach ($fields as $name) {
                $this->bindColumn($name, Schema::getColumnType($this->table, $name));
            }
        } else {
            $this->info('Table "' . $this->table . '" doesn\'t exist');
            $fields = $this->option('field');
            if (!count($fields)) {
                $this->error('No fields found');

                return;
            }
            foreach ($fields as $name) {
                if (!preg_match('/([A-z]+):([A-z]+)/', $name, $matches)) {
                    $this->error('Field "' . $name . '" doesn\'t have correct format');

                    return;
                }
                $this->bindColumn($matches[1], $matches[2]);
            }
        }

        foreach ($this->types as $type) {
            if (in_array('all', $choices) || in_array($type, $choices)) {
                $this->generate($type);
                $this->info('File "' . $type . '" has been successfully generated');
            }
        }
    }

     /**
     * Binding column data.
     *
     * @param string $name
     * @param string $type
     *
     * @return void
     */
    public function bindColumn($name, $type)
    {
        $excepts = ['id', 'created_at', 'updated_at', 'deleted_at'];

        if (in_array($name, $excepts)) {
            return;
        }

        switch ($type) {
            case 'smallint':
                $this->fields[$name] = [
                    'type' => 'tinyInteger',
                ];
            break;
            case 'bigint':
                $this->fields[$name] = [
                    'type' => 'bigInteger',
                ];
            break;
            case 'datetimetz':
                $this->fields[$name] = [
                    'type' => 'dateTimeTz',
                ];
            break;
            case 'blob':
                $this->fields[$name] = [
                    'type' => 'binary',
                ];
                break;
            // case 'integer':
            // case 'boolean':
            // case 'date':
            // case 'time':
            // case 'datetime':
            // case 'text':
            // case 'decimal':
            // case 'float':
            // case 'object':
            // case 'array':
            // case 'simple_array':
            // case 'json_array':
            // case 'guid':
            default:
                $this->fields[$name] = [
                    'type' => $type,
                ];
                break;
        }
    }

    /**
     * Make directory if not exist.
     *
     * @param string $dir
     * @return void
     */
    public function checkDirectory($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0775, true);
        }
    }
}