<?php 
namespace Barqdev\Autocrud\Console;

use Illuminate\Console\Command;

class BaseCommand extends Command
{
    protected $signature = 'autocrud:modul {name}';
    protected $description = 'Making all necessery file (model, migration, controller, etc..)';

    public function handle()
    {
        $name = $this->argument('name');

        # code...
        $this->call("make:model", [
            'name'=>$name,
            '-a'=>true
        ]);
        $this->call("make:request", [
            'name'=>$name."Request"
        ]);
        
    }
}

?>