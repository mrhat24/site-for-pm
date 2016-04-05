$(document).ready(function()	{
    //$('.markItUp').markItUp(myTextileSettings);    
   
        $('body').delegate('.modalButton','click',function(){
        $('#modal').modal('show').find('#modalContent').load($(this).attr('value'));                 
    });
    
});