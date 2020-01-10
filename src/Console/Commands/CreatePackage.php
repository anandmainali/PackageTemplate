<?php

namespace Anand\PackageTemplate\Console\Commands;

use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;

class CreatePackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:package {name : Enter package name.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a template for new package.';

    private $path;

    private $vendorName;
    /**
     * @var LoggerInterface
     */
    private $log;

    /**
     * Create a new command instance.
     * @param LoggerInterface $log
     */
    public function __construct(LoggerInterface $log)
    {
        parent::__construct();

        $this->vendorName = config('package.vendorName');

        $this->path = config('package.path') . '/' . $this->vendorName . '/';

        $this->log = $log;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $packageName = $this->argument('name');

        $folders = config('package.folders');

        $files = config('package.files');

        try {
            if (!file_exists($this->path . $packageName)) {

                $this->info("================ Creating Package ======================\n");

                if (!empty($folders)) {
                    foreach ($folders as $folder)
                        createFolder($this->path . $packageName . '/src/', $folder);
                }

                if (!empty($files)) {
                    foreach ($files as $file)
                        createFile($this->path . $packageName . '/src/', $file);
                }

                $this->createServiceProvider($packageName, __DIR__ . '/stubs/provider.stub');

                //creates composer.json file
                system('composer init --working-dir=' . $this->path . $packageName . ' --name=' . $this->vendorName . '/' . strtolower(getCamelCaseName($packageName)) . ' --description=' . getCamelCaseName($packageName) . '\' package\' --type=library --license=MIT --author=\'Author <info@author.com>\' -s dev');

                $this->info("================ Package Created Successfully ==========\n");
            } else {
                $this->error("================ Package Already Exists. ======================");
            }
            }catch(\Exception $e){
                $this->log->error((string)$e);

                $this->error("================ Couldn't Create Package. ======================");
            }
        }

    private function createServiceProvider($packageName, $stub)
    {
        $stub = file_get_contents($stub);
        $stub = str_replace(['DummyNamespace', 'DummyClass'], [getCamelCaseName($packageName), getCamelCaseName($packageName)], $stub);
        $file = createFile($this->path . $packageName . '/src/', getCamelCaseName($packageName) . 'ServiceProvider');
        return file_put_contents($file, $stub);
    }
}
