<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardController extends Controller
{
    /* INDEX */
    public function index()
    {

        // Dados das solicitações aguardando
        $vehiclerequests = DB::table('vehiclerequests')
            ->leftJoin('sectors', 'vehiclerequests.setorsolicitante', '=', 'sectors.cc')
            ->leftJoin('users', 'vehiclerequests.solicitante', '=', 'users.id')
            ->select(
                'vehiclerequests.id as id',
                'vehiclerequests.admfin as admfin',
                'datasaida as datasaida',
                'horasaida as horasaida',
                'sectors.cc as setor_cc',
                'sectors.sector as setor_nome',
                'users.name as solicitante',
                'vehiclerequests.updated_at as datahora',
                DB::raw("NULL as tecnico"),
                DB::raw("'AGUARDANDO' as status_type"),
            )
            ->where('statussolicitacao', 'AGUARDANDO')
            ->orderBy('datasaida', 'desc')
            ->orderBy('horasaida', 'desc')
            ->get(); // Adicionado o get() aqui também


        // Dados dos roteiros autorizados
        $scriptsauthorizeds = DB::table('authorizerequests')
            ->leftJoin('drivers', 'authorizerequests.driver', '=', 'drivers.id')
            ->leftJoin('vehiclerequests', 'authorizerequests.arr_requests_in_script', '=', 'vehiclerequests.id')
            ->leftJoin('sectors', 'vehiclerequests.setorsolicitante', '=', 'sectors.cc')
            ->leftJoin('users', 'vehiclerequests.solicitante', '=', 'users.id')
            ->select(
                'authorizerequests.id as id',
                'authorized_departure_date as datasaida',
                'authorized_departure_time as horasaida',
                'authorizer',
                'statusauthorization as statussolicitacao',
                'drivers.name_driver as tecnico',
                'users.name as solicitante',
                'sectors.cc as setor_cc',
                'sectors.sector as setor_nome',
                'vehiclerequests.admfin as admfin',
                'vehiclerequests.updated_at as datahora',
                DB::raw("'ATRIBUIDO' as status_type")
            )
            ->where('statusauthorization', 'ATRIBUIDO')
            ->orderBy('authorized_departure_date', 'desc')
            ->orderBy('authorized_departure_time', 'desc')
            ->get();

        // Capturando os registros PENDENTE
        $pendingRequests = DB::table('vehiclerequests')
            ->leftJoin('sectors', 'vehiclerequests.setorsolicitante', '=', 'sectors.cc')
            ->leftJoin('users', 'vehiclerequests.solicitante', '=', 'users.id')
            ->select(
                'vehiclerequests.id as id',
                'vehiclerequests.admfin as admfin',
                'datasaida as datasaida',
                'horasaida as horasaida',
                'sectors.cc as setor_cc',
                'sectors.sector as setor_nome',
                'users.name as solicitante',
                'vehiclerequests.updated_at as datahora',
                DB::raw("NULL as tecnico"),
                DB::raw("'PENDENTE' as status_type")
            )
            ->where('statussolicitacao', 'PENDENTE') // Apenas PENDENTE
            ->orderBy('datasaida', 'desc')
            ->orderBy('horasaida', 'desc')
            ->get(); // Adicionado o get() aqui

        // Combina os dados
        $combinedData = $scriptsauthorizeds->concat($pendingRequests)->concat($vehiclerequests)
            ->sort(function ($a, $b) {
                return ($b->datahora <=> $a->datahora);
            });

        // Pagina os dados combinados
        $perPage = 10; // Número de itens por página
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $combinedData->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedData = new LengthAwarePaginator($currentItems, $combinedData->count(), $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        return view('dashboard', ['combinedData' => $paginatedData]);
    }

    /* /INDEX */

    public function endScript(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        // Atualize o status do roteiro conforme necessário
        // Exemplo:
        DB::table('authorizerequests')
            ->where('id', $id)
            ->update(['statusauthorization' => $status]);

        return redirect()->back()->with('success', 'Status atualizado com sucesso.');
    }

    public function getTotalCount()
    {
        $total = DB::table('combinedData')->count(); // Ajuste conforme necessário
        return response()->json(['total' => $total]);
    }
}
