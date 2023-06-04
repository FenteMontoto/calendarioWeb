<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">


    <!-- Scipts css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/datatables.min.css">
    <link rel="stylesheet" href="css/bootstrap-clockpicker.css">
    <link rel="stylesheet" href="fullcalendar/main.css">

    <!-- Scripts js -->
    <script type="text/javascript" src="js/code.jquery.com_jquery-3.7.0.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/datatables.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-clockpicker.js"></script>
    <script type="text/javascript" src="js/moment-with-locales.js"></script>
    <script type="text/javascript" src="fullcalendar/main.js"></script>

    <title>Calendario</title>
</head>

<body>
    <div class="containser-fluid">
        <section class="conten-header">
            <h1>Calendario</h1>
        </section>
    </div>
    <div id="Calendario1" style='border:1px solid #000; padding:2px'></div>

    <!-- Formulario de eventos -->
    <div class="modal fade" id="FormularioEventos" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="id">

                    <!-- <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="">Evento</label>
                            <input type="text" name="" id="Titulo" class="form-control" value="" placeholder="">
                        </div>
                    </div> -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Fecha:</label>
                            <div class="input-group" data-autoclose="true">
                                <input class="form-control" type="date" value="" id="fecha">
                            </div>
                        </div>
                        <div class="form-group col-md-6" id="TituloHoraInicio">
                            <label for="">Hora:</label>
                            <div class="input-group clockpicker" data-autoclose="true">
                                <input class="form-control" type="time" value="" id="hora" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="">Concepto</label>
                        <textarea id="descripcion" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-row">
                        <label for="">Confirmada</label>
                        <input type="text" id="confirmada" class="form-control"></input>
                    </div>
                    <div class="form-row">
                        <label for="">Estado</label>
                        <input type="text" id="estado" class="form-control"></input>
                    </div>
                    <div class="form-row">
                        <label for="">Donde</label>
                        <input type="text" id="donde" class="form-control">
                    </div>
                    <div class="form-row">
                        <label for="">Contacto</label>
                        <input type="text" id="contacto" class="form-control">
                    </div>
                    <div class="form-row">
                        <label for="">Nombre</label>
                        <input type="text" id="nombre" class="form-control">
                    </div>
                    <div class="form-row">
                        <label for="">Teléfono</label>
                        <input type="text" id="telefono" class="form-control">
                    </div>
                    <div class="form-row">
                        <label for="">Color de fondo</label>
                        <input type="color" value="#3788D8" id="colorfondo" style="height:36px;" class="form-control">
                    </div>
                    <div class="form-row">
                        <label for="">Color de texto</label>
                        <input type="color" value="#ffffff" id="colortexto" style="height:36px;" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="botonAgregar" class="btn btn-success">Agregar</button>
                    <button type="button" id="botonModificar" class="btn btn-warning">Modificar</button>
                    <button type="button" id="botonBorrar" class="btn btn-danger">Borrar</button>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.clockpicker').clockpicker();

        let calendario1 = new FullCalendar.Calendar(document.getElementById('Calendario1'), {
            events: 'eventos.php?accion=listar',
            dateClick: function(info) {

                limpiarFormulario()

                $('#botonAgregar').show();
                $('#botonModificar').hide();
                $('#botonBorrar').hide();
                $('#botonAgregar').show();

                if (info.allDay) {
                    $('#fecha').val(info.dateStr);

                } else {
                    let fechaHora = info.dateStr.split("T");
                    $('#fecha').val(fechaHora[0]);
                    $('#fecha').val(fechaHora[1].substring(0, 5));
                }
                $("#FormularioEventos").modal('show');
            },
            eventClick: function(info) {
                $('#botonAgregar').hide();
                $('#botonModificar').show();
                $('#botonBorrar').show();

                $('#id').val(info.event.id);
                $('#descripcion').val(info.event.title);
                $('#fecha').val(moment(info.event.start).format("YYYY-MM-DD"));
                $('#hora').val(moment(info.event.start).format("HH:mm"));
                $('#confirmada').val(info.event.extendedProps.confirmada);
                $('#estado').val(info.event.extendedProps.estado);
                $('#donde').val(info.event.extendedProps.donde);
                $('#contacto').val(info.event.extendedProps.contacto);
                $('#nombre').val(info.event.extendedProps.nombre);
                $('#telefono').val(info.event.extendedProps.telefono);
                $('#colorfondo').val(info.event.backgroundColor);
                $('#colortexto').val(info.event.textColor);

                $("#FormularioEventos").modal('show');
            }
        });
        calendario1.render();

        //Eventos de botones

        $('#botonAgregar').click(function() {
            let evento = recuperarDatosForm();
            agregarEvento(evento);
            $('#FormularioEventos').modal('hide');
        });

        $('#botonModificar').click(function() {
            let evento = recuperarDatosForm();
            modificarEvento(evento);
            $('#FormularioEventos').modal('hide');
        });

        $('#botonBorrar').click(function() {
            let evento = recuperarDatosForm();
            borrarEvento(evento);
            $('#FormularioEventos').modal('hide');
        });

        //Funciones AJAX

        function agregarEvento(evento) {
            $.ajax({
                type: 'POST',
                url: 'eventos.php?accion=agregar',
                data: evento,
                success: function(msg) {
                    calendario1.refetchEvents();
                },
                error: function(error) {
                    alert("Error al agregar el evento: "+error);
                }
            })
        }

        function modificarEvento(evento){
            $.ajax({
                type: 'POST',
                url: 'eventos.php?accion=modificar',
                data: evento,
                success: function(msg) {
                    calendario1.refetchEvents();
                },
                error: function(error) {
                    alert("Error al modificar el evento: "+error);
                }
            })
        }

        function borrarEvento(evento){
            $.ajax({
                type: 'POST',
                url: 'eventos.php?accion=borrar',
                data: evento,
                success: function(msg) {
                    calendario1.refetchEvents();
                },
                error: function(error) {
                    alert("Error al borrar el evento: "+error);
                }
            })
        }

        //funciones que interactuan con el formulario eventos

        function limpiarFormulario() {
            $('#id').val('');
            $('#fecha').val('');
            $('#hora').val('');
            $('#descripcion').val('');
            $('#confirmada').val('');
            $('#estado').val('');
            $('#donde').val('');
            $('#contacto').val('');
            $('#nombre').val('');
            $('#telefono').val('');
            $('#colorfondo').val('#3788D8');
            $('#colortexto').val('#ffffff');
        }

        function recuperarDatosForm() {
            let evento = {
                id: $('#id').val(),
                fecha: $('#fecha').val() + ' ' + $('#hora').val(),
                concepto: $('#descripcion').val(),
                confirmada: $('#confirmada').val(),
                estado: $('#estado').val(),
                donde: $('#donde').val(),
                contacto: $('#contacto').val(),
                nombre: $('#nombre').val(),
                telefono: $('#telefono').val(),
                colorfondo: $('#colorfondo').val(),
                colortexto: $('#colortexto').val()
            }
            return evento;
        }
    </script>
</body>

</html>