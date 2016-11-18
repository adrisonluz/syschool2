<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\App;

class GeraPDF extends Model
{
    public function gerarPDF() {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<h1>Test</h1>');
        return $pdf->stream();
    }
}
