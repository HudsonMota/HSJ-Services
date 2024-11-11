<?php

namespace App\Http\Controllers;

use App\Authorizacao;
use App\Solicitacao;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Services\PdfGenerator;
use Illuminate\Support\Facades\Log;

class PdfController extends Controller
{
    /**
     * @var PdfGenerator
     */
    private $pdfGenerator;

    /**
     * PdfController constructor.
     *
     * @param PdfGenerator $pdfGenerator
     */
    public function __construct(PdfGenerator $pdfGenerator)
    {
        $this->pdfGenerator = $pdfGenerator;
    }

    /**
     * Gera PDF de solicitação.
     *
     * @param int $id
     * @return mixed
     */
    public function gerarPdf($id)
    {
        try {
            return $this->pdfGenerator->gerarPdfSolicitacao($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            // Retorne um erro ou uma resposta padrão
        }
    }

    /**
     * Gera PDF de autorização.
     *
     * @param int $id
     * @return mixed
     */
    public function gerarPdf1($id)
    {
        try {
            return $this->pdfGenerator->gerarPdfAutorizacao($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            // Retorne um erro ou uma resposta padrão
        }
    }
}
