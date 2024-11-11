<?php

//Serviço de geração de PDF
namespace App\Services;

use Barryvdh\DomPDF\Facade as PDF;
use App\Solicitacao;
use App\Authorizacao;
use App\Driver;
use App\Sector;
use App\User;
use Illuminate\Support\Facades\Log;

class PdfGenerator
{

    // Adicione um método para lidar com erros de forma mais genérica
    private function handleException(\Exception $e)
    {
        Log::error($e->getMessage());
        return response()->json(['error' => $e->getMessage()], 404);
    }



    public function gerarPdfSolicitacao($id)
    {
        try {
            // Busque os dados necessários
            $solicitacao = Solicitacao::find($id);

            if (!$solicitacao) {
                throw new \Exception('Solicitação não encontrada ou inválida');
            }

            // Busque os setores, usuários e técnicos relacionados
            $sectors = Sector::all();
            $users = User::all();
            $drivers = Driver::all();
            $authorization = null;

            if (in_array($solicitacao->statussolicitacao, ['PENDENTE', 'ATRIBUIDO', 'REALIZADO'])) {
                // Busque a autorização relacionada
                $authorization = Authorizacao::where('itinerary', $solicitacao->grouprequest)->first();
                if (!$authorization) {
                    throw new \Exception('Autorização não encontrada');
                }
            }

            // Crie um array com os dados necessários
            $data = [
                'solicitacao' => $solicitacao,
                'sectors' => $sectors,
                'users' => $users,
                'drivers' => $drivers,
                'authorization' => $authorization ?? null,
                'statussolicitacao' => $solicitacao->statussolicitacao,
            ];

            // Gere o PDF
            $pdf = PDF::loadView('request-vehicle-pdf', $data);

            return $pdf->setPaper('a4')->stream('request.pdf');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $this->handleException($e);
        }
    }



    // Faça o mesmo para o método gerarPdfAutorizacao
    public function gerarPdfAutorizacao($id)
    {
        try {
            // Busque os dados necessários
            $authorization = Authorizacao::find($id);
            if (!$authorization) {
                throw new \Exception('Autorização não encontrada');
            }
            // Busque os dados relacionados
            $solicitacoes = Solicitacao::where('grouprequest', $authorization->itinerary)->get();
            $solicitacao = $solicitacoes->first(); // Pega a primeira solicitação
            $users = User::all();
            $sectors = Sector::all();
            $drivers = Driver::all();

            // Crie um array com os dados necessários
            $data = [
                'authorization' => $authorization,
                'solicitacao' => $solicitacao,
                'users' => $users,
                'sectors' => $sectors,
                'drivers' => $drivers,
                'statusauthorization' => $authorization->statusauthorization,
            ];

            // Gere o PDF
            $pdf = PDF::loadView('authorization-pdf', $data);
            return $pdf->setPaper('a4')->stream('authorizer.pdf');
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }
}
