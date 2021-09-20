<?php 
namespace Barqdev\Autocrud\Console;

use Illuminate\Console\Command;

class UiCommand extends Command
{
    protected $signature = 'autocrud:ui {--c|components} {--s|store} {--a|all}';
    protected $description = 'Copying Vue UI';

    public function handle()
    {
        // $name = $this->argument('name');

        # code...
        if($this->option('components'))
            $this->call('vendor:publish', [
                '--tag'=>'autocrud-ui-vue-components',
                '--force'=>true
            ]);

        if($this->option('store'))
            $this->call('vendor:publish', [
                '--tag'=>'autocrud-ui-vue-store',
                '--force'=>true
            ]);

        if($this->option('all')){
            $this->call('vendor:publish', [
                '--tag'=>'autocrud-ui-vue',
                '--force'=>true
            ]);
            $this->info("run `npm i vue-router vuex @fortawesome/fontawesome-free material-design-icons-iconfont vue-sweetalert2 --save`");
        }
        // $this->call("make:request", [
        //     'name'=>$name."Request"
        // ]);
        
    }
}

?>