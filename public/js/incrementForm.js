$limit = 3;
$form2 = document.getElementById("form2");
$form3 = document.getElementById("form3");
$form4 = document.getElementById("form4");
$msg = document.getElementById("msg");
$btnIncrement1 = document.getElementById("btnIncrement1");
$btnIncrement = '<input id="btnIncrement" type="button" onclick="incrementForm(), loadOptionsAutoCompleteSelect()" class="btn btn-info" style="font-weight: bold;" value="Adcionar Solicitante">';
$btnDecrement = '<input id="btnDecrement" type="button" onclick="decrementForm()" class="btn btn-warning" style="font-weight: bold;" value="Remover Solicitante">';
$removePassenger = document.getElementById("removePassenger");
$addPassenger = document.getElementById("addPassenger");
$sectorselect = document.getElementById("setorsolicitante[0]");
$optionsslt = [];
$option = [];

function incrementForm() {
    switch ($limit) {
        case 3:
            $form2.innerHTML = formHTML[1];
            $addPassenger.innerHTML = $btnIncrement;
            $removePassenger.innerHTML = $btnDecrement;
            $opt = [];

            for (i = 0; i < $sectorselect.length; i = i + 1) {
                $optionsslt[i] = $sectorselect.options[i]
                $option[i] = new Option($sectorselect.options[i].text, $sectorselect.options[i].value);
                $sectorselect1 = document.getElementById("setorsolicitante[1]");
                $sectorselect1.options[i] = $option[i];
            }

            $limit--;
            break;
        case 2:
            $form3.innerHTML = formHTML[2];
            $opt = [];

            for (i = 0; i < $sectorselect.length; i = i + 1) {
                $optionsslt[i] = $sectorselect.options[i]
                $option[i] = new Option($sectorselect.options[i].text, $sectorselect.options[i].value);
                $sectorselect2 = document.getElementById("setorsolicitante[2]");
                $sectorselect2.options[i] = $option[i];
            }

            $limit--;
            break;
        case 1:
            $form4.innerHTML = formHTML[3];
            $addPassenger.innerHTML = '';
            $opt = [];

            for (i = 0; i < $sectorselect.length; i = i + 1) {
                $optionsslt[i] = $sectorselect.options[i]
                $option[i] = new Option($sectorselect.options[i].text, $sectorselect.options[i].value);
                $sectorselect3 = document.getElementById("setorsolicitante[3]");
                $sectorselect3.options[i] = $option[i];
            }

            $limit--;
            break;
        default:
            console.log("Erro! Não é possível incrementar formulário!");
    }
}

function decrementForm() {
    switch ($limit) {
        case 2:
            $form2.innerHTML = '';
            $removePassenger.innerHTML = '';
            $limit++;
            break;
        case 1:
            $form3.innerHTML = ''
            $limit++;
            break;
        case 0:
            $form4.innerHTML = ''
            addPassenger.innerHTML = $btnIncrement;
            $limit++;
            break;
        default:
            console.log("Erro! Não é possível decrementar formulário!");
    }
}
