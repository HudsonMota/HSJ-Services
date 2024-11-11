@extends('layouts.application')

@section('content')
    <h1 class="ls-title-intro ls-ico-cog">Listagem de papéis de usuário</h1>
    <div class="ls-box">
        <div class="box-header">
            <h5 class="ls-title">Listar Papeis</h5>

        </div>

        <table class="ls-table ls-table-striped ls-bg-header">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Papel</th>
                    <th>Descrição</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($role_users as $role_user)
                    <tr>
                        <td>{{ $role_user->user_id }}</td>
                        @foreach ($users as $user)
                            @if ($role_user->user_id == $user->id)
                                <td>{{ $user->name }}</td>
                            @endif
                        @endforeach
                        @foreach ($roles as $role)
                            @if ($role_user->role_id == $role->id)
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->label }}</td>
                            @endif
                        @endforeach
                        <td>
                            <div class="col-md-4">
                                <a class="ls-ico-pencil ls-btn-dark" style="background-color: blue;"
                                    href="{{ route('roleuser.edit', $role_user->id) }}"></a>
                            </div>
                            <div class="col-md-4">
                                <a class="ls-ico-remove ls-btn-primary-danger"
                                    href="{{ route('roleuser.delete', $role_user->id) }}"></a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
