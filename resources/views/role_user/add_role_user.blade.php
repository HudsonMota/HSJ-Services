@extends('layouts.application')

@section('content')
    <h1 class="ls-title-intro ls-ico-cog"><strong>Cadastrar papel de usuário:</strong></h1>
    <div class="ls-box">
        <hr>
        <h5 class="ls-title-5">Cadastrar Papel de usuário:</h5>
        <form method="POST" action="{{ route('roleuser.postAdd') }}" class="ls-form row">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <fieldset>
                <div class="col-md-12">
                    <div class="row">
                        <!-- Seleção de Usuário -->
                        <div class="form-group col-md-4">
                            <label class="ls-label col-md-12">
                                <b class="ls-label-text">Usuário</b>
                                <div class="ls-custom-select">
                                    <select name="user_id" class="ls-select form-control">
                                        <option value="" disabled selected>Selecione um usuário</option>
                                        @foreach ($users as $call)
                                            <!-- Alterado de $read para $users -->
                                            <option value="{{ $call->id }}">{{ $call->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </label>
                        </div>
                        <!-- Seleção de Papel -->
                        <div class="form-group col-md-4">
                            <label class="ls-label col-md-12">
                                <b class="ls-label-text">Papel</b>
                                <div class="ls-custom-select">
                                    <select name="role_id" class="ls-select form-control">
                                        <option value="" disabled selected>Selecione um papel</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </label>
                        </div>

                        <!-- Descrição dos Papéis -->
                        <div class="form-group col-md-4">
                            <b class="ls-label-text">Descrição dos Papéis</b>
                            <div class="ls-label col-md-12">
                                <ul class="list-unstyled">
                                    @foreach ($roles as $role)
                                        <li><strong>{{ $role->name }}:</strong> {{ $role->label }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="ls-actions-btn" style="border-top-color: rgba(255,255,255);">
                <input type="submit" value="Cadastrar" class="ls-btn-primary" title="Cadastrar" style="font-weight: bold;">
                <input type="reset" value="Limpar" class="ls-btn-primary-danger" sstyle="font-weight: bold;">
            </div>
        </form>
        <hr>
    </div>

@stop
