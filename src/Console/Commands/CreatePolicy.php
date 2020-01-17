<?php

namespace Anand\PackageTemplate\Console\Commands;

use Illuminate\Console\Command;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class CreatePolicy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:policy {name} {packageName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates Policy inside package.';

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

        try{
        if (!file_exists($this->path . $packageName . '/src/policies/' . $fileName . '.php')) {
            $this->info("================ Creating Policy ======================\n");

            $this->createPolicy($packageName, $fileName, __DIR__ . '/stubs/policy.plain.stub');

            $this->info("================ Policy Created Successfully ==========\n");
        } else {
            $this->error("================ Policy Already Exists. ======================");
        }
        }catch (\Exception $e){
            $this->log->error((string)$e);

            $this->error("================ Couldn't create Controller. ======================");
        }
    }

    private function createPolicy($packageName, $fileName, $stub)
    {
        $stub = file_get_contents($stub);
        $stub = str_replace(['DummyNamespace', 'DummyClass'], [getCamelCaseName($packageName) . '\policies', $fileName], $stub);
        $file = createFile($this->path . $packageName . '/src/policies/', $fileName);
        return file_put_contents($file, $stub);
    }
}
