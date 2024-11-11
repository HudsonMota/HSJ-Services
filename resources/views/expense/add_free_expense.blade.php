@extends('layouts.application')

@section('content')

<h1 class="ls-title-intro ls-ico-plus">Incluir Despesa</h1>
<div class="ls-box">
    <form method="POST" action="{{ route('expense.postAdd') }}" class="ls-form row">
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <fieldset class="col-md-12">

            <div class="col-md-12">
                <div class="col-md-12">
                    <!-- VEÍCULO -->
                    <div class="form-group col-md-4">
                        <label class="ls-label col-md-12">
                            <b class="ls-label-text">Veículo</b>
                            <div class="ls-custom-select">
                                <select name="vehicle_id" class="ls-select" required oninvalid="this.setCustomValidity('Selecione um veículo!')" onchange="try{setCustomValidity('')}catch(e){}">
                                    <option value=""> </option>
                                    @foreach($vehicles as $vehicle)
                                    <option value="{{$vehicle->id}}">{{$vehicle->brand}} - {{$vehicle->model}} - {{$vehicle->placa}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </label>
                    </div>

                    <!-- CATEGORIA -->
                    <div class="form-group col-md-4">
                        <label class="ls-label col-md-12">
                            <b class="ls-label-text">Categoria</b>
                            @inject('categories', '\App\Category')
                            <div class="ls-custom-select">
                                <select name="category_id" class="ls-select" onchange="maintenanceOrSupply(this.value)" required oninvalid="this.setCustomValidity('Selecione uma categoria!')" onchange="try{setCustomValidity('')}catch(e){}">
                                    <option value=""></option>
                                    @foreach($categories->getCategories() as $categories)
                                    @if($categories->id != 2)
                                    <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </label>
                    </div>

                </div>
            </div>

            <div class="col-md-12" id="supply"></div>

            <div class="col-md-12" id="maintenance"></div>

        </fieldset>

        <div class="ls-actions-btn col-md-12">
            <input type="submit" value="Cadastrar" class="ls-btn-primary" title="Cadastrar" style="font-weight: bold;">
            <input class="ls-btn-primary-danger" type="reset" value="Limpar" style="font-weight: bold;">
        </div>
    </form>

</div>

<script type="text/javascript" src="{{ URL::asset('js/maintenanceorsupply.js') }}"></script>
<script>
    function kmValidation() {
        var kminicial = document.getElementById("kminicial");
        var kmfinal = document.getElementById("kmfinal");
        var result = kmfinal.value - kminicial.value;
        if (result <= 0) {
            kmfinal.setCustomValidity("A quilometragem final precisa ser maior que a inicial");
        } else {
            kmfinal.setCustomValidity("");
        }
        if (result >= 1000) {
            kmfinal.setCustomValidity("Valor a cima do limite! Verifique se o valor está correto ou entre em contato com o suporte.");
        } else {
            kmfinal.setCustomValidity("");
        }
    }
</script>


@stop