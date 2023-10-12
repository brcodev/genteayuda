const URL="https://genteayuda.site/",server="https://genteayuda.site/";$(document).ready(function(){$("#simbolo").on("click",function(){$(".zonas").slideToggle()}),$(".menu-movil").on("click",function(){$(".navegacion-principal").slideToggle()}),$(window).resize(function(){755<$(".barra").width()?$(".navegacion-principal").css({display:""}):$(".navegacion-principal").css({display:"none"})}),$(".next").on("click",function(){var e=$(".active"),t=e.next();t.length&&(e.removeClass("active").css("z-index",-10),t.addClass("active").css("z-index",10))}),$(".prev").on("click",function(){var e=$(".active"),t=e.prev();t.length&&(e.removeClass("active").css("z-index",-10),t.addClass("active").css("z-index",10))}),$(window).on("resize",function(){var e=$("#loadingModal").find(".modal-content"),t=$(window).width(),o=$(window).height(),i=e.outerWidth(),n=e.outerHeight();e.css({top:(o-n)/2+"px",left:(t-i)/2+"px"})}),$("#orgForm").on("submit",function(e){e.preventDefault();var t=document.getElementById("orgForm"),o=t.nombres.value.trim(),i=t.apellidos.value.trim(),n=t.nombre_org.value.trim(),a=t.region.value,r=t.querySelectorAll('input[name="ayuda"]:checked'),l=t.correo.value.trim(),e=t.telefono.value.trim(),t=t.asunto.value.trim();if(!o.match(/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]+(\s[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]+)?$/))return Swal.fire({icon:"warning",title:"Revisa los datos",text:"El campo Nombres tiene un formato inválido."}),!1;if(!i.match(/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]+(\s[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]+)?$/))return Swal.fire({icon:"warning",title:"Revisa los datos",text:"El campo Apellidos tiene un formato inválido."}),!1;if(!n.match(/^[a-zA-Z\dñÑáéíóúÁÉÍÓÚüÜ]+(\s[a-zA-Z\dñÑáéíóúÁÉÍÓÚüÜ]+)*$/))return Swal.fire({icon:"warning",title:"Revisa los datos",text:"El Nombre de la organización tiene un formato inválido."}),!1;if(""===a)return Swal.fire({icon:"warning",title:"Revisa los datos",text:"Debes seleccionar una Región."}),!1;if(0===r.length)return Swal.fire({icon:"warning",title:"Revisa los datos",text:"Debe seleccionar el tipo de ayuda entregada."}),!1;if(!l.match(/^\S+@\S+\.\S+$/))return Swal.fire({icon:"warning",title:"Revisa los datos",text:"Se necesita un Correo de contacto valido."}),!1;if(!e.match(/^[0-9]{9}$/))return Swal.fire({icon:"warning",title:"Revisa los datos",text:"El campo Teléfono debe contener 9 digitos."}),!1;if(""===t.trim())return Swal.fire({icon:"warning",title:"Revisa los datos",text:"Se necesita una breve descripción del objetivo que tiene tu organización a inscribir."}),!1;var s=$("#loadingModal");s.show(),$(window).trigger("resize");t=$(this).serializeArray();$.ajax({type:$(this).attr("method"),url:$(this).attr("action"),data:t,dataType:"json",success:function(e){console.log(e.result),s.hide(),e.result?("org"===e.type&&($tittle="Solicitud de inscripción recibida.",$text="Recibirás mas información al correo ingresado."),Swal.fire({icon:"success",title:$tittle,text:$text}).then(()=>{setTimeout(()=>{window.location.reload()},100)})):Swal.fire({icon:"error",title:"No fue posible enviar el formulario.",text:"Lo sentimos, intente nuevamente, también verifique que completo los campos obligatorios."}).then(()=>{setTimeout(()=>{window.location.reload()},100)})}})}),$("#contactSent").on("submit",function(e){e.preventDefault();var t=document.getElementById("contactSent"),o=t.nombre.value.trim(),i=t.apellido.value.trim(),n=t.mail.value.trim(),e=t.tipo.value,t=t.mensaje.value.trim();if(!o.match(/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]+(\s[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]+)?$/))return Swal.fire({icon:"warning",title:"Revisa los datos",text:"El campo Nombre tiene un formato inválido."}),!1;if(!i.match(/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]+(\s[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]+)?$/))return Swal.fire({icon:"warning",title:"Revisa los datos",text:"El campo Apellido tiene un formato inválido."}),!1;if(!n.match(/^\S+@\S+\.\S+$/))return Swal.fire({icon:"warning",title:"Revisa los datos",text:"Se necesita un Correo valido."}),!1;if(0===e.length)return Swal.fire({icon:"warning",title:"Revisa los datos",text:"Debe seleccionar el tipo de mensaje a enviar."}),!1;if(""===t.trim())return Swal.fire({icon:"warning",title:"Revisa los datos",text:"Se necesita una breve descripción"}),!1;var a=$("#loadingModal");a.show(),$(window).trigger("resize");t=$(this).serializeArray();$.ajax({type:$(this).attr("method"),url:$(this).attr("action"),data:t,dataType:"json",success:function(e){console.log(e.result),a.hide(),e.result?("sugge"===e.type?($tittle="Se ha enviado la sugerencia.",$text="Gracias por escribirnos, tendremos la sugerencia en consideración para mejorar!"):"claim"===e.type&&($tittle="Se ha enviado el reclamo.",$text="Tu reclamo fue recibido, dentro de los próximos días nuestro equipo te contactara para resolver el problema."),Swal.fire({icon:"success",title:$tittle,text:$text}).then(()=>{setTimeout(()=>{window.location.reload()},100)})):Swal.fire({icon:"error",title:"No fue posible enviar el formulario.",text:"Lo sentimos, intente nuevamente, también verifique que completo los campos obligatorios."}).then(()=>{setTimeout(()=>{window.location.reload()},100)})}})}),$("#sentForm").on("submit",function(e){e.preventDefault();var t=document.getElementById("sentForm"),o=t.nombre.value.trim(),i=t.apellido.value.trim(),n=t.region.value.trim(),a=$('input[name="ayuda[]"]:checked'),e=t.correo.value.trim(),t=t.telefono.value.trim();if(""!==o)if(!o.match(/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]+(\s[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]+)?$/))return Swal.fire({icon:"warning",title:"Revisa los datos",text:"El campo Nombre tiene un formato inválido."}),!1;if(""!==i)if(!i.match(/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]+(\s[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ]+)?$/))return Swal.fire({icon:"warning",title:"Revisa los datos",text:"El campo Apellido tiene un formato inválido."}),!1;if(""===n)return Swal.fire({icon:"warning",title:"Revisa los datos",text:"Debes seleccionar una Región."}),!1;if(0===a.length)return Swal.fire({icon:"warning",title:"Selecciona al menos una opción de ayuda",text:"Como mínimo debe haber al menos una opción marcada (Puede ser más de una opción)."}),!1;if(!e.match(/^\S+@\S+\.\S+$/))return Swal.fire({icon:"warning",title:"Revisa los datos",text:"Se necesita un correo valido para enviar la información."}),!1;if(""!==t)if(!t.match(/^[0-9]{9}$/))return alert("El campo Teléfono tiene un formato inválido."),Swal.fire({icon:"warning",title:"Revisa los datos",text:"El campo Teléfono debe contener 9 dígitos"}),!1;$tittle="Se ha enviado la solicitud de información.",$text="Recibirá un correo con información de organizaciones que prestan ayuda de la cual busca.";var r=$("#loadingModal");r.show(),$(window).trigger("resize");t=$(this).serializeArray();$.ajax({type:$(this).attr("method"),url:$(this).attr("action"),data:t,dataType:"json",success:function(e){console.log(e.result),r.hide(),(e.result?Swal.fire({icon:"success",title:$tittle,text:$text}):Swal.fire({icon:"error",title:"No fue posible enviar el formulario.",text:"Lo sentimos, intente nuevamente, también verifique que completo los campos obligatorios."})).then(()=>{setTimeout(()=>{window.location.reload()},100)})}})});var s=!1,c=!1;$(document.body).on("touchmove",function(){if(c)return;var e=$(".nombre-evento").attr("catID"),t=$(".load-more").attr("lastID"),o=$(".load-more").attr("lasteventID"),i=$(".load-more").attr("zonaID"),n=$(".nombre-evento").attr("data-page"),a=$(".load-more").data("csrf"),r=window.innerHeight,l=document.body.scrollHeight;window.scrollY+r>=l-500&&!s&&0!=o&&0!=t&&(c=!0,$.ajax({type:"POST",url:server+n,data:{zona:i,id:t,eventoid:o,cat:e,csrf:a},beforeSend:function(e){$(".load-more").show()},success:function(e){$(".load-more").remove(),$("#postList").append(e)},complete:function(){c=!1}}))});s=!1;$(document).on("click",".zona",function(e){var t=$(this).attr("id"),o=$(this).attr("data-event"),i=$(this).data("csrf"),n=$(".nombre-evento").attr("catID");$(".error-zone").remove(),$(".error-zone-none").remove(),s=!0,$.ajax({type:"post",data:{zona:t,cat:n,event:o,csrf:i},url:server+"zone",beforeSend:function(e){$(".load-more").remove(),$(".entrada-blog").fadeOut(800,function(){$(this).remove()})},success:function(e){$(".load-more").remove(),$("#postList").append(e),$(".entrada-blog").hide(),$(".entrada-blog").fadeIn(800,function(){$(this).show()}),s=!1}})}),$(document).on("click",".zona-evento",function(e){var t=$(this).attr("id"),o=($(".nombre-evento").attr("catID"),$(this).data("data-csrf"));s=!0,$.ajax({type:"post",data:{zona:t,csrf:o},url:server+"zone",beforeSend:function(e){$(".load-more").remove(),$(".entrada-blog").fadeOut(800,function(){$(this).remove()})},success:function(e){$(".load-more").remove(),$("#postList").append(e),$(".entrada-blog").hide(),$(".entrada-blog").fadeIn(800,function(){$(this).show()}),s=!1}})})});var inputField=document.querySelector(".chosen-value"),dropdown=document.querySelector(".value-list"),dropdownArray=[].concat(document.querySelectorAll("li")),dropdownItems=dropdownArray[0],valueArray=[];dropdownItems.forEach(function(e){valueArray.push(e.textContent)});var closeDropdown=function(){dropdown.classList.remove("open")};inputField.addEventListener("input",function(){dropdown.classList.add("open");var e=inputField.value.toLowerCase();if(0<e.length)for(var t=0;t<valueArray.length;t++)e.substring(0,e.length)!==valueArray[t].substring(0,e.length).toLowerCase()?dropdownItems[t].classList.add("closed"):dropdownItems[t].classList.remove("closed");else for(var o=0;o<dropdownItems.length;o++)dropdownItems[o].classList.remove("closed")}),dropdownItems.forEach(function(t){t.addEventListener("click",function(e){inputField.value=t.textContent,dropdownItems.forEach(function(e){e.classList.add("closed")})})}),inputField.addEventListener("focus",function(){inputField.placeholder="Buscar Región",dropdown.classList.add("open"),dropdownItems.forEach(function(e){e.classList.remove("closed")})}),inputField.addEventListener("blur",function(){inputField.placeholder="Selecciona Región",dropdown.classList.remove("open")}),document.addEventListener("click",function(e){var t=dropdown.contains(e.target),e=inputField.contains(e.target);t||e||dropdown.classList.remove("open")});
