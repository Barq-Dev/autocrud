<?php

namespace Barqdev\Autocrud;

use ReflectionClass;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

trait AutoBase
{
    protected $model;
    protected $request;
    protected $data = [];
    protected $searchFields = [];

    public function init($varBefore = [], $varAfter = [])
    {
        // Requeired / Before default init
        foreach ($varBefore as $key => $value) {
            $this->$key = $value;
        }

        $this->path = 'app';
        $reflection = new ReflectionClass($this->model);
        $this->module = Str::snake($reflection->getShortName());

        // After default init
        foreach ($varAfter as $key => $value) {
            $this->$key = $value;
        }
    }

    public function index()
    {

        $request = request();
        $query = [
            'sortby' => $request->sortby ?? 'created_at',
            'sortbydesc' => $request->sortbydesc ?? 'desc',
            'per_page' => $request->per_page == 'undefined' || !$request->per_page ? 10 : $request->per_page,
            'q' => $request->q ?? '',
            'groupBy' => $request->groupBy ?? '',
        ];

        $data = $this->model
            ->with($this->with('index'))
            ->filter($request)
            ->orderBy($query['sortby'], $query['sortbydesc'])
            ->search($this->searchFields, $query['q'])
            ->when($query['groupBy'], function ($q) use ($query) {
                return $q->groupBy($query['groupBy']);
            })
            ->when(
                $request->all || $request->per_page == -1,
                function ($q) use ($request) {
                    return $request->pluck ?
                        $q->pluck(...$request->pluck) : $q->get();
                },
                function ($q) use ($query) {
                    return $q->paginate($query['per_page'] ?? 10);
                },
            );

        return $this->json($data);
    }

    // Additional or custom saving scheme. redefine in controller
    public function scheme()
    {
        $request = request();
        $request = $this->customRequestData($request)->all();

        $this->customValidate();

        $data = $this->model->updateOrCreate(['id' => $request['id'] ?? null], $request);

        return $this->callbackAfterStoreOrUpdate($data, $request);
    }

    public function store()
    {
        try {
            return $this->json($this->scheme());
        } catch (\Exception $ex) {
            if ($ex->status ?? false == 422)
                return response($ex->errors(), 405);
            return response(['error' => $ex->getMessage()], 405);
        }
    }

    public function update()
    {
        try {
            return $this->json($this->scheme());
        } catch (\Exception $ex) {
            if ($ex->status ?? false == 422)
                return response($ex->errors(), 405);
            return response(['error' => $ex->getMessage()], 405);
        }
    }

    public function show($id)
    {
        $data = $this->model;
        $data = $data->with($this->with('show'));
        $data = $data->format(request())->find($id);
        $data = $this->customJsonData($data);

        return $this->json($data);
    }

    public function destroy($id)
    {

        if (request()->forceDelete == 'restore') {
            $model = $this->model->withTrashed()->find($id)->restore();
        } elseif (request()->forceDelete)
            $model = $this->model->withTrashed()->find($id)->forceDelete();
        else {
            $model = request()->selected ? $this->model : $this->model->find($id);

            try {
                request()->selected ?
                    $model->destroy(request()->selected) : $model->delete();
            } catch (\Throwable $th) {
                $nama = $model->nama ? $model->nama : $model->name ?? 'item id ' . $model->id;
                return $this->json(['status' => false, 'content' => 'Gagal! ' . ucfirst($nama) . ' Masih Memiliki Data Terkait! Code:' . $th->getCode()]);
            }
        }
        return $this->json($model);
    }

    public function with($localWith)
    {
        $with = [];

        // Define with in controller
        if (isset($this->with)) {
            $globalWith = isset($this->with['global'])
                ? $this->with['global']
                : [];
            $localWith = isset($this->with[$localWith])
                ? $this->with[$localWith]
                : [];
            $with = array_unique(array_merge($globalWith, $localWith));
        }

        // Define with in request
        if (request()->with) {
            $requestWith = is_array(request()->with)
                ? request()->with
                : [request()->with];
            $with = array_unique(array_merge($requestWith, $with));
        }

        return $with;
    }

    public function callbackAfterStoreOrUpdate($data, $request = null)
    {
        return $data;
    }

    public function customRequestData($request)
    {
        return $request;
    }

    public function customJsonData($data)
    {
        return $data;
    }

    public function appends($data)
    {
        return $data;
    }
    public function json($data)
    {
        return response()->json($this->appends($data));
    }

    public function customValidate()
    {
        Validator::make(
            request()->all(),
            $this->request->rules(),
            $this->request->messages(),
            $this->request->attributes()
        )->validate();
    }

    public function generateUniqueFileName($file)
    {
        $symbols = ['.', ' ', '+', '-'];
        $symobls2 = ['(', ')'];

        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        $fileName = pathinfo($originalName, PATHINFO_FILENAME);
        $fileName = str_replace($symbols, '_', $fileName);
        $fileName = str_replace($symobls2, '', $fileName);
        $fileName .= '_' . md5(time()) . '_' . rand(000, 999) . '.';
        $fileName .= $extension;

        return $fileName;
    }

    public function upload($directory, $file, $oldFileName = '')
    {
        if (!$file) return '';
        if (is_string($file)) return $file;
        if ($oldFileName) $this->deleteFile($directory, $oldFileName);

        $fileName = $this->generateUniqueFileName($file);

        $targetPath = "public/uploads/{$directory}";
        Storage::makeDirectory("uploads/{$directory}");
        Storage::putFileAs($targetPath, $file, $fileName);

        return $fileName;
    }

    public function deleteFile($directory, $fileName)
    {
        return Storage::delete('public/uploads/' . $directory . '/' . $fileName);
    }

    public function currencyToInt($value, $request = null)
    {
        if (is_array($value)) {
            $request = $request ?? request();
            foreach ($value as $key => $val) {
                if ($request[$val] ?? false)
                    $request[$val] = str_replace([','], '', $request[$val]);
            }
            return $request;
        }
        return str_replace([','], '', $value);
    }
}
