<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use DB;

class ChartController extends Controller
{
  public function costByVehicle(Request $field)
  {
    $vehicle = DB::table('vehicles')
      ->select(
        DB::raw('id as id'),
        DB::raw('brand as brand'),
        DB::raw('model as model'),
        DB::raw('placa as placa')
      )->get();

    foreach ($vehicle as $key => $value) {
      $expense_vehicle[++$key] = [$value->id, $value->brand, $value->model, $value->placa];
    }

    foreach ($vehicle as $data) {
      $wheelsetsKm[] = DB::select(
        "SELECT SUM(quantity_km_whells) as km FROM expenses
          WHERE category_id = 1 
          AND vehicle_id = $data->id
        "
      );
      $fuel[] = DB::select(
        "SELECT SUM(supply_in_liters) as fuel_consumed FROM expenses
          WHERE category_id = 1 
          AND vehicle_id = $data->id
        "
      );
      $maintenance[] = DB::select(
        "SELECT SUM(total_value_supply) as maintenance FROM expenses
          WHERE category_id = 3 
          AND vehicle_id = $data->id
        "
      );
      $fuel_paid[] = DB::select(
        "SELECT SUM(total_value_supply ) as fuel_consumed FROM expenses
          WHERE category_id = 1 
          AND vehicle_id = $data->id
        "
      );
    };

    for ($i = 1; $i <= count($vehicle); $i++) {
      array_push($expense_vehicle[$i], $wheelsetsKm[$i - 1]);
      array_push($expense_vehicle[$i], $fuel[$i - 1]);
      array_push($expense_vehicle[$i], $maintenance[$i - 1]);
      array_push($expense_vehicle[$i], $fuel_paid[$i - 1]);
    }


    $default_list = 1;

    return view('chart/cost_by_vehicle')
      ->with('expenses', json_encode($expense_vehicle))
      ->with('default_list', json_encode($default_list));
  }

  public function searchVeicleIntervalDate(Request $field)
  {
    $datainicio = $field['datainicio'] . ' 00:00:01';
    $datafim = $field['datafim'] . ' 23:59:59';

    $vehicle = DB::table('vehicles')
      ->select(
        DB::raw('id as id'),
        DB::raw('brand as brand'),
        DB::raw('model as model'),
        DB::raw('placa as placa')
      )->get();

    foreach ($vehicle as $key => $value) {
      $seach_expense_vehicle[++$key] = [$value->id, $value->brand, $value->model, $value->placa];
    }


    // Pega todos os custos
    $cost = DB::table('expenses')
      ->where('updated_at', '>=', $datainicio)
      ->where('updated_at', '<=', $datafim)->get();

    foreach ($vehicle as $data) {
      $wheelsetsKm[][0] = $cost->where('category_id', 1)
        ->where('vehicle_id', $data->id)
        ->sum(function ($row) {
          return $row->quantity_km_whells;
        });

      $fuel[][0] =
        $cost->where('category_id', 1)
        ->where('vehicle_id', $data->id)
        ->sum('supply_in_liters');

      $maintenance[][0] =
        $cost->where('category_id', 3)
        ->where('vehicle_id', $data->id)
        ->sum('total_value_supply');

      $fuel_paid[][0] =
        $cost->where('category_id', 1)
        ->where('vehicle_id', $data->id)
        ->sum('total_value_supply');
    };

    for ($i = 1; $i <= count($vehicle); $i++) {
      array_push($seach_expense_vehicle[$i], $wheelsetsKm[$i - 1]);
      array_push($seach_expense_vehicle[$i], $fuel[$i - 1]);
      array_push($seach_expense_vehicle[$i], $maintenance[$i - 1]);
      array_push($seach_expense_vehicle[$i], $fuel_paid[$i - 1]);
    }

    $default_list = 0;

    return view('chart/cost_by_vehicle')
      ->with('expenses', json_encode($seach_expense_vehicle))
      ->with('default_list', json_encode($default_list));
  }



  public function costBySector()
  {
    // Salva todos os setores na collection $sector
    $sector = DB::table('sectors')
      ->select(
        DB::raw('id as id'),
        DB::raw('cc as cc'),
        DB::raw('sector as sector'),
      )->get();

    // Cria um array($expense_sector) com as informações da collection $sector
    foreach ($sector as $key => $value) {
      $expense_sector[++$key] = [$value->id, $value->cc, $value->sector];
    }

    // Gera as informações da view de custos
    // [Quilometragem => $wheelsetsKm, 
    // Valor pago em combutivel => $fuel_paid, 
    // Total em quilometragem das viagens realizadas => $totalKm,
    // Veículo => $vehicle_id_cost,
    // Data => $date_fuel_cost]
    foreach ($sector as $data) {
      $wheelsetsKm[] = DB::select(
        "SELECT SUM(individual_km) as km FROM fuel_costs
          WHERE sector_id = $data->cc
        "
      );

      $fuel_paid[] = DB::select(
        "SELECT SUM(individual_spent) as spent FROM fuel_costs
          WHERE sector_id = $data->cc
        "
      );

      $totalKm[] = DB::select(
        "SELECT SUM(individual_km) as km FROM fuel_costs
        -- WHERE sector_id = $data->cc
        "
      );

      $vehicle_id_cost[] = DB::select(
        "SELECT vehicle_id as vehicle FROM fuel_costs
          WHERE sector_id = $data->cc
        ",
      );

      $date_fuel_cost[] = DB::select(
        "SELECT date as date FROM fuel_costs
          WHERE sector_id = $data->cc
        ",
      );
    }

    // Adciona os custos gerados anteriormente ao array $expense_sector
    for ($i = 1; $i <= count($sector); $i++) {
      array_push($expense_sector[$i], $wheelsetsKm[$i - 1]);
      array_push($expense_sector[$i], $fuel_paid[$i - 1]);
      array_push($expense_sector[$i], $totalKm[$i - 1]);
      array_push($expense_sector[$i], $vehicle_id_cost[$i - 1] ? $vehicle_id_cost[$i - 1] : 0);
      array_push($expense_sector[$i], $date_fuel_cost[$i - 1]);
    }

    ################################# - Despesa de Manutenção - #######################################
    // Salva todos os veículos na collection $vehicle
    $vehicle = DB::table('vehicles')
      ->select(
        DB::raw('id as id')
      )->get();

    // Cria um array($expense_vehicle) com as informações da collection $vehicle
    foreach ($vehicle as $key => $value) {
      $expense_vehicle[++$key] = [$value->id];
    }

    // Gera as informações da view de custos
    // [Manutenção => $maintenance_cost,
    // Data => $date_maintenance_cost]
    foreach ($vehicle as $data) {
      $maintenance_cost[] = DB::select(
        // SELECT SUM(individual_km) as km FROM fuel_costs
        "SELECT SUM(total_value_supply) as maintenance FROM expenses
        WHERE category_id = 3
        AND vehicle_id = $data->id
      "
      );

      $date_maintenance_cost[] = DB::select(
        "SELECT date as date FROM expenses
        WHERE category_id = 3
        AND vehicle_id = $data->id
      "
      );
    }

    // Adciona os custos gerados anteriormente ao array $expense_vehicle
    for ($i = 1; $i <= count($vehicle); $i++) {
      array_push($expense_vehicle[$i], $maintenance_cost[$i - 1]);
      array_push($expense_vehicle[$i], $date_maintenance_cost[$i - 1]);
    }
    ################################# - Despesa de Manutenção - #######################################

    // Calcula o rateio em (%) para cada setor em relação a
    // Quilometragem gasta por cada setor e a quilometragem total das viagens
    for ($i = 1; $i <= count($sector); $i++) {
      $divider = $expense_sector[$i][5][0]->km;
      $rateio[] = $divider == 0 ? 0 : $expense_sector[$i][3][0]->km / $expense_sector[$i][5][0]->km;
    }

    // Com o rateio(%) Calculamos os custos de cada setor em relação às desepesas com manutenção
    for ($i = 1; $i <= count($sector); $i++) {
      if ($expense_sector[$i][6] != 0) {
        for ($j = 1; $j <= count($vehicle); $j++) {
          if ($expense_sector[$i][6][0]->vehicle === $expense_vehicle[$j][0]) {
            array_push($expense_sector[$i], $rateio[$i - 1] * $expense_vehicle[$j][1][0]->maintenance);
          }
        }
      }
    }

    $default_list = 1;

    return view('chart/cost_by_sector')
      ->with('expense_sectors', json_encode($expense_sector))
      ->with('default_list', json_encode($default_list));
  }

  public function searchSectorIntervalDate(Request $field)
  {
    // Usuário define um período para pesquisar custos
    $datainicio = $field['datainicio'] . ' 00:00:01';
    $datafim = $field['datafim'] . ' 23:59:59';

    // Salva todos os setores na collection $sector
    $sector = DB::table('sectors')
      ->select(
        DB::raw('id as id'),
        DB::raw('cc as cc'),
        DB::raw('sector as sector'),
      )->get();

    // Cria um array($expense_sector) com as informações da collection $sector
    foreach ($sector as $key => $value) {
      $expense_sector[++$key] = [$value->id, $value->cc, $value->sector];
    }

    // Pega todos os custos com base no intervalo informado
    $cost = DB::table('fuel_costs')
      ->where('date', '>=', $datainicio)
      ->where('date', '<=', $datafim)->get();

    // Gera as informações da view de custos
    // [Quilometragem => $wheelsetsKm, 
    // Valor pago em combutivel => $fuel_paid, 
    // Total em quilometragem das viagens realizadas => $totalKm,
    // Veículo => $vehicle_id_cost,
    // Data => $date_fuel_cost]
    foreach ($sector as $data) {
      $wheelsetsKm[] =
        $cost->where('sector_id', $data->cc)
        ->sum(function ($row) {
          return $row->individual_km;
        });

      $fuel_paid[] =
        $cost->where('sector_id', $data->cc)
        ->sum('individual_spent');

      $totalKm[] =
        $cost->sum(function ($row) {
          return $row->individual_km;
        });

      $vehicle_id_cost[] = DB::table('fuel_costs')
        ->select('vehicle_id')
        ->where('sector_id', $data->cc)
        ->where('date', '>=', $datainicio)
        ->where('date', '<=', $datafim)->get();
    }

    // dd($vehicle_id_cost[32][0]->vehicle_id);

    // Adciona os custos gerados anteriormente ao array $expense_sector
    for ($i = 1; $i <= count($sector); $i++) {
      array_push($expense_sector[$i], $wheelsetsKm[$i - 1]);
      array_push($expense_sector[$i], $fuel_paid[$i - 1]);
      array_push($expense_sector[$i], $totalKm[$i - 1]);
      array_push($expense_sector[$i], $vehicle_id_cost[$i - 1] ? $vehicle_id_cost[$i - 1] : 0);
    }

    ################################# - Despesa de Manutenção - #######################################
    // Salva todos os veículos na collection $vehicle
    $vehicle = DB::table('vehicles')
      ->select(
        DB::raw('id as id')
      )->get();

    // Cria um array($expense_vehicle) com as informações da collection $vehicle
    foreach ($vehicle as $key => $value) {
      $expense_vehicle[++$key] = [$value->id];
    }

    // Pega todos as despesas em manutenção com base no intervalo informado
    $exp_cost = DB::table('expenses')
      ->where('date', '>=', $datainicio)
      ->where('date', '<=', $datafim)->get();

    // Gera as informações da view de custos
    // [Manutenção => $maintenance_cost,
    // Data => $date_maintenance_cost]
    foreach ($vehicle as $data) {
      $maintenance_cost[] = DB::table('expenses')
        ->select(
          DB::raw('sum(total_value_supply) as maintenance')
        )->where('vehicle_id', $data->id)->get();


      $date_maintenance_cost[] = DB::table('expenses')
        ->select(
          DB::raw('date as maintenance_date')
        )->where('vehicle_id', $data->id)->get();
    }

    // Adciona os custos gerados anteriormente ao array $expense_vehicle
    for ($i = 1; $i <= count($vehicle); $i++) {
      array_push($expense_vehicle[$i], $maintenance_cost[$i - 1]);
    }
    ################################# - Despesa de Manutenção - #######################################

    // Calcula o rateio em (%) para cada setor em relação a
    // Quilometragem gasta por cada setor e a quilometragem total das viagens
    // dd($expense_sector[33][3], $expense_sector[33][5], $expense_sector);
    for ($i = 1; $i <= count($sector); $i++) {
      $rateio[] = $expense_sector[$i][3] / $expense_sector[$i][5];
    }

    // dd($expense_sector[33][6][0]->vehicle_id);
    // Com o rateio(%) Calculamos os custos de cada setor em relação às desepesas com manutenção
    for ($i = 1; $i <= count($sector); $i++) {
      if (count($expense_sector[$i][6]) != 0) {
        for ($j = 1; $j <= count($vehicle); $j++) {
          if ($expense_sector[$i][6][0]->vehicle_id === $expense_vehicle[$j][0]) {
            array_push($expense_sector[$i], $rateio[$i - 1] * $expense_vehicle[$j][1][0]->maintenance);
          }
        }
      }
    }

    $default_list = 0;

    return view('chart/cost_by_sector')
      ->with('expense_sectors', json_encode($expense_sector))
      ->with('default_list', json_encode($default_list));
  }
}
