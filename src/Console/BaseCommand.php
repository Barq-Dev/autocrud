<?php 
namespace Barqdev\Autocrud\Console;

use Illuminate\Support\Str;
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

        $this->routeResource($name);
        
    }

    public function routeResource($name)
    {
        # code...
        $file_dir = __DIR__."/../../../../../routes/api.php";
        $file = file($file_dir);
        $import_controller = 'use App\Http\Controllers\\'.$name.'Controller;'."\n";
        $route = "Route::resource('".str_replace('_', '-', Str::snake($name))."', ".$name."Controller::class);\n";

        $line = array_key_first(array_filter($file, function($q){
            return substr_count($q, 'Route;');
        }));
        array_splice($file, $line+1, 0, $import_controller);

        file_put_contents($file_dir, implode($file));
        file_put_contents($file_dir, $route, FILE_APPEND);

        $this->info('Route resource imported.');

    }
}

?>