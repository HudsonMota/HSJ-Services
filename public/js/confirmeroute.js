function search(mapRoute, selectId, fieldSelectId) {
    btnValidator = document.getElementById("btnValidator");

    $('#registerNewAddress').addClass('ls-modal ls-opened')
        .attr('data-backdrop', 'static')
        .attr('data-keyboard', 'false')
        .attr('data-modal-blocked', '')
        .attr('aria-hidden', 'false')
        .attr('role', 'dialog')
        .attr('tabindex', '-1');

    resetInput()
    btnValidator.onclick = function () { formValid(mapRoute, selectId, fieldSelectId) };
}

function resetInput() {
    var publicPlace = document.getElementById("publicPlace");
    var numberPoint = document.getElementById("numberPoint");
    var neighborhood = document.getElementById("neighborhood");
    var city = document.getElementById("city");
    var list = document.getElementById("list-address")
    publicPlace.value = '';
    numberPoint.value = '';
    neighborhood.value = '';
    city.value = '';
    list.innerHTML = '';
    document.getElementById("publicPlaceMessageError").innerHTML = "";
    document.getElementById("neighborhoodMessageError").innerHTML = "";
    document.getElementById("cityMessageError").innerHTML = "";
    document.getElementById("inputAddressMessageError").innerHTML = "";
}

function dismissModal() {
    $('#registerNewAddress').removeClass('ls-opened');
}

function dismissModalLoader() {
    $('#loader').removeClass('ls-opened');
}

function formValid(mapRoute, selectId, fieldSelectId) {
    var publicPlace = document.getElementById("publicPlace");
    var numberPoint = document.getElementById("numberPoint");
    var neighborhood = document.getElementById("neighborhood");
    var city = document.getElementById("city");

    var addressValidated = `${publicPlace.value} ${numberPoint.value} - ${neighborhood.value}, ${city.value} - CE`;
    var comparatedAddress = `${publicPlace.value} - ${neighborhood.value}, ${city.value} - CE`;

    var resultStringAdress = document.searchAddress.resultAddress.value;
    var logradouro = publicPlace.value;

    var awaitAddress = document.getElementById(fieldSelectId)

    console.log(resultStringAdress.includes(logradouro))
    console.log(resultStringAdress)
    console.log(logradouro)
    

    if (resultStringAdress) {
        if (
            !publicPlace.checkValidity()
            || !neighborhood.checkValidity()
            || !city.checkValidity()
            || document.searchAddress.resultAddress.checked == false
        ) {
            console.log(`If ---------------------`)
            document.getElementById("publicPlaceMessageError").innerHTML = publicPlace.validationMessage;
            document.getElementById("neighborhoodMessageError").innerHTML = neighborhood.validationMessage;
            document.getElementById("cityMessageError").innerHTML = city.validationMessage;
            if (document.searchAddress.resultAddress.checked == false) {
                console.log(`If -> If ---------------------`)
                document.getElementById("inputAddressMessageError").innerHTML = `Selecione o edereço correto.`;
            }
        } else if (!resultStringAdress.includes(logradouro)) {
            console.log(`Else if ---------------------`)
            document.getElementById("inputAddressMessageError").innerHTML = `Os endereços não são iguais! Preencha o formulário, clique em pesquisar e marque o endereço correto na lista de resultados`;
        } else {
            console.log(`Else ---------------------`)
            document.getElementById("publicPlaceMessageError").innerHTML = "";
            document.getElementById("neighborhoodMessageError").innerHTML = "";
            document.getElementById("cityMessageError").innerHTML = "";
            document.getElementById("inputAddressMessageError").innerHTML = "";
            awaitAddress.value = addressValidated;
            awaitAddress.text = addressValidated;
            document.getElementById(selectId).value = addressValidated;
            mapear(mapRoute);
            dismissModal();
        }
    } else {
        if (
            !publicPlace.checkValidity()
            || !neighborhood.checkValidity()
            || !city.checkValidity()
        ) {
            document.getElementById("publicPlaceMessageError").innerHTML = publicPlace.validationMessage;
            document.getElementById("neighborhoodMessageError").innerHTML = neighborhood.validationMessage;
            document.getElementById("cityMessageError").innerHTML = city.validationMessage;
        } else {
            document.getElementById("publicPlaceMessageError").innerHTML = "";
            document.getElementById("neighborhoodMessageError").innerHTML = "";
            document.getElementById("cityMessageError").innerHTML = "";
            document.getElementById("inputAddressMessageError").innerHTML = "";
            document.getElementById("inputAddressMessageError").innerHTML = `Clique em pesquisar antes e confirme o endereço`;
        }
    }
}

function verifyAddress() {
    setTimeout(function () {
        $('#loader').addClass('ls-modal ls-opened')
        .attr('data-backdrop', 'static')
        .attr('data-keyboard', 'false')
        .attr('data-modal-blocked', '')
        .attr('aria-hidden', 'false')
        .attr('role', 'dialog')
        .attr('tabindex', '-1');
    });

    var publicPlace = document.getElementById("publicPlace");
    var neighborhood = document.getElementById("neighborhood");
    var city = document.getElementById("city");
    var list = document.getElementById("list-address")

    document.getElementById("inputAddressMessageError").innerHTML = '';

    list.innerHTML = '';
    (async () => {
        const where = encodeURIComponent(JSON.stringify({
            "CEP": {
                "$exists": true
            },
            "logradouro": {
                "$regex": `${publicPlace.value}`
            },
            "bairro": {
                "$regex": `${neighborhood.value}`
            },
            "cidade": {
                "$regex": `${city.value}`
            },
            "estado": {
                "$regex": `CE`
            }
        }));

        const response = await fetch(
            `https://parseapi.back4app.com/classes/Cepcorreios_CEP?order=logradouro,numero&where=${where}`,
            {
                headers: {
                    'X-Parse-Application-Id': 'HOxsKJKX4pMCPj8mlONa3ZlEO3nascw1hpiev4Ob', // This is your app's application id
                    'X-Parse-REST-API-Key': '5EruqeHQgoUkhAMp4iSBD3Q6Z5h9lDo40L8Brb2H', // This is your app's REST API key
                }
            }
        );
        const data = await response.json(); // Here you have the data that you need
        // console.log(JSON.stringify(data, null, 2));

        if (data.results.length > 0) {
            list.setAttribute('class', 'ls-alert-info')
            data.results.forEach(address => {
                var stringAddress = `${address.logradouro} - ${address.bairro}, ${address.cidade} - ${address.estado}, ${address.CEP}`
                list.innerHTML += '<input type="radio" class="resultAddress" name="resultAddress" id="' + stringAddress + '" name="addr" value="' + stringAddress + '"> <label for="' + stringAddress + '">' + stringAddress + '</label><br>'

                setTimeout(function () {
                    dismissModalLoader();
                }, 500);
            })
        } else {
            list.setAttribute('class', 'ls-alert-danger');
            list.innerHTML = `<label>Endereço NÃO encontrado! Digite um endereço válido.</label>`

            setTimeout(function () {
                dismissModalLoader();
            }, 0);
        }
    })();
}

function mapear(mapRoute) {
    var selectOrigemAddress = document.getElementById("txtOrigem[" + mapRoute + "]").value
    var selectDestinoAddress = document.getElementById("txtDestino[" + mapRoute + "]").value
    var mapGoogle = document.getElementById("map[" + mapRoute + "]")

    mapGoogle.setAttribute('src', '');
    mapGoogle.setAttribute('src', 'https://maps.google.com/maps?saddr=' + selectOrigemAddress + '&daddr=' + selectDestinoAddress + '&output=embed');
}