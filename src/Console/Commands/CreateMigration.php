<?php

namespace Anand\PackageTemplate\Console\Commands;

use Illuminate\Console\Command;

class CreateMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:migration {fileName} {tableName} {packageName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates Migration file.';

    private $path = 'packages/raracms/';

    /**
     * Create a new command instance.
     *
     * @return void
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
        $fileName = $this->argument('fileName');
        $tableName = $this->argument('tableName');
        $packageName = $this->argument('packageName');

        if (!file_exists($this->path . $packageName.'/src/databases/migrations/'.$fileName.'.php')) {
            $this->info("================ Creating Migration ======================\n");

            $this->createMigration($packageName,$fileName,$tableName,__DIR__.'/stubs/migration-create.stub');

            $this->info("================ Migration Created Successfully ==========\n");
        } else {
            $this->error("================ Migration Already Exists. ======================");
        }
    }


    private function createMigration($packageName,$fileName,$tableName,$stub)
    {
        $stub = file_get_contents($stub);
        $stub = str_replace(['DummyClass','DummyTable'],[$fileName,$tableName],$stub);
        $file = createFile($this->path.$packageName.'/src/databases/migrations/',$fileName);
        return file_put_contents($file,$stub);
    }
}
