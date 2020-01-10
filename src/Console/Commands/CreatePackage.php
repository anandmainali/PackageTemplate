<?php

namespace Anand\PackageTemplate\Console\Commands;

use Illuminate\Console\Command;

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

    private $vendorName = "anand";

    private $path = "packages/anand/";

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $packageName = $this->argument('name');

        $folders = [
            'controllers', 'databases/migrations', 'models', 'policies', 'resources/views', 'routes'
        ];

        $files = [
            'routes/web',
        ];

        if (!file_exists($this->path . $packageName)) {

            $this->info("================ Creating Package ======================\n");

            foreach ($folders as $folder)
                createFolder($this->path . $packageName . '/src/', $folder);


            foreach ($files as $file)
                createFile($this->path . $packageName . '/src/', $file);

            $this->createServiceProvider($packageName, __DIR__ . '/stubs/provider.stub');

            //creates composer.json file
            system('composer init --working-dir=' . $this->path . $packageName . ' --name=' . $this->vendorName . '/' . $packageName . ' --description=' . ucfirst($packageName) . '\' package\' --type=library --license=MIT --author=\'Dummy <info@dummy.com>\' -s dev');

            $this->info("================ Package Created Successfully ==========\n");
        } else {
            $this->error("================ Package Already Exists. ======================");
        }
    }

    private function createServiceProvider($packageName, $stub)
    {
        $stub = file_get_contents($stub);
        $stub = str_replace(['DummyNamespace', 'DummyClass'], [$this->vendorName . '\\' . ucfirst($packageName), ucfirst($packageName)], $stub);
        $file = createFile($this->path . $packageName . '/src/', ucfirst($packageName) . 'ServiceProvider');
        return file_put_contents($file, $stub);
    }
}
