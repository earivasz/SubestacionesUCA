var base_url = 'http://localhost:8080/SubestacionesUCA/index.php/';

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
        case 'loading':
            $('#'+id).empty();
            $('#'+id).html('<p>' + msj + '</p>');
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

function fechaValida(s) {
   var bits = s.split('/');
   var d = new Date(bits[2] + '/' + bits[1] + '/' + bits[0]);
   return !!(d && (d.getMonth() + 1) == bits[1] && d.getDate() == Number(bits[0]) && d.getYear() < 1099 && d.getYear() > 0);
}
  
 function validaFecha(CtrlSDate,CtrlEDate)
 {
     if(fechaValida(CtrlSDate) && fechaValida(CtrlEDate)){
        var endDate = new Date(CtrlEDate); 
        var startDate= new Date(CtrlSDate);
        if(startDate > endDate)
         {
                //la fecha de inicio es mayor a la de final
                return false;
         }
         else{
             return true;
         }
     }
     else{
         return false;
     }
 }


