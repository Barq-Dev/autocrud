<?php 
namespace Barqdev\Autocrud\Console;

use Illuminate\Console\Command;

class UiCommand extends Command
{
    protected $signature = 'autocrud:ui {--c|components} {--a|all}';
    protected $description = 'Copying Vue UI';

    public function handle()
    {
        // $name = $this->argument('name');

        # code...
        // $this->call("make:model", [
        //     'name'=>$name,
        //     '-a'=>true
        // ]);
        if($this->option('components'))
            $this->call('vendor:publish', [
                '--tag'=>'autocrud-ui-vue-components',
                // '--force'=>true
            ]);
        elseif($this->option('all')){
            $this->call('vendor:publish', [
                '--tag'=>'autocrud-ui-vue',
                '--force'=>true
            ]);
            $this->info("run `npm install vue-router vuex @fortawesome/fontawesome-free material-design-icons-iconfont --save`");
        }
        // $this->call("make:request", [
        //     'name'=>$name."Request"
        // ]);
        
    }
}

?>