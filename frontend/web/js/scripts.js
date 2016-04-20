$(document).ready(function()	{
    
    $('#print_pdf').on('click',function(){   
        $(this).hide();
        $('footer').next('div').hide();
        $('footer').hide();
        window.print(); 
        $(this).show();
        $('footer').show();
        $('footer').next('div').show();
    });
        reloadMath = function(math){
         MathJax.Hub.Queue(["Typeset",MathJax.Hub,math]); 
     };

      $('body').bind("DOMSubtreeModified",function(){
        reloadMath(document.getElementsByTagName("body"));
    }); 

        $('body').delegate('.modalButton','click',function(){
        $('#modal').modal('show').find('#modalContent').html("").load($(this).attr('value'), function(){
            
        });
        
    });
    (function () {
            var QUEUE = MathJax.Hub.queue;
            var math = null; 
            QUEUE.Push(function () {
              math = MathJax.Hub.getAllJax("math-tex")[0];
            });
            window.UpdateMath = function (TeX) {
              QUEUE.Push(["Text",math,"\\displaystyle{"+TeX+"}"]);
            }
          })();   

});