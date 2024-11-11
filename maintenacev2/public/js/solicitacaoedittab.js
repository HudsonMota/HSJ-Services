

    var ahome = document.getElementById("pills-home-tab");
    var aprofile = document.getElementById("pills-profile-tab");
    var acontact = document.getElementById("pills-contact-tab");
    var pillshome = document.getElementById("pills-home");
    var pillsprofile = document.getElementById("pills-profile");
    var pillscontact = document.getElementById("pills-contact");
    var unidade = document.getElementById("unidade");
    var leito = document.getElementById("leito");
    var sltmotivo = document.getElementById("sltmotivo");
    var estadopaciente = document.getElementById("estadopaciente");
    var materiais = document.getElementById("materiais-fin");
    var adm = document.getElementById("adm-fin");

    if (requestcar.leito == null && requestcar.materiaisfin == null) {
        ahome.classList.remove('active');
        aprofile.classList.remove('active');
        acontact.classList.add('active');
        pillshome.classList.remove('active');
        pillsprofile.classList.remove('active');
        pillscontact.classList.add('active');
        pillshome.classList.remove('show');
        pillsprofile.classList.remove('show');
        pillscontact.classList.add('show');
        unidade.disabled = true;
        leito.disabled = true;
        sltmotivo.disabled = true;
        estadopaciente.disabled = true;
        materiais.disabled = true;
        adm.disabled = false;
    } else if (requestcar.leito == null && requestcar.admfin == null){
        ahome.classList.remove('active');
        aprofile.classList.add('active');
        acontact.classList.remove('active');
        pillshome.classList.remove('active');
        pillsprofile.classList.add('active');
        pillscontact.classList.remove('active');
        pillshome.classList.remove('show');
        pillsprofile.classList.add('show');
        pillscontact.classList.remove('show');
        unidade.disabled = true;
        leito.disabled = true;
        sltmotivo.disabled = true;
        estadopaciente.disabled = true;
        materiais.disabled = false;
        adm.disabled = true;
    } else if(requestcar.materiaisfin == null && requestcar.admfin == null) {
        ahome.classList.add('active');
        aprofile.classList.remove('active');
        acontact.classList.remove('active');
        pillshome.classList.add('active');
        pillsprofile.classList.remove('active');
        pillscontact.classList.remove('active');
        pillshome.classList.add('show');
        pillsprofile.classList.remove('show');
        pillscontact.classList.remove('show');
        unidade.disabled = false;
        leito.disabled = false;
        sltmotivo.disabled = false;
        estadopaciente.disabled = false;
        materiais.disabled = true;
        adm.disabled = true;
    }