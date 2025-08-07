<?php

namespace App\Livewire;

use App\Exports\ExcelExport;
use App\Imports\AreaSalesImport;
use App\Models\ModelTableA;
use App\Models\ModelTableC;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;

class AreaSalesController extends Component
{
    use WithFileUploads;
    public $toko;
    public $area_sales; // for collection

    public $kode_toko = "", $area_sales_name = "";
    public $selectedAreaSales;
    public $file;
    protected $messages = [
        'area_sales_name.regex' => 'Area sales name must be a single uppercase letter (A–Z).',
    ];

    public function mount()
    {
        $this->getData();
    }

    private function getData()
    {
        $this->toko = ModelTableA::all();
        $this->area_sales = ModelTableC::all();
    }

    public function store()
    {
        $this->validate();

        ModelTableC::create([
            'kode_toko' => $this->kode_toko,
            'area_sales' => $this->area_sales_name
        ]);

        $this->getData();
        $this->clearInput();
    }

    public function clearInput()
    {
        $this->kode_toko = "";
        $this->area_sales_name = "";
    }

    public function toggleUpdate($area_sales)
    {
        $this->selectedAreaSales = ModelTableC::where('kode_toko', $area_sales['kode_toko'])->where('area_sales', $area_sales['area_sales'])->firstOrFail();
        $this->kode_toko = $this->selectedAreaSales->kode_toko;
        $this->area_sales_name = $this->selectedAreaSales->area_sales;
    }

    public function update()
    {
        if ($this->selectedAreaSales) {
            $this->selectedAreaSales->update([
                'kode_toko' => $this->kode_toko,
                'area_sales' => $this->area_sales_name
            ]);
            $this->getData();
            $this->clearInput();
        }
    }

    public function destroy($area_sales)
    {
        $data = json_decode($area_sales);
        $del_area_sales = ModelTableC::where('kode_toko', $data->kode_toko)->where('area_sales', $data->area_sales)->firstOrFail();
        $del_area_sales->delete();
        $this->getData();
    }

    protected function rules()
    {
        return [
            'area_sales_name' => ['required', 'string', 'regex:/^[A-Z]$/']
        ];
    }

    public function exportExcel()
    {
        $this->getData();
        return Excel::download(new ExcelExport($this->area_sales), 'area_sales.xlsx');
    }

    public function downloadPDF()
    {
        $pdf = PDF::loadView('pdf.area_sales', array('area_sales' => $this->area_sales))->setPaper('a4', 'portrait');
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'area_sales.pdf');
    }

    public function updatedFile()
    {
        $excel = new AreaSalesImport;
        Excel::import($excel, $this->file);
        $this->getData();
    }

    public function render()
    {
        return view('livewire.area-sales-controller');
    }
}
