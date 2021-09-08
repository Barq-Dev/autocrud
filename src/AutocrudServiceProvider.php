<?php 
namespace Barqdev\Autocrud;

use Illuminate\Support\ServiceProvider;

class AutocrudServiceProvider extends ServiceProvider{

    public function boot()
    {
        # code...
        // dd(123123);
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
    }
}

?>