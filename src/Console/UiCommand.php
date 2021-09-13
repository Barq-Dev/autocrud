<?php 
namespace Barqdev\Autocrud\Console;

use Illuminate\Console\Command;

class UiCommand extends Command
{
    protected $signature = 'autocrud:ui';
    protected $description = 'Copying Vue UI';

    public function handle()
    {
        // $name = $this->argument('name');

        # code...
        // $this->call("make:model", [
        //     'name'=>$name,
        //     '-a'=>true
        // ]);
        $this->call('vendor:publish', [
            '--tag'=>'autocrud-ui-vue',
            '--force'=>true
        ]);
        $this->info("run `npm install");
        // $this->call("make:request", [
        //     'name'=>$name."Request"
        // ]);
        
    }
}

?>