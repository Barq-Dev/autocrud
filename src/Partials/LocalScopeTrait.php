<?php
namespace Barqdev\Autocrud\Partials;

trait LocalScopeTrait {
    public function scopeSearch($query, $searchFields=[], $search)
    {
        if($search)
            return $query->whereLike($searchFields, $search);
    }
    public function scopeFilter($query, $request)
    {
        return $query;
    }
    public function scopeFormat($query, $request)
    {
        return $query;
    }
}