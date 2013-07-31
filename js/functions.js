function setSub(drop){
    var subest = $(drop).val();
    var oldURL = $('#verSub').attr('href');
    var indice = oldURL.lastIndexOf("/");
    var newURL = oldURL.substring(0,indice) + "/" + subest;
    $('#verSub').attr('href' , newURL);
}

function showMsg(id, tipo, msj){
    switch(tipo){
        case 'aceptar':
            $('#'+id).empty();
            $('#'+id).html('<p>' + msj + '</p><input type="button" onclick="javascript:close_modal();" value="Aceptar" />');
            break;
    }
    $.blockUI({ 
        fadeIn: 1000,
        message: $('#'+id)
    }); 
}

function close_modal(){
    $.unblockUI();
}

