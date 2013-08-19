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
    if(id===''){
        id='modal_msj';
    }
    switch(tipo){
        case 'aceptar':
            $('#'+id).empty();
            $('#'+id).html('<p>' + msj + '</p><input type="button" onclick="javascript:close_modal();" value="Aceptar" /><br>');
            break;
        case 'loading':
            $('#'+id).empty();
            $('#'+id).html('<div style="margin: 10px 10px 10px 10px; height:50px;"><img style="width: 50px; height: 50px; float: left; margin-right: 15px;" src="' + base_url + 'ajax-loader-circle.gif" /><div style="height: 50px;"><div style="display:block; height: 15px;"></div>' + msj + '</div></div>');
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
   var bits = s.split('-');
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
 
 function isAlphanumeric(texto){
    var myRegxp = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,12})$/;
    if(myRegxp.test(texto) == false)
    {
        return false;
    }else{
        return true;
    }
 }
 
 function validUser(user){
    var myRegxp = /^[a-zA-Z0-9]{6,10}$/;
    if(myRegxp.test(user) == false)
    {
        return false;
    }else{
        return true;
    }
 }
 
 function submitLogin(){
     var user = $("#user").val();
     var pass = $("#password").val();
     var band = 0;
     var msj='';
     if(!validUser(user)){
         msj= msj + '<li>Verifique el formato de su usuario</li>';
         band=1;
     }
     
     if(!isAlphanumeric(pass)){
         msj= msj + '<li>Verifique el formato de su password</li>';
         band=1;
     }
     
     if(band===0){
         $("#loginForm").submit();
         return true;
     }else{
         showMsg('','aceptar','<ul>'+msj+'</ul>');
         return true;
     }
 }
 
 function submitCambio(){
     var user = $("#user").val();
     var passold = $("#passOld").val();
     var passNew1 = $("#passNew1").val();
     var passNew2 = $("#passNew2").val();
     var band = 0;
     var msj='';
     if(!validUser(user)){
         msj= msj + '<li>Verifique el formato de su usuario</li>';
         band=1;
     }
     
     if(!isAlphanumeric(passold)){
         msj= msj + '<li>Verifique el formato de su password antiguo</li>';
         band=1;
     }
     if (passNew1 === passNew2){
     if(!isAlphanumeric(passNew1)){
         msj= msj + '<li>Verifique el formato de su  nuevo password</li>';
         band=1;
     }
     }else{
         msj= msj + '<li>Verifique la confirmacion de su password</li>';
         band=1;
     }
     
     if(band===0){
         $("#cambioForm").submit();
         return true;
     }else{
         showMsg('','aceptar','<ul>'+msj+'</ul>');
         return false;
     }
 }


