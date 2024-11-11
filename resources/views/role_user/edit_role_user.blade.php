@extends('layouts.application')

@section('content')
    <h1 class="ls-title-intro ls-ico-cog"><strong>Gerenciar papel de usuário</strong></h1>
    <div class="ls-box">
        <hr>
        <h5 class="ls-title-5">Editar papel do usuário:</h5>
        <form method="POST" action="{{ route('roleuser.edit', $role_user->id) }}" class="ls-form row">
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
                                        @foreach ($users as $user)
                                            @if ($user->id == $role_user->user_id)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endif
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
                                        @foreach ($roles as $role)
                                            @if ($role->id == $role_user->role_id)
                                                <option value="{{ $role->id }}" selected="selected">{{ $role->name }}
                                                </option>
                                            @endif

                                            @if ($role->id != $role_user->role_id)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endif
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

            <div class="ls-actions-btn">
                <input type="submit" value="Atualizar" class="ls-btn-dark" title="update"
                    style="font-weight: bold; background-color: blue;">
                <a href="{{ route('roleusers') }}" class="ls-btn-primary-danger" style="font-weight: bold;">Cancelar</a>
            </div>
        </form>
    </div>


@stop
