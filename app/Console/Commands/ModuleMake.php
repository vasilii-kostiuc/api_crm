<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ModuleMake extends Command {

    private Filesystem $filesystem;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}
                                        {--all}
                                        {--migration}
                                        {--vue}
                                        {--view}
                                        {--controller}
                                        {--model}
                                        {--api}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description {name}
                                                  {--all}
                                                  {--migration}
                                                  {--vue}
                                                  {--view}
                                                  {--controller}
                                                  {--model}
                                                  {--api}';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem) {
        parent::__construct();

        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        if ($this->option('all')) {
            $this->input->setOption('migration', true);
            $this->input->setOption('vue', true);
            $this->input->setOption('view', true);
            $this->input->setOption('controller', true);
            $this->input->setOption('model', true);
            $this->input->setOption('api', true);
        }
        if ($this->option('model')) {
            $this->createModel();
        }
        if ($this->option('controller')) {
            $this->createController();
        }
        if ($this->option('api')) {
            $this->createApiController();
        }
        if ($this->option('migration')) {
            $this->createMigration();
        }
        if ($this->option('vue')) {
            $this->createVueComponent();
        }
        if ($this->option('view')) {
            $this->createView();
        }


    }

    private function createModel() {
        $model = Str::singular(Str::studly(class_basename($this->argument('name'))));
        $this->call('make:model', [
            'name' => "App\\Modules\\" . trim($this->argument('name')) . "\\Models\\" . $model,
        ]);
    }

    private function createController() {
        $controller = Str::studly(class_basename($this->argument('name')));
        $modelName = Str::singular(Str::studly(class_basename($this->argument('name'))));

        $path = $this->getControllerPath($this->argument('name'));

        if ($this->alreadyExists($path)) {
            $this->error("Controller already exists");
        } else {
            $this->makeDirectory($path);

            $stub = $this->filesystem->get(base_path('resources/stubs/controller.model.api.stub'));

            $stub = str_replace([
                'DummyNamespace',
                'DummyRootNamespace',
                'DummyClass',
                'DummyFullModelClass',
                'DummyModelClass',
                'DummyModelVariable',
            ], [
                "App\\Modules\\" . trim($this->argument('name')) . "\\Controllers",
                $this->laravel->getNamespace(),
                $controller . 'Controller',
                "App\\Modules\\" . trim($this->argument('name')) . "\\Models\\" . $modelName,
                $modelName,
                lcfirst($modelName),
            ], $stub);


            $this->filesystem->put($path, $stub);
            $this->info('Controller created succesgully.');
            //$this->updateModularConfig()
        }
        $this->createRoutes($controller, $modelName);

    }

    private function createApiController() {
        $controller = Str::studly(class_basename($this->argument('name')));
        $modelName = Str::singular(Str::studly(class_basename($this->argument('name'))));

        $path = $this->getApiControllerPath($this->argument('name'));

        if ($this->alreadyExists($path)) {
            $this->error("Api Controller already exists");
        } else {
            $this->makeDirectory($path);

            $stub = $this->filesystem->get(base_path('resources/stubs/controller.stub'));

            $stub = str_replace([
                'DummyNamespace',
                'DummyRootNamespace',
                'DummyClass',
                'DummyFullModelClass',
                'DummyModelClass',
                'DummyModelVariable',
            ], [
                "App\\Modules\\" . trim($this->argument('name')) . "\\Controllers\\Api",
                $this->laravel->getNamespace(),
                $controller . 'Controller',
                "App\\Modules\\" . trim($this->argument('name')) . "\\Models\\" . $modelName,
                $modelName,
                lcfirst($modelName),
            ], $stub);


            $this->filesystem->put($path, $stub);
            $this->info('Controller created succesgully.');
            //$this->updateModularConfig()
        }
        $this->createApiRoutes($controller, $modelName);
    }

    private function createRoutes(string $controller, string $modelName) {
        $routePath = $this->getRoutesPath($this->argument('name'));
        if ($this->alreadyExists($routePath)) {
            $this->error("Route already exists");
        } else {
            $this->makeDirectory($routePath);
            $stub = $this->filesystem->get('resources/stubs/routes.web.stub');
            $stub = str_replace([

                'DummyClass',
                'DummyRoutePrefix',
                'DummyModelVariable',
            ], [
                $controller . 'Controller',
                Str::plural(Str::snake(lcfirst($modelName), '-')),
                lcfirst($modelName),
            ], $stub);

            $this->filesystem->put($routePath, $stub);
            $this->info("Routes created succesfully");
        }
    }

    private function createApiRoutes(string $controller, string $modelName) {
        $routePath = $this->getApiRoutesPath($this->argument('name'));
        if ($this->alreadyExists($routePath)) {
            $this->error("Route already exists");
        } else {
            $this->makeDirectory($routePath);
            $stub = $this->filesystem->get('resources/stubs/routes.web.stub');
            $stub = str_replace([

                'DummyClass',
                'DummyRoutePrefix',
                'DummyModelVariable',
            ], [
                $controller . 'Controller',
                Str::plural(Str::snake(lcfirst($modelName), '-')),
                lcfirst($modelName),
            ], $stub);

            $this->filesystem->put($routePath, $stub);
            $this->info("Routes created succesfully");
        }
    }

    private function createMigration() {
        $table = Str::plural(Str::snake(class_basename($this->argument('name'))));
        try {
            $this->call('make:migration', [
                'name' => "create_{$table}_table",
                '--create' => $table,
                '--path' => "App\\Modules\\" . trim($this->argument('name')) . "\\Migrations",
            ]);
        } catch (\Exception $ex) {
            $this->error($ex->getMessage());
        }

    }

    private function createVueComponent() {
        $path = $this->getVueComponentPath($this->argument('name'));

        $component = Str::studly(class_basename($this->argument('name')));

        if ($this->alreadyExists($path)) {
            $this->error('Vue component already exists!');
        } else {
            $this->makeDirectory($path);

            $stub = $this->filesystem->get(base_path('resources/stubs/vue.component.stub'));

            $stub = str_replace(
                [
                    'DummyClass',
                ],
                [
                    $component
                ],
                $stub
            );
            $this->files->put($path, $stub);
            $this->info('Vue component created succesfully!');
        }

    }
    private function createView()
    {
        $paths = $this->getViewPath($this->argument('name'));

        foreach ($paths as $path) {
            $view = Str::studly(class_basename($this->argument('name')));

            if ($this->alreadyExists($path)) {
                $this->error('View already exists!');
            } else {
                $this->makeDirectory($path);

                $stub = $this->filesystem->get(base_path('resources/stubs/view.stub'));

                $stub = str_replace(
                    [
                        '',
                    ],
                    [
                    ],
                    $stub
                );

                $this->filesystem->put($path, $stub);
                $this->info('View created successfully.');
            }
        }
    }

    protected function getVueComponentPath($name) : String
    {
        return base_path('resources/js/components/'.str_replace('\\', '/', $name).".vue");
    }

    protected function getViewPath($name) : object
    {

        $arrFiles = collect([
            'create',
            'edit',
            'index',
            'show',
        ]);

        //str_replace('\\', '/', $name)
        $paths = $arrFiles->map(function($item) use ($name){
            return base_path('resources/views/'.str_replace('\\', '/', $name).'/'.$item.".blade.php");
        });

        return $paths;
    }

    private function getControllerPath($moduleName) {
        $controller = Str::studly(class_basename($moduleName));
        return $this->laravel['path'] . '/Modules/' . str_replace('\\', '/', $moduleName) . "/Controllers/{$controller}Controller.php";
    }


    private function getApiControllerPath($moduleName) {
        $controller = Str::studly(class_basename($moduleName));
        return $this->laravel['path'] . '/Modules/' . str_replace('\\', '/', $moduleName) . "/Controllers/Api/{$controller}Controller.php";
    }

    private function makeDirectory(string $path) {
        if (!$this->filesystem->isDirectory(dirname($path))) {
            $this->filesystem->makeDirectory(dirname($path), 0755, true);
        }
        return $path;
    }


    private function getRoutesPath(string $moduleName) {
        return $this->laravel['path'] . '/Modules/' . str_replace('\\', '/', $moduleName) . "/Routes/web.php";
    }

    private function getApiRoutesPath(string $moduleName) {
        return $this->laravel['path'] . '/Modules/' . str_replace('\\', '/', $moduleName) . "/Routes/api.php";

    }

    private function alreadyExists(string $routePath) {
        return $this->filesystem->exists($routePath);
    }
}
