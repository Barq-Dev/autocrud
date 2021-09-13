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
        
        $this->publishList();
        $this->macroList();
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

    public function publishList()
    {
        # code...
        $this->publishes([
            __DIR__.'/Stubs/controller.model.stub' => __DIR__.'/../../../../stubs/controller.model.stub',
            __DIR__.'/Stubs/model.stub' => __DIR__.'/../../../../stubs/model.stub',
        ], 'autocrud');

        // $this->publishes([
        //     __DIR__.'/Resources/js/vue' => resource_path('js'),
        // ], 'autocrud-ui-vue');

        $this->publishes([
            __DIR__.'/Resources/js/vue/components/' => resource_path('js/components/'),
            __DIR__.'/Resources/js/vue/layouts/' => resource_path('js/layouts/'),
            __DIR__.'/Resources/js/vue/router/' => resource_path('js/router/'),
            __DIR__.'/Resources/js/vue/store/' => resource_path('js/store/'),
            __DIR__.'/Resources/js/vue/views/' => resource_path('js/views/'),
            __DIR__.'/Resources/js/vue/app.js' => resource_path('js/app.js'),
            __DIR__.'/Resources/js/vue/App.vue' => resource_path('js/App.vue'),
            __DIR__.'/Resources/js/vue/axios.js' => resource_path('js/axios.js'),
            __DIR__.'/Resources/js/vue/vuetify.js' => resource_path('js/vuetify.js'),
        ], 'autocrud-ui-vue');
    }

    public function macroList()
    {
        # code...
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
}

?>