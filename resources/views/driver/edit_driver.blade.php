@extends('layouts.application')

@section('content')
    <h1 class="ls-title-intro ls-ico-user-add">Editar dados do Técnico</h1>
    <div class="ls-box">
        <h5 class="ls-title-5">Edição do Técnico</h5>
        <hr>
        <form method="POST" action="{{ route('driver.edit', $driver->id) }}" class="ls-form row" data-ls-module="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <fieldset class="col-md-12">
                <!-- Nome Completo do Técnico -->
                <div class="form-group col-md-12 mb-3">
                    <label class="ls-label">
                        <b class="ls-label-text">Nome Completo do Técnico</b>
                        <input type="text" class="form-control" name="name_driver" value="{{ $driver->name_driver }}"
                            style="max-width: 400px;" required>
                        <!-- Optional: Display validation errors for name_driver -->
                        @error('name_driver')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </label>
                </div>

                <!-- CPF e Botões -->
                <div class="form-group col-md-12">
                    <div class="row">
                        <!-- Campo CPF -->
                        <div class="col-md-6">
                            <label class="ls-label">
                                <b class="ls-label-text">CPF</b>
                                <input type="text" name="cpf" class="form-control ls-mask-cpf"
                                    placeholder="000.000.000-00" style="max-width: 200px;" value="{{ $driver->cpf }}"
                                    style="max-width: 200px;" required>
                                <!-- Optional: Display validation errors for cpf -->
                                @error('cpf')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </label>
                        </div>

                        <!-- Botões -->
                        <div class="col-md-6 d-flex justify-content-start align-items-center">
                            <div class="d-flex" style="margin-left: -230px;">
                                <!-- Ajuste para mover os botões para a esquerda -->
                                <button type="submit" class="ls-btn-primary"
                                    style="font-weight: bold; margin-right: 10px; padding: 6px 12px;">Atualizar</button>
                                <a href="{{ route('drivers') }}" class="ls-btn-primary-danger"
                                    style="font-weight: bold; padding: 6px 12px;">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>

@stop
