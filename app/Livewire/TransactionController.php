<?php

namespace App\Livewire;

use App\Exports\ExcelExport;
use App\Imports\TransactionImport;
use App\Models\ModelTableA;
use App\Models\ModelTableB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Component
{
    use WithFileUploads;
    public $transactions;
    public $toko;
    public $kode_toko = "", $nominal_transaksi;
    public $file;

    public function mount()
    {
        $this->getData();
    }

    public function getData()
    {
        $this->transactions = ModelTableB::all();
        $this->toko = ModelTableA::all();
    }

    public function store()
    {
        $this->validate();

        ModelTableB::create([
            'kode_toko' => $this->kode_toko,
            'nominal_transaksi' => $this->nominal_transaksi
        ]);

        $this->clearInput();
        $this->getData();
    }

    public function clearInput()
    {
        $this->kode_toko = "";
        $this->nominal_transaksi = "";
    }

    protected function rules()
    {
        return [
            'kode_toko' => 'required',
            'nominal_transaksi' => 'required|numeric'
        ];
    }

    public function exportExcel()
    {
        $this->getData();
        return Excel::download(new ExcelExport($this->transactions), 'transaction.xlsx');
    }

    public function downloadPDF()
    {
        $pdf = PDF::loadView('pdf.transaction', array('transaction' => $this->transactions))->setPaper('a4', 'portrait');
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'transactions.pdf');
    }

    public function updatedFile()
    {
        $excel = new TransactionImport;
        Excel::import($excel, $this->file);
        $this->getData();
    }

    public function render()
    {
        return view('livewire.transaction-controller');
    }
}
