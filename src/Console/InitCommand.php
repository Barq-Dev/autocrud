<?php 
namespace Barqdev\Autocrud\Console;

use Illuminate\Console\Command;

class InitCommand extends Command
{
    protected $signature = 'autocrud:stub';
    protected $description = 'Modifying controller & model stub';

    public function handle()
    {
        # code...
        $this->call('stub:publish');
        unlink(__DIR__.'/../../../../../stubs/model.stub');
        unlink(__DIR__.'/../../../../../stubs/controller.model.stub');
        $this->call('vendor:publish', [
            '--tag'=>'autocrud',
            '--force'=>true
        ]);
        
    }
}

?>