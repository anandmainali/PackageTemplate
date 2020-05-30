<?php

namespace Anand\PackageTemplate\Console\Commands;

use Illuminate\Console\Command;
use Psr\Log\LoggerInterface;

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
        $fileName = date('Y_m_d_His', time()).$this->argument('fileName');
        $tableName = $this->argument('tableName');
        $packageName = $this->argument('packageName');

        try {
            createFolder($this->path . $packageName . '/src/', 'database/migrations');

            if (!file_exists($this->path . $packageName . '/src/database/migrations/' . $fileName . '.php')) {
                $this->info("================ Creating Migration ======================\n");

                $this->createMigration($packageName, $fileName, $tableName, __DIR__ . '/stubs/migration-create.stub');

                $this->info("================ Migration Created Successfully ==========\n");
            } else {
                $this->error("================ Migration Already Exists. ======================");
            }
        } catch (\Exception $e) {
            $this->log->error((string)$e);

            $this->error("================ Couldn't create Migration. ======================");
        }
    }


    private function createMigration($packageName, $fileName, $tableName, $stub)
    {
        $stub = file_get_contents($stub);
        $stub = str_replace(['DummyClass', 'DummyTable'], [$fileName, $tableName], $stub);
        $file = createFile($this->path . $packageName . '/src/database/migrations/', $fileName);
        return file_put_contents($file, $stub);
    }
}
