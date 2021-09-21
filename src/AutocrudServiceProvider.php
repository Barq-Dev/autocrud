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
        // git tag -a 1.4.0 -m "Releasing version v1.4.0"
        // git push origin 1.4.0   
        
        $this->publishList();
        $this->macroList();
    }

    public function register()
    {
        # code...
        $this->commands([
            Console\AuthCommand::class,
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
        ], 'autocrud-stub');

        $this->publishUI();
        $this->publishAuth();
        
        
    }

    public function publishUI()
    {
        $this->publishes([
            __DIR__.'/Resources/js/vue' => resource_path('js'),
        ], 'autocrud-ui-vue-init');

        $this->publishes([
            __DIR__.'/Resources/js/vue/assets/' => resource_path('js/assets/'),
            __DIR__.'/Resources/js/vue/components/' => resource_path('js/components/'),
            __DIR__.'/Resources/js/vue/layouts/' => resource_path('js/layouts/'),
            __DIR__.'/Resources/js/vue/plugins/' => resource_path('js/plugins/'),
            __DIR__.'/Resources/js/vue/router/' => resource_path('js/router/'),
            __DIR__.'/Resources/js/vue/store/' => resource_path('js/store/'),
            __DIR__.'/Resources/js/vue/views/' => resource_path('js/views/'),
            __DIR__.'/Resources/js/vue/app.js' => resource_path('js/app.js'),
            __DIR__.'/Resources/js/vue/App.vue' => resource_path('js/App.vue'),
        ], 'autocrud-ui-vue');

        // Partials
        $dirs = ['assets','components','layouts','plugins','router','store','views'];

        foreach ($dirs as $dir) {
            $this->publishes([
                __DIR__."/Resources/js/vue/$dir/" => resource_path("js/$dir/"),
            ], "autocrud-ui-vue-$dir");
        }
    }
    public function publishAuth()
    {
        $this->publishes([
            __DIR__.'/Controllers/auth/UserController.php' => app_path('Http/Controllers/UserController.php'),
            __DIR__.'/Requests/UserRequest.php' => app_path('Http/Requests/UserRequest.php'),
        ], 'autocrud-auth');

        $this->publishes([
            __DIR__.'/Controllers/auth/RoleController.php' => app_path('Http/Controllers/RoleController.php'),
            __DIR__.'/Requests/RoleRequest.php' => app_path('Http/Requests/RoleRequest.php'),
            __DIR__.'/Database/Seeder/RoleSeeder.php' => database_path('seeder/RoleSeeder.php'),
        ], 'autocrud-auth-acl');

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