var base_url = 'http://localhost:8080/SubestacionesUCA/';

function setSub(drop){
    var subest = $(drop).val();
    var oldURL = $('#verSub').attr('href');
    var indice = oldURL.lastIndexOf("/");
    var newURL = oldURL.substring(0,indice) + "/" + subest;
    $('#verSub').attr('href' , newURL);
}

function isNumber(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function showMsg(id, tipo, msj){
    switch(tipo){
        case 'aceptar':
            $('#'+id).empty();
            $('#'+id).html('<p>' + msj + '</p><input type="button" onclick="javascript:close_modal();" value="Aceptar" /><br>');
            break;
        case 'loading':
            $('#'+id).empty();
            $('#'+id).html('<div style="margin: 10px 10px 10px 10px; height:50px;"><img style="width: 50px; height: 50px; float: left; margin-right: 15px;" src="' + base_url + 'img/ajax-loader-circle.gif" /><div style="height: 50px;"><div style="display:block; height: 15px;"></div>' + msj + '</div></div>');
            break;       
    }
    $.blockUI({ 
        fadeIn: 300,
        message: $('#'+id)
    }); 
}

function showMsgRed(id, tipo, msj, url){
    switch(tipo){
        case 'aceptar':
            $('#'+id).empty();
            $('#'+id).html('<p>' + msj + '</p><input type="button" onclick="javascript:reloadSub(\''+ url +'\');" value="Aceptar" /><br>');
            break;       
    }
    $.blockUI({ 
        fadeIn: 300,
        message: $('#'+id)
    }); 
}

function close_modal(){
    $.unblockUI();
}
function reloadSub(url){
    //close_modal();
    window.location.href = url;
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


