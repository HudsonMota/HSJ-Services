function enableOrDisableForm01(val) {
    var materiais = document.getElementById("materiais-fin["+ val +"]");
    var adm = document.getElementById("adm-fin["+ val +"]");
    var unidade = document.getElementById("unidade["+ val +"]");
    var leito = document.getElementById("leito["+ val +"]");
    var sltmotivo = document.getElementById("sltmotivo["+ val +"]");
    var estadopaciente = document.getElementById("estadopaciente["+ val +"]");
    materiais.disabled = true;
    adm.disabled = true;
    unidade.disabled = false;
    leito.disabled = false;
    sltmotivo.disabled = false;
    estadopaciente.disabled = false;
}

function enableOrDisableForm02(val) {
    var materiais = document.getElementById("materiais-fin["+ val +"]");
    var adm = document.getElementById("adm-fin["+ val +"]");
    var unidade = document.getElementById("unidade["+ val +"]");
    var leito = document.getElementById("leito["+ val +"]");
    var sltmotivo = document.getElementById("sltmotivo["+ val +"]");
    var estadopaciente = document.getElementById("estadopaciente["+ val +"]");
    materiais.disabled = false;
    adm.disabled = true;
    unidade.disabled = true;
    leito.disabled = true;
    sltmotivo.disabled = true;
    estadopaciente.disabled = true;
}

function enableOrDisableForm03(val) {
    var materiais = document.getElementById("materiais-fin["+ val +"]");
    var adm = document.getElementById("adm-fin["+ val +"]");
    var unidade = document.getElementById("unidade["+ val +"]");
    var leito = document.getElementById("leito["+ val +"]");
    var sltmotivo = document.getElementById("sltmotivo["+ val +"]");
    var estadopaciente = document.getElementById("estadopaciente["+ val +"]");
    materiais.disabled = true;
    adm.disabled = false;
    unidade.disabled = true;
    leito.disabled = true;
    sltmotivo.disabled = true;
    estadopaciente.disabled = true;
}