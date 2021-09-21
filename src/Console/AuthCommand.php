<?php 
namespace Barqdev\Autocrud\Console;

use Illuminate\Console\Command;

class AuthCommand extends Command
{
    protected $signature = 'autocrud:auth {--a|acl}';
    protected $description = 'Initialize Laravel Autocrud Auth';

    public function handle()
    {

        $this->call('vendor:publish', [
            '--tag'=>'autocrud-auth',
            '--force'=>true
        ]);

        if($this->option('acl')){
            $this->call('vendor:publish', [
                '--tag'=>'autocrud-auth-acl',
                '--force'=>true
            ]);

            $this->info("run `composer require spatie/laravel-permission`");
        }
        
    }
}

?>