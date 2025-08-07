<?php

namespace App\Livewire;

use App\Exports\ExcelExport;
use App\Imports\SalesImport;
use App\Models\ModelTableC;
use App\Models\ModelTableD;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesController extends Component
{
    use WithFileUploads;
    public $area_sales;
    public $nama_sales = "", $kode_sales = "";
    public $sales, $selectedSales;
    public $file;

    public function mount()
    {
        $this->getData();
    }

    public function getData()
    {
        $this->area_sales = ModelTableC::select('area_sales')
            ->distinct()
            ->pluck('area_sales');
        $this->sales = ModelTableD::all();
    }

    public function store()
    {
        $this->validate();

        $kode_sales = $this->createKodeSales();

        ModelTableD::create([
            'kode_sales' => $kode_sales,
            'nama_sales' => $this->nama_sales
        ]);

        $this->clearInput();
        $this->getData();
    }

    protected function rules()
    {
        return [
            'nama_sales' => 'required|string|max:255',
            'kode_sales' => 'required'
        ];
    }

    public function update()
    {
        $this->selectedSales->update([
            'nama_sales' => $this->nama_sales
        ]);
        $this->clearInput();
        $this->getData();
    }

    public function toggleUpdate($kode_sales)
    {
        $this->selectedSales = ModelTableD::where('kode_sales', $kode_sales)->first();
        if ($this->selectedSales) {
            $this->nama_sales = $this->selectedSales->nama_sales;
        }
    }

    public function destroy($kode_sales)
    {
        $this->selectedSales = ModelTableD::where('kode_sales', $kode_sales)->first();
        if ($this->selectedSales) {
            $this->selectedSales->delete();
            $this->getData();
        }
    }

    private function createKodeSales()
    {
        do {
            // Get latest kode_sales starting with "A"
            $latestKode = ModelTableD::where('kode_sales', 'like', $this->kode_sales . '%')
                ->orderByRaw('CAST(SUBSTRING(kode_sales, 2) AS UNSIGNED) DESC')
                ->value('kode_sales');

            $nextNumber = $latestKode ? ((int) substr($latestKode, 1)) + 1 : 1;
            $nextKode = $this->kode_sales . $nextNumber;

            // Check if it already exists (just in case)
            $exists = ModelTableD::where('kode_sales', $nextKode)->exists();
        } while ($exists);
        return $nextKode;
    }

    public function clearInput()
    {
        $this->nama_sales = "";
        $this->kode_sales = "";
    }

    public function exportExcel()
    {
        $this->getData();
        return Excel::download(new ExcelExport($this->sales), 'sales.xlsx');
    }

    public function downloadPDF()
    {
        $sales = ModelTableD::all();
        $pdf = PDF::loadView('pdf.sales', array('sales' => $sales))->setPaper('a4', 'portrait');
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'sales.pdf');
    }

    public function updatedFile()
    {
        $excel = new SalesImport;
        Excel::import($excel, $this->file);
        $this->getData();
    }

    public function render()
    {
        return view('livewire.sales-controller');
    }
}
