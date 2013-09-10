$(document).ready(function (){
   $('#form1').validate({
       rules:{
           titulo :{
               required: true
           },
           cuerpo :{
               required: true
           }
       },
       messages:{
           titulo: {
               required: "Debe ingresar el título para el post"
           }, 
           cuerpo: {
               required: "El cuerpo del post debe tener texto"
           }
       }
   });
});