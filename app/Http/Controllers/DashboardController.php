<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard-pkl');
    }

    public function cetakPenjajakan()
    {
        return view('cetak-surat-penjajakan');
    }

    public function cetakPenempatan()
    {
        return view('cetak-surat-penempatan');
    }

    public function prosesCetakPenjajakan(Request $request)
    {
        $data = $request->all();

        // Generate PDF using DomPDF
        $pdf = Pdf::loadView('surat-penjajakan-template', $data);

        return $pdf->download('surat-penjajakan.pdf');
    }

    public function prosesCetakPenempatan(Request $request)
    {
        $data = $request->all();

        // Generate PDF using DomPDF
        $pdf = Pdf::loadView('surat-penempatan-template', $data);

        return $pdf->download('surat-penempatan.pdf');
    }
}
