(function () {
    let tareas = [];
    const btnTarea = document.querySelector('#agregar-tarea');
    btnTarea.addEventListener('click', () => { mostrarFormulario() });
    obtenerTareas();

    const filtros = document.querySelectorAll('input[type="radio"]');

     filtros.forEach(input => {
         input.addEventListener('input',filtrarVista);
     });

    

    function mostrarFormulario(tarea = {}) {

        const contenedor_modal = document.createElement('DIV');
        contenedor_modal.classList.add('contenedor-modal');

        const modal = document.createElement('DIV');
        modal.classList.add('modal');

        const modalBotones = document.createElement('DIV');
        modalBotones.classList.add('modal-botones');

        const inputTarea = document.createElement('input');
        inputTarea.classList.add('input-tarea');
        inputTarea.placeholder = "Nombre Tarea";
        inputTarea.value = tarea.nombre ? tarea.nombre : "";

        const btnAgregar = document.createElement('BUTTON');
        btnAgregar.classList.add('boton', 'boton-tarea');
        btnAgregar.textContent = tarea.id ? "Actualizar" : "Agregar"

        const btnCerrar = document.createElement('BUTTON');
        btnCerrar.classList.add('boton', 'boton-tarea');
        btnCerrar.textContent = "Cerrar"


        modalBotones.appendChild(btnAgregar);
        modalBotones.appendChild(btnCerrar);

        modal.appendChild(inputTarea);
        modal.appendChild(modalBotones);

        contenedor_modal.appendChild(modal);
        document.querySelector('.tasks').appendChild(contenedor_modal);

        setTimeout(() => {
            modal.classList.add('mostrar');
        }, 50);

        btnCerrar.addEventListener('click', () => {

            modal.classList.remove('mostrar');
            setTimeout(() => {
                contenedor_modal.remove();
            }, 600);

        })

        btnAgregar.addEventListener('click', () => {

            if (tarea.id) {
                validarNombre(tarea, inputTarea.value);
                return;
            }
            validarTarea(inputTarea.value);
        })

    }

    function validarTarea(nombre) {

        if (nombre.trim() == "") {

            mostrarAlerta('error', '.modal', "El nombre de la Tarea es obligatorio")
            return;
        }

        crearTarea(nombre);

    }
    function validarNombre(tarea, nuevoNombre) {

        if (nuevoNombre.trim() == "") {

            mostrarAlerta('error', '.modal', "El nombre de la Tarea es obligatorio")
            return;
        }

        cambiarNombre(tarea, nuevoNombre);

    }

    async function crearTarea(tarea) {

        //creando la peticion
        const datos = new FormData();
        const parametros = new URLSearchParams(window.location.search);
        const proyecto = parametros.get('id');
        const estado = 'pendiente';

        datos.append('nombre', tarea);
        datos.append('estado', estado);
        datos.append('url', proyecto);


        try {
            const url = '/api/tarea';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();
            mostrarAlerta(resultado.tipo, '.modal', resultado.respuesta);

            tarea = {
                id: resultado.id,
                nombre: tarea,
                estado,
                proyecto_id: resultado.proyecto_id
            };

            tareas.push(tarea);
            mostrarTareas();
            console.log(tareas);
            setTimeout(() => {
                document.querySelector('.contenedor-modal').remove();
            }, 1998);


        } catch (error) {
            console.log(error);
        }
    }

    async function obtenerTareas() {

        const parametros = new URLSearchParams(window.location.search);
        const proyecto = parametros.get('id');
        const url = `/api/tareas?url=${proyecto}`;

        try {
            const respuesta = await fetch(url);

            const resultado = await respuesta.json();
            if (resultado.tipo) {

                mostrarAlerta(resultado.tipo, '.contenido', resultado.respuesta);
                return;
            }

            tareas = resultado;
            mostrarTareas();


        } catch (error) {
            console.log(error)
        }
    }

    function mostrarTareas(datos = tareas) {

        if (document.querySelector('.tareas')) {
            document.querySelector('.tareas').remove();
        }
        const contenedorTareas = document.createElement('DIV');
        contenedorTareas.classList.add('tareas');


        datos.forEach(tarea => {
            const divTarea = document.createElement('DIV');
            divTarea.classList.add('tarea');
            const btnsTarea = document.createElement('DIV');
            btnsTarea.classList.add('botones-tarea');

            const nombre = document.createElement('P');
            nombre.textContent = tarea.nombre;



            const btnEstado = document.createElement('button');
            btnEstado.textContent = tarea.estado;
            btnEstado.classList.add(`${tarea.estado == 'pendiente' ? 'pendiente' : 'terminada'}`)

            const btnBorrar = document.createElement('button');
            btnBorrar.textContent = "BORRAR";
            btnBorrar.classList.add('borrar');



            divTarea.appendChild(nombre);
            btnsTarea.appendChild(btnEstado);
            btnsTarea.appendChild(btnBorrar);
            divTarea.appendChild(btnsTarea);
            contenedorTareas.appendChild(divTarea);


            btnBorrar.onclick = () => {
                borrarTarea(tarea.id);
            }
            btnEstado.onclick = () => {
                actualizarEstado(tarea, "si");
            }
            nombre.ondblclick = () => {
                mostrarFormulario(tarea);
            }
        });

        tareasPendientes();
        tareasTerminadas();
    
        document.querySelector('.contenedor-tareas').appendChild(contenedorTareas);
    }

    async function borrarTarea(id) {
        const parametros = new URLSearchParams(window.location.search);
        const proyecto = parametros.get('id');
        const url = `/api/tarea/eliminar`;
        const datos = new FormData();
        datos.append('id', id)
        datos.append('url', proyecto);


        try {
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();

            if (resultado) {

                tareas = tareas.filter(e => e.id != id);
                mostrarAlerta(resultado.tipo, '.contenido', resultado.respuesta);
                
                if(!tareas.length){
                    document.querySelector('.tareas').remove();
                    return;
                }
                mostrarTareas();

            }

        } catch (error) {
            console.log(error);
        }
    }
    async function actualizarEstado(tarea, cambiar = "") {

        const url = `/api/tarea/actualizar`;
        const datos = new FormData();
        datos.append('id', tarea.id);
        datos.append('nombre', tarea.nombre);
        datos.append('cambiar', cambiar);
        try {
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();

            if (resultado && cambiar == "si") {

                tareas.forEach(t => {

                    if (t.id == tarea.id && t.estado == "pendiente") {
                        t.estado = "terminada"
                    } else if (t.id == tarea.id && t.estado == "terminada")
                        t.estado = "pendiente"
                });

                mostrarTareas();
                document.querySelector('.formulario-inputs').reset();

            }

        } catch (error) {
            console.log(error);
        }
    }

    function cambiarNombre(tarea, nuevoNombre) {

        tarea.nombre = nuevoNombre;
        console.log(tarea);
        actualizarEstado(tarea, "no");
        mostrarTareas();
        mostrarAlerta('exito', '.modal', 'Nombre Actualizado');
        setTimeout(() => {
            document.querySelector('.contenedor-modal').remove();
        }, 1998);


    }


    function mostrarAlerta(clase, referencia, mensaje) {

        if (!document.querySelector('.alertas')) {
            const alerta = document.createElement('P');
            alerta.classList.add('alertas', clase);
            alerta.textContent = mensaje;

            document.querySelector(referencia).appendChild(alerta);

            setTimeout(() => {
                alerta.remove();
            }, 2000);

        }
    }

    function filtrarVista(e){

        if(e.target.value == "todas"){
            mostrarTareas();
            return;
        }
        const tareasFiltradas = tareas.filter( tarea => tarea.estado == e.target.value);
        mostrarTareas(tareasFiltradas);

     
    }

    function tareasPendientes(){

        const pendientes = tareas.filter( tarea => tarea.estado == "pendiente" );
        console.log(pendientes);
                if(!pendientes.length){
                    document.querySelector('#pendientes').disabled = true;
                }else{
                    document.querySelector('#pendientes').disabled = false;

                }
    }
    function tareasTerminadas(){
        const terminadas = tareas.filter( tarea => tarea.estado == "terminada" );
        
                if(!terminadas.length){
                    document.querySelector('#terminadas').disabled = true;
                }else{
                    document.querySelector('#terminadas').disabled = false;

                }
    }


})();