<?php 
namespace Barqdev\Autocrud\Console;

use Illuminate\Console\Command;

class UiCommand extends Command
{
    protected $signature = 'autocrud:ui 
        {--i|init} {--a|all} {--assets} {--c|components} {--l|layouts}
        {--p|plugins} {--r|router} {--s|store} {--views}
    ';
    protected $description = 'Copying Vue UI';

    public function handle()
    {
        if($this->option('all')){
            $this->call('vendor:publish', [
                '--tag'=>'autocrud-ui-vue',
                '--force'=>true
            ]);
            $this->warn("run `npm i vue-router vuex @fortawesome/fontawesome-free material-design-icons-iconfont vue-sweetalert2 --save`");
        }
        if($this->option('init')){
            $this->call('vendor:publish', [
                '--tag'=>'autocrud-ui-vue-init',
                '--force'=>true
            ]);
            $this->warn("run `npm i vue-router vuex @fortawesome/fontawesome-free material-design-icons-iconfont vue-sweetalert2 --save`");
        }

        // Partials
        $dirs = ['assets','components','layouts','plugins','router','store','views'];

        foreach ($dirs as $dir) {
            if($this->option($dir))
                $this->call('vendor:publish', [
                    '--tag'=>"autocrud-ui-vue-$dir",
                    '--force'=>true
                ]);    
        }
        
    }
}

?>