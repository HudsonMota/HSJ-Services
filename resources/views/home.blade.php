<!-- ################################# H O M E ############################################# -->
@extends('layouts.application')
@section('content')
    <?php $name = substr(Auth::user()->name, 0, strrpos(substr(Auth::user()->name, 0, 20), ' ')); ?>
    <h1 class="ls-title-intro ls-ico-home"> Olá {{ strtok(Auth::user()->name, ' ') }}! Seja bem-vindo ao &nbsp;
        {{ config('app.name') }} </h1>
    @if (Auth::user()->roles->first()->id == 1 || Auth::user()->roles->first()->id == 2)
        {{-- USER ADM --}}
        <div class="ls-box ls-board-box">
            <!-- ATENDIMENTOS AGUARDANDO -->
            @can('View ADM dashboard')
                <div class="col-sm-6 col-md-3 dash">
                    <div class="ls-box" style="background-color: #8E9089;">
                        <div class="ls-box-head">
                            <h6 class="ls-title-4" style="color: white; font-weight: bold;">ATENDIMENTOS AGUARDANDO</h6>
                        </div>
                        <div class="ls-box-body">
                            <strong
                                style="color: white; font-weight: bold;">{{ App\Solicitacao::where('statussolicitacao', 'AGUARDANDO')->where('created_at', '>', date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y'))))->count() }}</strong>
                        </div>
                        <div class="ls-box-footer">
                            <div class="box-header">
                                <a href="{{ route('authorization.add') }}" class="btn btn-light"
                                    style="width: 150px; margin-left: auto; margin-right: auto; color: #000; font-weight: bold;">Exibir</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            <!-- ATENDIMENTOS ATRIBUIDOS -->
            @can('View ADM dashboard')
                <div class="col-sm-6 col-md-3 dash">
                    <div class="ls-box" style="background-color: #77C5D5;">
                        <div class="ls-box-head">
                            <h6 class="ls-title-4" style="color: white; font-weight: bold;">ATENDIMENTOS ATRIBUIDOS</h6>
                        </div>
                        <div class="ls-box-body">
                            <strong
                                style="color: white; font-weight: bold;">{{ App\Authorizacao::where('statusauthorization', 'ATRIBUIDO')->where('authorized_departure_date', '>', date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y'))))->count() }}</strong>
                        </div>
                        <div class="ls-box-footer">
                            <div class="box-header">
                                <a href="{{ route('authorizations', ['status' => 'ATRIBUIDO']) }}" class="btn btn-light"
                                    style="width: 150px; margin-left: auto; margin-right: auto; color: #000; font-weight: bold;">Exibir</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            <!-- ATENDIMENTOS PENDENTES -->
            @can('View ADM dashboard')
                <div class="col-sm-6 col-md-3 dash">
                    <div class="ls-box" style="background-color: #FF6A13;">
                        <div class="ls-box-head">
                            <h6 class="ls-title-4" style="color: white; font-weight: bold;">ATENDIMENTOS PENDENTES</h6>
                        </div>
                        <div class="ls-box-body">
                            <strong
                                style="color: white; font-weight: bold;">{{ App\Authorizacao::where('statusauthorization', 'PENDENTE')->where('authorized_departure_date', '>', date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y'))))->count() }}</strong>
                        </div>
                        <div class="ls-box-footer">
                            <div class="box-header">
                                <a href="{{ route('authorizations', ['status' => 'PENDENTE']) }}" class="btn btn-light"
                                    style="width: 150px; margin-left: auto; margin-right: auto; color: #000; font-weight: bold;">Exibir</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
            <!-- ATENDIMENTOS REALIZADOS -->
            @can('View ADM dashboard')
                <div class="col-sm-6 col-md-3 dash">
                    <div class="ls-box" style="background-color:#279989;">
                        <div class="ls-box-head">
                            <h6 class="ls-title-4" style="color: white; font-weight: bold;">ATENDIMENTOS REALIZADOS</h6>
                        </div>
                        <div class="ls-box-body">
                            <strong
                                style="color: white; font-weight: bold;">{{ App\Authorizacao::where('statusauthorization', 'REALIZADO')->where('authorized_departure_date', '>', date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y'))))->count() }}</strong>
                        </div>
                        <div class="ls-box-footer">
                            <div class="box-header">
                                <a href="{{ route('authorizations', ['status' => 'REALIZADO']) }}" class="btn btn-light"
                                    style="width: 150px; margin-left: auto; margin-right: auto; color: #000; font-weight: bold;">Exibir</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    @else
        {{-- USER REQUEST --}}
        <div class="ls-box ls-board-box">
            <!-- ATENDIMENTOS AGUARDANDO -->
            <div class="col-sm-6 col-md-3 dash">
                <div class="ls-box" style="background-color: #8E9089;">
                    <div class="ls-box-head">
                        <h6 class="ls-title-4" style="color: white; font-weight: bold;">ATENDIMENTOS AGUARDANDO</h6>
                    </div>
                    <div class="ls-box-body">
                        <strong
                            style="color: white; font-weight: bold;">{{ App\Solicitacao::where('statussolicitacao', 'AGUARDANDO')->where('user_id', Auth::user()->id)->where('created_at', '>', date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y'))))->count() }}</strong>
                    </div>
                    <div class="ls-box-footer">
                        <div class="box-header">
                            <a href="{{ route('authorization.add') }}" class="btn btn-light"
                                style="width: 150px; margin-left: auto; margin-right: auto; color: #000; font-weight: bold;">Exibir</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ATENDIMENTOS ATRIBUIDOS -->
            <div class="col-sm-6 col-md-3 dash">
                <div class="ls-box" style="background-color: #77C5D5;">
                    <div class="ls-box-head">
                        <h6 class="ls-title-4" style="color: white; font-weight: bold;">ATENDIMENTOS ATRIBUIDOS</h6>
                    </div>
                    <div class="ls-box-body">
                        <strong
                            style="color: white; font-weight: bold;">{{ App\Solicitacao::where('statussolicitacao', 'ATRIBUIDO')->where('user_id', Auth::user()->id)->where('created_at', '>', date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y'))))->count() }}</strong>
                    </div>
                    <div class="ls-box-footer">
                        <div class="box-header">
                            <a href="{{ route('authorizations', ['status' => 'ATRIBUIDO']) }}" class="btn btn-light"
                                style="width: 150px; margin-left: auto; margin-right: auto; color: #000; font-weight: bold;">Exibir</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ATENDIMENTOS PENDENTES -->
            <div class="col-sm-6 col-md-3 dash">
                <div class="ls-box" style="background-color: #FF6A13;">
                    <div class="ls-box-head">
                        <h6 class="ls-title-4" style="color: white; font-weight: bold;">ATENDIMENTOS PENDENTES</h6>
                    </div>
                    <div class="ls-box-body">
                        <strong
                            style="color: white; font-weight: bold;">{{ App\Solicitacao::where('statussolicitacao', 'PENDENTE')->where('user_id', Auth::user()->id)->where('created_at', '>', date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y'))))->count() }}</strong>
                    </div>
                    <div class="ls-box-footer">
                        <div class="box-header">
                            <a href="{{ route('authorizations', ['status' => 'PENDENTE']) }}" class="btn btn-light"
                                style="width: 150px; margin-left: auto; margin-right: auto; color: #000; font-weight: bold;">Exibir</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ATENDIMENTOS REALIZADOS -->
            <div class="col-sm-6 col-md-3 dash">
                <div class="ls-box" style="background-color:#279989;">
                    <div class="ls-box-head">
                        <h6 class="ls-title-4" style="color: white; font-weight: bold;">ATENDIMENTOS REALIZADOS</h6>
                    </div>
                    <div class="ls-box-body">
                        <strong
                            style="color: white; font-weight: bold;">{{ App\Solicitacao::where('statussolicitacao', 'REALIZADO')->where('user_id', Auth::user()->id)->where('created_at', '>', date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y'))))->count() }}</strong>
                    </div>
                    <div class="ls-box-footer">
                        <div class="box-header">
                            <a href="{{ route('authorizations', ['status' => 'REALIZADO']) }}" class="btn btn-light"
                                style="width: 150px; margin-left: auto; margin-right: auto; color: #000; font-weight: bold;">Exibir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
