var supply = document.getElementById("supply");
var maintenance = document.getElementById("maintenance");

function maintenanceOrSupply(value) {
    supply.innerHTML = '';

    if (value == 1) {
        maintenance.innerHTML = '';
        supply.innerHTML =
            `
    <div class="col-md-12">

    <!-- QUANTIDADE LITROS-->
    <div class="form-group col-md-2">
        <label class="ls-label col-md-12">
            <b class="ls-label-text">Quantidade abastecida em Litros<strong>(L)</strong></b>
            <input name="supply_in_liters" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode <= 46 || event.charCode <= 44' maxlength="9" step="any" class="ls-no-spin form-control" value="" required oninvalid="this.setCustomValidity('Informe quantos litros foram abastecidos!')" onchange="try{setCustomValidity('')}catch(e){}">
        </label>
    </div>

    <!-- VALOR ABASTECIDO -->
    <div class="form-group col-md-2">
        <label class="ls-label col-md-12">
            <b class="ls-label-text">Valor total do abastecimento<strong>(R$)</strong></b>
            <input name="total_value_supply" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode <= 46 || event.charCode <= 44' maxlength="9" step="any" name="unitary_value" class="ls-no-spin form-control" value="" maxlength="5" required oninvalid="this.setCustomValidity('Informe o valor total do abastecimento!')" onchange="try{setCustomValidity('')}catch(e){}">
        </label>
    </div>

    <!-- QUILOMETRAGEM ANTERIOR -->
    <div class="form-group col-md-2">
        <label class="ls-label col-md-12">
            <b class="ls-label-text">Quilometragem anterior<strong>(Km)</strong></b>
            <input name="previous_mileage" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control" id="kminicial" maxlength="6" autocomplete="off" required oninvalid="this.setCustomValidity('Informe a quilometragem inicial!')" onchange="try{setCustomValidity('')}catch(e){}">
        </label>
    </div>

    <!-- QUILOMETRAGEM ATUAL -->
    <div class="form-group col-md-2">
        <label class="ls-label col-md-12">
            <b class="ls-label-text">Quilometragem atual<strong>(Km)</strong></b>
            <input name="current_mileage" oninput="kmValidation()" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control" id="kmfinal" maxlength="6" autocomplete="off" required>
        </label>
    </div>
</div>

<div class="col-md-12">

    <!-- DATA DO ABASTACEIMENTO -->
    <div class="form-group col-md-2">
        <label class="ls-label col-md-12">
            <b class="ls-label-text">Data</b>
            <input name="date" class="ls-no-spin" type="date" value="" required oninvalid="this.setCustomValidity('Informe a data do abastecimento!')" onchange="try{setCustomValidity('')}catch(e){}">
        </label>
    </div>

    <!-- HORA DO ABASTECIMENTO -->
    <div class="form-group col-md-2">
        <label class="ls-label col-md-12">
            <b class="ls-label-text">Hora</b>
            <input name="time" class="ls-no-spin" type="time" value="" required oninvalid="this.setCustomValidity('Informe a hora do abastecimento!')" onchange="try{setCustomValidity('')}catch(e){}">
        </label>
    </div>

    <!-- DESCRIÇÃO -->
    <div class="form-group col-md-4">
        <label class="ls-label col-md-12">
            <b class="ls-label-text">Descrição:</b>
            <input name="description" type="text" value="">
        </label>
    </div>
</div>
        `
    } else if (value == 3) {
        supply.innerHTML = '';
        maintenance.innerHTML =
            `
        <div class="form-group col-md-12">

        <!-- VALOR ABASTECIDO -->
        <div class="form-group col-md-4">
            <label class="ls-label col-md-12">
            <b class="ls-label-text">Valor total do Serviço<strong>(R$)</strong></b>
            <input name="total_value_supply" type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode <= 46 || event.charCode <= 44' maxlength="9" step="any" name="unitary_value" class="ls-no-spin form-control" value="" maxlength="5" required oninvalid="this.setCustomValidity('Informe o valor total do abastecimento!')" onchange="try{setCustomValidity('')}catch(e){}">
            </label>
        </div>

        <!-- DATA DO ABASTACEIMENTO -->
        <div class="form-group col-md-2">
            <label class="ls-label col-md-12">
            <b class="ls-label-text">Data</b>
            <input name="date" class="ls-no-spin" type="date" value="" required oninvalid="this.setCustomValidity('Informe a data do abastecimento!')" onchange="try{setCustomValidity('')}catch(e){}">
            </label>
        </div>

        <!-- HORA DO ABASTECIMENTO -->
        <div class="form-group col-md-2">
            <label class="ls-label col-md-12">
            <b class="ls-label-text">Hora</b>
            <input name="time" class="ls-no-spin" type="time" value="" required oninvalid="this.setCustomValidity('Informe a hora do abastecimento!')" onchange="try{setCustomValidity('')}catch(e){}">
            </label>
        </div>
        </div>

        <div class="form-group col-md-12">
        <!-- DESCRIÇÃO -->
        <div class="form-group col-md-4">
            <label class="ls-label col-md-12">
            <b class="ls-label-text">Descrição:</b>
            <input name="description" type="text" value="">
            </label>
        </div>
        </div>
        `
    } else {
        supply.innerHTML = '';
        maintenance.innerHTML = '';
    }
}