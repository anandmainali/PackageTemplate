<?php

namespace Anand\PackageTemplate\Console\Commands;

use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;

class CreateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:model {name} {packageName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates model inside package';

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

        try {
            if (!file_exists($this->path . $packageName . '/src/models/' . $fileName . '.php')) {
                $this->info("================ Creating Model ======================\n");

                $this->createModel($packageName, $fileName, __DIR__ . '/stubs/model.stub');

                $this->info("================ Model Created Successfully ==========\n");
            } else {
                $this->error("================ Model Already Exists. ======================");
            }
        } catch (\Exception $e) {
            $this->log->error((string)$e);

            $this->error("================ Couldn't create Model. ======================");
        }
    }

    private function createModel($packageName, $fileName, $stub)
    {
        $stub = file_get_contents($stub);
        $stub = str_replace(['DummyNamespace', 'DummyClass'], [getCamelCaseName($packageName) . '\models', $fileName], $stub);
        $file = createFile($this->path . $packageName . '/src/models/', $fileName);
        return file_put_contents($file, $stub);
    }
}
