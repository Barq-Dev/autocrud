<?php 
namespace Barqdev\Autocrud\Console;

use Illuminate\Console\Command;

class AuthCommand extends Command
{
    protected $signature = 'autocrud:auth {--o|only} {--a|acl} {--l|log}';
    protected $description = 'Initialize Laravel Autocrud Auth';

    public function handle()
    {
        if(!$this->option('only')){
            $this->call('vendor:publish', [
                '--tag'=>'autocrud-auth',
                '--force'=>true
            ]);
        }

        if($this->option('acl')){
            $this->call('vendor:publish', [
                '--tag'=>'autocrud-auth-acl',
                '--force'=>true
            ]);

            $this->info("run `composer require spatie/laravel-permission`");
            $this->warn('run `php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"`');
        }

        if($this->option('log')){
            $this->call('vendor:publish', [
                '--tag'=>'autocrud-auth-log',
                '--force'=>true
            ]);

            $this->info("run `composer require spatie/laravel-activitylog`");
            $this->warn('run `php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="migrations"`');
            $this->warn('then run `php artisan migrate`');
        }
        
    }
}

?>