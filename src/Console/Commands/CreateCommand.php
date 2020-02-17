<?php

namespace Anand\PackageTemplate\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class CreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:command {name : The name of the command} {--command= : The terminal command that should be assigned [default: "command:name"]} {packageName : Enter package name to create command inside that package}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new Artisan inside package.';

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
        $command = $this->option('command');
        $packageName = $this->argument('packageName');

        try {
            createFolder($this->path . $packageName . '/src/', 'Console/Commands');

            if (!file_exists($this->path . $packageName . '/src/Console/Commands/' . $fileName . '.php')) {
                $this->info("================ Creating Artisan Command ======================\n");

                    $this->createCommand($packageName, $fileName, $command, __DIR__ . '/stubs/console.stub');

                $this->info("================ Artisan Command Created Successfully ==========\n");
            } else {
                $this->error("================ Artisan Command Already Exists. ======================");
            }
        } catch (\Exception $e) {
            $this->log->error((string)$e);

            $this->error("================ Couldn't create Artisan Command. ======================");
        }
    }

    private function createCommand($packageName, $fileName, $command, $stub)
    {
        $stub = file_get_contents($stub);
        $stub = str_replace(['DummyNamespace', 'DummyClass','dummy:command'], [getCamelCaseName($packageName) . '\Console\Commands', $fileName, $command ?? 'command:name'], $stub);

        $file = createFile($this->path . $packageName . '/src/Console/Commands/', $fileName);
        return file_put_contents($file, $stub);
    }
}
