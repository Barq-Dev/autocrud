<?php

namespace Barqdev\Autocrud\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ViewExport implements FromView, ShouldAutoSize
{
    protected $export;

    public function __construct($export)
    {
        $this->export = $export;
    }
    public function collection()
    {
        return $this->data;
    }
    public function view(): View
    {
        return view('exports.index', [
            'export' => $this->export,
        ]);
    }
}
