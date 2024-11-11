@extends('layouts.application')

@section('content')
    <h1 class="ls-title-intro ls-ico-user-add">Cadastrar Técnico</h1>
    <div class="ls-box">
        <h5 class="ls-title-5">Cadastro do Técnico</h5>
        <hr>
        <form method="POST" action="{{ route('driver.postAdd') }}" class="ls-form row" id="add" data-ls-module="form">
            @csrf <!-- Laravel Blade directive for CSRF token -->

            <fieldset class="col-md-12">
                <!-- Nome Completo do Técnico -->
                <div class="form-group col-md-12 mb-3">
                    <label class="ls-label">
                        <b class="ls-label-text">Nome Completo do Técnico</b>
                        <input type="text" class="form-control" name="name_driver" value="{{ old('name_driver') }}"
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
                                    placeholder="000.000.000-00" style="max-width: 200px;" value="{{ old('cpf') }}"
                                    required>
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
                                    style="font-weight: bold; margin-right: 10px; padding: 6px 12px;">Cadastrar</button>
                                <button type="reset" class="ls-btn-primary-danger"
                                    style="font-weight: bold; padding: 6px 12px;">Limpar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
@stop
