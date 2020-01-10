<?php

namespace Anand\PackageTemplate\Console\Commands;

use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;

class CreateController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:controller {name : Provide Controller Name} {packageName : Enter package name to create file inside that package.} {--r : Creates controller with resource.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates Controller inside the package.';

    private $path;
    /**
     * @var LoggerInterface
     */
    private $log;

    /**
     * Create a new command instance.
     *
     * @param LoggerInterface $log
     */
    public function __construct(LoggerInterface $log)
    {
        parent::__construct();

        $this->path = config('package.path') . '/' . config('package.vendorName') . '/';
        $this->log = $log;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fileName = $this->argument('name');
        $packageName = $this->argument('packageName');
        $resource = $this->option('r');

        try {
            if (!file_exists($this->path . $packageName . '/src/controllers/' . $fileName . '.php')) {
                $this->info("================ Creating Controller ======================\n");

                if ($resource) {
                    $this->createController($packageName, $fileName, __DIR__ . '/stubs/resource-controller.stub');
                } else {
                    $this->createController($packageName, $fileName, __DIR__ . '/stubs/controller.plain.stub');
                }

                $this->info("================ Controller Created Successfully ==========\n");
            } else {
                $this->error("================ Controller Already Exists. ======================");
            }
        }catch (\Exception $e){
            $this->log->error((string)$e);

            $this->error("================ Couldn't create Controller. ======================");
        }
    }

    private function createController($packageName, $fileName, $stub)
    {
        $stub = file_get_contents($stub);
        $stub = str_replace(['DummyNamespace', 'DummyClass'], [getCamelCaseName($packageName) . '\controllers', $fileName], $stub);
        $file = createFile($this->path . $packageName . '/src/controllers/', $fileName);
        return file_put_contents($file, $stub);
    }
}
