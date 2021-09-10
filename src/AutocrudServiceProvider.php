<?php 
namespace Barqdev\Autocrud;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class AutocrudServiceProvider extends ServiceProvider{

    public function boot()
    {
        # code...
        // git tag -a 1.0.1 -m "Releasing version v1.0.1"
        // git push origin 1.0.2   
        
        $this->publishes([
            __DIR__.'/Stubs/controller.model.stub' => __DIR__.'/../../../../stubs/controller.model.stub',
            __DIR__.'/Stubs/model.stub' => __DIR__.'/../../../../stubs/model.stub',
        ], 'autocrud');

        $this->publishes([
            __DIR__.'/Resources/js/vue/router' => __DIR__.'/../../../../resources/js/router',
            __DIR__.'/Resources/js/vue/layouts' => __DIR__.'/../../../../resources/js/layouts',
            __DIR__.'/Resources/js/vue/views' => __DIR__.'/../../../../resources/js/views',
            __DIR__.'/Resources/js/vue/App.vue' => __DIR__.'/../../../../resources/js/App.vue',
            __DIR__.'/Resources/js/vue/app.js' => __DIR__.'/../../../../resources/js/app.js',
        ], 'autocrud-ui-vue');
        
        Builder::macro('whereLike', function ($attributes, string $searchTerm) {            
            $this->where(function (Builder $query) use ($attributes, $searchTerm) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        Str::contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);
        
                            $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                                $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                            });
                        },
                        function (Builder $query) use ($attribute, $searchTerm) {
                            $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    );
                }
            });
        
            return $this;
        });
    }

    public function register()
    {
        # code...
        $this->commands([
            Console\InitCommand::class,
            Console\BaseCommand::class,
            Console\UiCommand::class,
        ]);
    }
}

?>