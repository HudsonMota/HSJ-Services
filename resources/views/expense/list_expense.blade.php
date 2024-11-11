@extends('layouts.application')

@section('content')

@if (\Session::has('error'))
<div class="ls-modal ls-opened" id="myAwesomeModal" role="dialog" aria-hidden="false" aria-labelledby="lsModal1" tabindex="-1">
  <div class="ls-modal-box">
    <div class="ls-modal-header">
      <h2 class="ls-modal-title" id="lsModal1"><strong>Atenção</strong></h2>
    </div>
    <div class="ls-modal-body">
      <h5 class="alert alert-danger">{!! \Session::get('error') !!}</h5>
    </div>
    <div class="ls-modal-footer">
      <button onclick="closeModal()" style="margin-bottom: 20px;" class="btn btn-danger ls-float-right">Fechar</button>
    </div>
  </div>
</div>
@endif
<script>
  function closeModal(){
    locastyle.modal.close()
  }
</script>


<h1 class="ls-title-intro ls-ico-plus">Listar Despesas</h1>
<div class="ls-box">

  <table class="table table-hover" id="tableexpenses">
    <thead>
      <tr>
        <th>Cod</th>
        <th>Veículo</th>
        <th>Categoria</th>
        <th>Descrição</th>
        <th whith="50">Abastecimento <strong>(L)</strong></th>
        <th whith="50">Total pago <strong>(R$)</strong></th>
        <th whith="50">Km anterior <strong>(Km)</strong></th>
        <th whith="50">Km atual <strong>(Km)</strong></th>
        <th whith="50">Km rodados <strong>(Km)</strong></th>
        <th whith="50">Km por litro <strong>(Km/L)</strong></th>
        <th>Data</th>
        <th>Hora</th>
        <th width="100">Ações</th>
      </tr>
    </thead>
    <tbody id="tbodyexpenses">
      <tr>
        <td>Despesas</td>
      </tr>
    </tbody>
  </table>
</div>

<script>
  var list_expenses = <?php echo json_encode($list_expenses); ?>;
  console.log(list_expenses[2]);
  var tbodyexpenses = document.getElementById("tbodyexpenses");

  // Reseta a Table de Expenses
  tbodyexpenses.innerHTML = '';

  for (var i = 0; i < list_expenses.length; i++) {
    tbodyexpenses.innerHTML +=
      `
      <tr>
        <td>` + list_expenses[i][0] + `</td>
        <td>` + list_expenses[i][1] + `</td>
        <td>` + list_expenses[i][2] + `</td>
        <td>` + (list_expenses[i][12] == null ? '' : list_expenses[i][12]) + `</td>
        <td>` + (list_expenses[i][3] == null ? 0 : list_expenses[i][3]) + `</td>
        <td>` + (list_expenses[i][4] == null ? 0 : list_expenses[i][4]) + `</td>
        <td>` + (list_expenses[i][5] == null ? 0 : list_expenses[i][5]) + `</td>
        <td>` + (list_expenses[i][6] == null ? 0 : list_expenses[i][6]) + `</td>
        <td>` + (list_expenses[i][7] == null ? 0 : list_expenses[i][7]) + `</td>
        <td>` + (list_expenses[i][9] == null ? 0 : list_expenses[i][9]) + `</td>
        <td>` + list_expenses[i][10] + `</td>
        <td>` + list_expenses[i][11] + `</td>
        <td> 
          <a class="ls-ico-pencil ls-btn-dark" style="background-color: blue;" href="expense/edit/` + list_expenses[i][0] + `"></a>
          <a class="ls-ico-remove ls-btn-primary-danger" href="expense/delete/` + list_expenses[i][0] + `"></a>
        </td>
      </tr>
      `;
  }
</script>
<script>
  $(document).ready(function() {
    $('#tableexpenses').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'copyHtml5',
        'excelHtml5',
        'csvHtml5',
        {
          extend: 'pdfHtml5',
          orientation: 'landscape',
        }
      ]
    });
  });
</script>

@stop