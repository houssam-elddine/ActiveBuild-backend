<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BonFabrication;

class BonFabricationController extends Controller
{
    public function pdf(BonFabrication $bon)
    {
        $pdf = Pdf::loadView('pdf.bon_fabrication', [
            'bon' => $bon
        ]);

        return $pdf->download('bon_fabrication_'.$bon->id.'.pdf');
    }
}

