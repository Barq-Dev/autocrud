<?php

namespace Barqdev\Autocrud;

use App\Exports\ViewExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Barqdev\Autocrud\Partials\LocalScopeTrait;

class AutoModel extends Model
{
    use LocalScopeTrait;
    // protected $appends = [];
    protected $files = [''];

    protected static function boot()
    {
        parent::boot();
        self::deleting(function ($model) {
            foreach ($model->getFiles() as $value) {
                Storage::delete('public/uploads/files/' . $model->$value);
            }
        });
    }

    public function getFileFotoAttribute()
    {
        return $this->foto ? Storage::url("uploads/files/$this->foto") : '/assets/img/default.jpg';
    }
    public function getFiles()
    {
        return $this->files;
    }
    public function getFileAttribute()
    {
        return $this->attributes[$this->files[0]] ?? null;
    }
    public function getFileLinkAttribute()
    {
        return $this->file ? Storage::url('uploads/files/' . $this->file) : null;
    }

    public function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    public function scopeSearch($query, $searchFields = [], $search)
    {
        if ($search)
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

    // Fungsi Konvensional
    public function export($model = null, $limit = null)
    {
        $data = $limit ? $this->take($limit)->get() : $this->filter(request())->get();

        $export['headers'] = $this->exportAttribute ?? array_keys($data->first()->getAttributes());
        $export['data'] = $data->toArray();

        // return $export;
        return Excel::download(new ViewExport($export, "exports.index"), "$model.xlsx");
    }

    public function import($rows, $headers)
    {
        $data = [];
        foreach ($rows as $key => $row) {

            foreach ($headers as $value) {
                $data[$key][$value] = $row[$value] ?? null;
            }
            $this->create($data[$key]);
        }
    }
}
