@extends('layouts.application')

@section('content')

<h1 class="ls-title-intro ls-ico-plus">Editar Despesa</h1>
<div class="ls-box">
  <form method="POST" action="{{route('expense.edit',$expense->id)}}" class="ls-form row">
    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
    <div class="col-md-12">
      <div class="col-md-12">

        <!-- VEÍCULO -->
        <div class="form-group col-md-4">
          <label class="ls-label col-md-12 @error('vehicle_id') ls-error @enderror">
            <b class="ls-label-text">Veículo</b>
            <div class="ls-custom-select">
              <select name="vehicle_id" class="ls-select">
                @foreach($vehicles as $vehicle)

                @if(($vehicle->id) == ($expense->vehicle_id))
                <option value="{{$vehicle->id}}">{{$vehicle->model}} - {{$vehicle->brand}} - {{$vehicle->placa}}</option>
                @endif

                @endforeach
              </select>
            </div>
          </label>
        </div>

        <!-- CATEGORIA -->
        <div class="form-group col-md-4">
          <label class="ls-label col-md-12  @error('category_id') ls-error @enderror">
            <b class="ls-label-text">Categoria</b>
            @inject('categories', '\App\Category')
            <div class="ls-custom-select">
              <select name="category_id" class="ls-select" id="category_id">
                @foreach($categories->getCategories() as $categories)
                @if($expense->category_id == $categories->id)
                <option value="{{ $expense->category_id }}" selected>{{ $categories->name }}</option>
                @endif
                @endforeach
              </select>
            </div>

            @error('category_id')
            <div class="ls-help-message">
              {{$message}}
            </div>
            @enderror

          </label>
        </div>

      </div>
    </div>


    <div class="col-md-12" id="supply">
    </div>

    <div class="col-md-12" id="maintenance">
    </div>

    </fieldset>

    <div class="ls-actions-btn col-md-12">
      <input type="submit" value="Atualizar" class="ls-btn-dark" title="update" style="font-weight: bold; background-color: blue;">
      <a href="{{ route('expenses') }}" class="ls-btn-primary-danger" style="font-weight: bold;">Cancelar</a>
    </div>
  </form>
</div>


<script type="text/javascript">
  $exp_edit = <?php echo $exp_edit; ?>;
  console.log($exp_edit)
</script>
<fieldset>

  <script type="text/javascript" src="{{ URL::asset('js/editmaintenanceorsupply.js') }}"></script>
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