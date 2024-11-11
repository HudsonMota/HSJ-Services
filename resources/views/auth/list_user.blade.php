@extends('layouts.application')

@section('content')
    <h1 class="ls-title-intro ls-ico-user-add">Listagem de usuários</h1>
    <div class="table-responsive">
        <div class="ls-box ">
            <div class="box-header">

            </div>

            <table class="ls-table ls-table-striped ls-bg-header ">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome de usuário</th>
                        <th>E-mail</th>
                        <th>CC - Setor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @inject('sectors', '\App\Sector')
                        @foreach ($sectors->getSectors() as $sector)
                            @if ($user->sector_id == $sector->cc)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $sector->cc }} - {{ $sector->sector }}</td>
                                    <td>
                                        <div class="col-12">
                                            <div class="col-md-4">
                                                <a class="ls-ico-pencil ls-btn-dark" style="background-color: blue;"
                                                    href="{{ route('user.edit', $user->id) }}"></a>
                                            </div>
                                            <div class="col-md-4">
                                                <a class="ls-ico-remove ls-btn-primary-danger"
                                                    href="{{ route('user.delete', $user->id) }}"></a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @else
                            @endif
                        @endforeach
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
@stop
