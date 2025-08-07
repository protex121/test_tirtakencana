<?php

namespace App\Livewire;

use App\Exports\ExcelExport;
use App\Exports\TokoExport;
use App\Imports\TokoImport;
use App\Models\ModelTableA;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;


class TokoController extends Component
{
    use WithFileUploads;

    public $nama_toko = "";
    public $toko = [];
    public $selectedToko;
    public $file;

    public function mount()
    {
        $this->getData();
    }

    public function getData()
    {
        $this->toko = ModelTableA::all();
    }

    public function store()
    {
        $this->validate();
        $kode_toko_baru = ModelTableA::max('kode_toko_baru');
        do {
            $kode_toko_baru++;
            $kode_toko_lama = ModelTableA::where('kode_toko_lama', $kode_toko_baru)->first();
            if (!$kode_toko_lama) {
                break;
            }
        } while (true);

        $newToko = ModelTableA::create([
            'kode_toko_baru' => $kode_toko_baru,
            'kode_toko_lama' => null,
            'nama_toko' => $this->nama_toko
        ]);

        $this->clearInput();
        $this->getData();
    }

    public function update()
    {
        $this->selectedToko->update([
            'nama_toko' => $this->nama_toko
        ]);

        $this->getData();
    }

    public function toggleUpdate($kode_toko_baru)
    {
        $this->selectedToko = ModelTableA::where('kode_toko_baru', $kode_toko_baru)->firstOrFail();
        $this->nama_toko = $this->selectedToko->nama_toko;
    }

    public function destroy($kode_toko_baru)
    {
        $del_toko = ModelTableA::where('kode_toko_baru', $kode_toko_baru)->firstOrFail();
        $del_toko->delete();
        $this->getData();
    }

    private function clearInput()
    {
        $this->nama_toko = '';
    }

    protected function rules()
    {
        return [
            'nama_toko' => 'required|string|max:255'
        ];
    }

    public function exportExcel()
    {
        $this->getData();
        return Excel::download(new excelExport($this->toko), 'toko.xlsx');
    }

    public function downloadPDF()
    {
        $toko = ModelTableA::all();
        $pdf = PDF::loadView('pdf.toko', array('toko' => $toko))->setPaper('a4', 'portrait');
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'toko.pdf');
    }

    public function updatedFile()
    {
        $excel = new TokoImport;
        Excel::import($excel, $this->file);
        $this->getData();
    }

    public function render()
    {
        return view('livewire.toko-controller');
    }
}
