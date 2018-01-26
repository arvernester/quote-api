<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BackupDatabase as BackupDatabaseNotification;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup database via CLI and running using cron';

    /**
     * Create a new command instance.
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
        $directory = database_path('backup/');
        if (!File::isDirectory($directory)) {
            // user must create directory manually
            $this->error(sprintf('Directory %s is not exists.', $directory));
            exit;
        }

        $connection = 'database.connections.'.config('database.default').'.';
        $config = [
            '{host}' => config($connection.'host'),
            '{database}' => config($connection.'database'),
            '{user}' => config($connection.'username'),
            '{password}' => config($connection.'password'),
            '{port}' => config($connection.'port'),
            '{path}' => $directory.Carbon::parse()->now()->format('Y-m-d-H:i').'.sql',
        ];

        $command = str_replace(
            array_keys($config),
            $config,
            'mysqldump -h{host} -port{port} -u{user} -p{password} -e "{database}" > {path} 2>&1'
        );
        exec($command, $output, $return);

        $this->info($message = 'Database has been backed up to '.$config['{path}']);

        $users = User::all();
        Notification::send($users, new BackupDatabaseNotification($message));
    }
}
