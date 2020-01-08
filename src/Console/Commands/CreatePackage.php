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
    protected $description = 'Creates a new package for RaraCMS.';
    /**
     * @var LoggerInterface
     */
    private $log;

    private $path = "packages/raracms/";

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
        $packageName = $this->argument('name');

        $bladePath = 'resources/views';

        $folders = [
            'controllers', 'databases/migrations', 'models', 'policies', $bladePath, 'routes'
        ];

        $files = [
            'routes/cms',
            ucfirst($packageName) . 'Permission',
            $bladePath.'/create.blade',
            $bladePath.'/edit.blade',
            $bladePath.'/form.blade',
            $bladePath.'/index.blade',
        ];

        if (!file_exists($this->path . $packageName)) {

            $this->info("================ Creating Package ======================\n");

            foreach ($folders as $folder)
                createFolder($this->path.$packageName . '/src/' ,$folder);

            foreach ($files as $file)
                createFile($this->path.$packageName . '/src/',$file);

            $this->createServiceProvider($packageName,__DIR__.'/stubs/provider.stub');
            //creates composer.json file
//            system('composer init --working-dir=' . $this->path . $packageName . ' --name=raracms/' . $packageName . ' --description=' . ucfirst($packageName) . '\' module for RaraCMS V2\' --type=library --license=SoftNEP --author=\'SoftNEP <info@softnep.com>\' -s dev --require=\'spatie/laravel-permission\':\'dev-master\'');

            $this->info("================ Package Created Successfully ==========\n");
        } else {
            $this->error("================ Package Already Exists. ======================");
        }
    }

    private function createServiceProvider($packageName,$stub)
    {
        $stub = file_get_contents($stub);
        $stub = str_replace(['DummyNamespace','DummyClass'],['RaraCMS\\'.ucfirst($packageName),ucfirst($packageName)],$stub);
        $file = createFile($this->path.$packageName.'/src/',ucfirst($packageName).'ServiceProvider');
        return file_put_contents($file,$stub);
    }
}


