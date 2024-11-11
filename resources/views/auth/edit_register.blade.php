@extends('layouts.application')

@section('content')
<h1 class="ls-title-intro ls-ico-dashboard">Editar usuário</h1>
<div class="ls-box">
    <form method="POST" action="{{route('user.edit',$user->id)}}" class="ls-form row">
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <fieldset class="col-md-12">
            <div class="col-md-12">
                <div class="form-group col-md-3">
                    <label class="ls-label col-md-12 @error('name') ls-error @enderror">
                        <h1>{{$user->name}}</h1>
                        <b class="ls-label-text">Nome:</b>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$user->name}}" required autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </label>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group col-md-3">
                    <label class="ls-label col-md-12 @error('email') ls-error @enderror">
                        <b class="ls-label-text">E-mail:</b>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </label>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group col-md-3">
                    <label class="ls-label col-md-12">
                        <b class="ls-label-text">CC - Setor:</b>
                        <div class="ls-custom-select col-md-12">
                            <select name="sector_id" class="ls-select form-control">
                                <?php $selected = $user->sector_id ?>
                                @inject('sectors', '\App\Sector')
                                @foreach($sectors->getSectors() as $sectors)
                                @if(($selected) == ($sectors->cc))
                                <option value="{{$sectors->cc}}" class=" form-control" selected>{{$sectors->cc}} - {{$sectors->sector}}</option>
                                @endif
                                <option value="{{$sectors->cc}}" class=" form-control">{{$sectors->cc}} - {{$sectors->sector}}</option>
                                @endforeach
                            </select>
                        </div>
                    </label>

                </div>
            </div>
        </fieldset>

        <div class="ls-actions-btn">
            <input type="submit" value="Atualizar" class="ls-btn-dark" title="update" style="font-weight: bold; background-color: blue;">
            <a href="{{ route('users') }}" class="ls-btn-primary-danger" style="font-weight: bold;">Cancelar</a>
        </div>
    </form>
</div>
@endsection