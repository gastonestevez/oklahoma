// Toma el nombre del archivo que queremos subir y lo pone dentro del elemento con la clase info para que podamos verlo.
// esta funcion la utilizamos para cambiar la fachada del input file y poder seguir viendo los nombres de los archivos subidos.

function change(){
  var pdrs = document.getElementById('file-upload').files[0].name;
  document.getElementById('info').innerHTML = pdrs;
}

// le falta smooth
// Cuando el usuario clickea en el boton, se scrollea automaticamente hacia el top del documento
// function topFunction() {
//   document.body.scrollTop = 0; // For Safari
//   document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
// }

// web de lares, no puedo hacerlo andar
// $("#myBtn").click(function() {
//     showHome();
//     $('html,body').animate({ scrollTop: $("#top").offset().top - 80}, 'slow');
//   });

  function scrollToTop() {

  window.scrollTo({top: 0, behavior: 'smooth'});

  }



window.addEventListener('load',function(){




  // Stock por categoría en vista add product
  function stockPorCategoria(){
    // Selecciono el select de los talles de pantalon, el de los de tops y el div de categoria que tiene la clase hidden
    var categoryId = document.getElementById('categoryId');
    var tallesPorLetra = document.querySelectorAll('.tallesPorLetra');      //>>>>>>>getElementsByClassName<<<<<<<
    var tallesPorNumero = document.querySelectorAll('.tallesPorNumero');

      // Creo un evento que actue cuando cambia el value del input categoria
      categoryId.addEventListener('change',function(){
      if (categoryId.value==1||categoryId.value==2||categoryId.value==4||categoryId.value==5||categoryId.value==6) {


        // por cada talle de letra (xs, s, m.. etc) le quitamos a cada elemento la clase hidden
        for (talle of tallesPorLetra) {
          talle.classList.remove("hidden");
        }

        // y le agregamos la clase hidden a los talles numericos etc
        for (talle of tallesPorNumero) {
          talle.classList.add("hidden")
        }


      // por cada talle numerico (40, 42, 44, etc) le quitamos a cada elemento la clase hidden
      }else{

        for (talle of tallesPorNumero) {
          talle.classList.remove("hidden");
        }

        // y le agregamos la clase hidden a los tallespor letra etc
        for (talle of tallesPorLetra) {
          talle.classList.add("hidden")
        }
      } //cierro if



      // Si volvemos a seleccionar sin categoria, desaparece todo
      if (categoryId.value==0) {
        // oculto los talles por numero
        for (talle of tallesPorNumero) {
          talle.classList.add("hidden")
        }
        // oculto los talles por letra
        for (talle of tallesPorLetra) {
          talle.classList.add("hidden")
        }
      }

    }) // cierre del evento change de categoria
  } // cierre de la funcion stockPorCategoria
  stockPorCategoria();



  // Creacion de input descuento en vista add product
  function onSale(){
    // Selecciono el select con id onSale y el div de discount que tiene la clase hidden
    var onSale = document.getElementById('onSale');
    var discount = document.getElementById('discount');


    // Creo un evento que actue cuando cambia el value del input onSale
    onSale.addEventListener('change',function(){
      if (onSale.value==1) {
        discount.classList.remove("hidden");
      } else {
        discount.classList.add("hidden");
      }

    }) // cierre del evento change de onSale
  }// cierre de la funcion onSale
  onSale();



}) //cierre windows.addEventListener('load')
