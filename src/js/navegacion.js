(function(){


 const desplegable = document.querySelector('.desplegable');
 const luna = document.querySelector('.luna'); 

 
 const pre_dark = window.matchMedia('(prefers-color-scheme: oscuro)');
 if (pre_dark.matches) {
     document.body.classList.toggle('dark-mode');
 }

 desplegable.addEventListener('click', () => {

    const navegacion = document.querySelector('.navegacion');
    navegacion.classList.toggle('ocultar');
 });

 luna.addEventListener('click', () => {

   document.querySelector('body').classList.toggle('dark-mode');
 })


})();