<?php
$id = "";
$copyid="";
$url = "";
$fecha_creacion = "";
$estado = "";
$type = "add";
$title = "";
$descripcion_corta = "";
$descripcion = "";
$imagen_destacada = "";
$imagenes = "";
$tipo="0";
$tipoviaje="";
$zonas="";
$destinos="";

$lunes=true;
$martes=true;
$miercoles=true;
$jueves=true;
$viernes=true;
$sabado=true;
$domingo=true;

$vmanual=false;

$vueloVAuto=false;
$horaMinimaFechaSalida="00:00:00";
$horaMaximaFechaSalida="00:00:00";
$horaMinimaFechaLlegada="00:00:00";
$horaMaximaFechaLlegada="00:00:00";
$soloVueloMismoDia=false;
$soloVueloDiaSiguiente=false;
$observaciones="";
$observacionesbono="";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $paquete = Paquete::getPaqueteById($id);
    $type = "update";
    $title = $paquete->getNombre();
    $url = $paquete->getUrl();
    $fecha_creacion = $paquete->getFechaCreacion();
    $estado = $paquete->getEstado();
    $descripcion_corta = $paquete->getDescripcionCorta();
    $descripcion = $paquete->getDescripcion();
    $imagen_destacada = $paquete->getImagenDestacada();
    $imagenes = $paquete->getImagenes();
    $tipo = $paquete->getTipo();
    $tipoviaje=Paquete::getTiposViaje($id);
    $zonas=Paquete::getZonas($id);
    $destinos=Paquete::getDestinos($id);
    $lunes = $paquete->getLunes();
    $martes= $paquete->getMartes();
    $miercoles = $paquete->getMiercoles();
    $jueves= $paquete->getJueves();
    $viernes = $paquete->getViernes();
    $sabado = $paquete->getSabado();
    $domingo = $paquete->getDomingo();
    $observaciones= $paquete->getObservaciones();
    $observacionesbono = $paquete->getObservacionesBono();
    $vmanual=$paquete->getVManual();
    $vueloVAuto=$paquete->getvueloVAuto();
    $horaMinimaFechaSalida=$paquete->gethoraMinimaFechaSalida();
    $horaMaximaFechaSalida=$paquete->gethoraMaximaFechaSalida();
    $horaMinimaFechaLlegada=$paquete->gethoraMinimaFechaLlegada();
    $horaMaximaFechaLlegada=$paquete->gethoraMaximaFechaLlegada();
    $soloVueloMismoDia=$paquete->getsoloVueloMismoDia();
    $soloVueloDiaSiguiente=$paquete->getsoloVueloDiaSiguiente();
} elseif (isset($_GET["copyid"])) {
    $copyid = $_GET["copyid"];
    $paquete = Paquete::getPaqueteById($copyid);
    $fecha_creacion = $paquete->getFechaCreacion();
    $estado = $paquete->getEstado();
    $descripcion_corta = $paquete->getDescripcionCorta();
    $descripcion = $paquete->getDescripcion();
    $imagen_destacada = $paquete->getImagenDestacada();
    $imagenes = $paquete->getImagenes();
    $tipo = $paquete->getTipo();
    $tipoviaje=Paquete::getTiposViaje($copyid);
    $zonas=Paquete::getZonas($copyid);
    $destinos=Paquete::getDestinos($copyid);
    $lunes = $paquete->getLunes();
    $martes= $paquete->getMartes();
    $miercoles = $paquete->getMiercoles();
    $jueves= $paquete->getJueves();
    $viernes = $paquete->getViernes();
    $sabado = $paquete->getSabado();
    $domingo = $paquete->getDomingo();
    $vmanual=$paquete->getVManual();
    $vueloVAuto=$paquete->getvueloVAuto();
    $horaMinimaFechaSalida=$paquete->gethoraMinimaFechaSalida();
    $horaMaximaFechaSalida=$paquete->gethoraMaximaFechaSalida();
    $horaMinimaFechaLlegada=$paquete->gethoraMinimaFechaLlegada();
    $horaMaximaFechaLlegada=$paquete->gethoraMaximaFechaLlegada();
    $observaciones= $paquete->getObservaciones();
}

?>

<script>
    var idpaquete="";
    var myWindowC;
    $(document).ready(function () {
        idpaquete='<?php echo $id ?>';
        if(idpaquete!="")
        {
            $("#divperiodo").css("display","");
            $("#divduracio").css("display","");
            $("#divVuelos").css("display","");
            $("#divServicios").css("display","");
            $("#divSeguros").css("display","");
            $("#divCircuitos").css("display","");
            $("#divHoteles").css("display","");


            $("#selTipo").removeAttr("disabled");
            $("#selZona").removeAttr("disabled");
            $("#selDestino").removeAttr("disabled");
            $("[name='tipoPaquete']").attr("disabled","disabled");
        }

        paquetes.InitPaquete('<?php echo $imagen_destacada ?>', '<?php echo $imagenes ?>', '<?php echo $tipoviaje ?>', '<?php echo $zonas ?>', '<?php echo $destinos ?>',<?php echo $vmanual ?>);

    });



</script>
<style>

    #divVManual  .k-listbox .k-item
    {
        line-height: 2.6em !important;
        min-height: 2.6em !important;
    }
</style>

<div class="wrap travel-management">
    <h1 class="wp-heading-inline">Añadir Paquete</h1>
    <form id="paquete">
        <input type="hidden" name="action" value="paquetes_controller" />
        <input type="hidden" name="type" value="<?php echo $type ?>" />
        <?php if (!empty($id)) :?>
            <input type="hidden" name="id" value="<?php echo $id ?>" />
        <?php endif; ?>
        <?php if (!empty($copyid)) :?>
            <input type="hidden" name="copyid" value="<?php echo $copyid ?>" />
        <?php endif; ?>
        <div id="poststuff">
            <div id="post-body" class="metabox-holder columns-2">
                <div id="post-body-content" style="position: relative;">
                    <div id="titlediv">
                        <div id="titlewrap">
                            <input type="text" name="post_title" size="30" value="<?php echo $title ?>" id="title" spellcheck="true" autocomplete="off" placeholder="Añadir el título">
                        </div>
                    </div>
                    <div style="padding-top: 20px;">
                        <h3>Descripción corta</h3>
                        <div>
                            <input type="text" name="descripcioncorta" id="descripcionCorta" value="<?php echo $descripcion_corta ?>"/>
                        </div>
                    </div>
                    <div style="padding-top: 20px;">
                        <h3>Descripción detallada</h3>
                        <div>
                            <?php echo wp_editor(stripslashes($descripcion), 'descripcion'); ?>
                        </div>
                    </div>
                    <div style="padding-top: 20px;">
                        <h3>Imagen destacada</h3>
                        <div id="imagen-destacada">
                            <div id="uploaderImage">
                                <input type="hidden"  name="imagendestacada" id="travelImage" data-bind="value:imagendestacada" />
                            </div>
                            <div class="divImagenDestacada">
                                <a href="#" class="upload_image_button">Añadir Imagen Destacada</a>
                                <a href="#" class="remove_imagen_destacada" style="display: none;">Borrar Imagen Destacada</a>
                            </div>
                        </div>
                    </div>
                    <div style="padding-top: 20px;">
                        <h3>Imágenes</h3>
                        <?php add_meta_box('custom_post_type_data_meta_box', 'Custom Post Type Data', array($this,'custom_post_type_data_meta_box'), 'custom_post_type', 'normal', 'high'); ?>
                        <div id="galeria-imagenes" class="postbox">
                            <div class="galeria">
                                <div class="acf-input">
                                    <div id="acf-field_61126528b9861" class="acf-gallery ui-resizable" data-library="all" data-min="" data-max="" data-mime_types="" data-insert="append" data-columns="8" style="height:400px">
                                        <div class="acf-gallery-main">
                                            <div class="acf-gallery-attachments ui-sortable"></div>
                                        </div>
                                        <div class="acf-gallery-side">
                                            <div class="acf-gallery-side-inner">
                                                <div id="uploadImagesGallery">
                                                    <input type="hidden"  name="imagenes" id="travelGalleryImages" data-bind="value:imagenes" />
                                                </div>
                                                <div class="acf-gallery-toolbar">
                                                    <ul class="acf-hl">
                                                        <li class="acf-fr">
                                                            <a class="upload_image_gallery button-primary" href="#">Añadir imagenes</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div style="display:flex;flex-flow:row;width:100%;margin-bottom: 10px;margin-top: 30px;justify-content:center;">
                            <div style="display:flex;flex-flow:column;width:16%;margin-top:7px;font-weight: bold;margin-right: 20px;">
                                Días de la semana a utilizar:
                            </div>
                            <div style="display:flex;flex-flow:column;width:2%;margin-top: 12px;">
                                <input type="checkbox" id="chkLunes" name="chkLunes"  <?php echo ($lunes == true) ? "checked" : ""; ?>/>
                            </div>
                            <div style="display:flex;flex-flow:column;width:10%;margin-top: 7px;">
                                <label  for="chkLunes">Lunes</label>
                            </div>
                            <div style="display:flex;flex-flow:column;width:2%;margin-top: 12px;">
                                <input type="checkbox" id="chkMartes" name="chkMartes" <?php echo ($martes == true) ? "checked" : ""; ?>  />
                            </div>
                            <div style="display:flex;flex-flow:column;width:10%;margin-top: 7px;">
                                <label  for="chkMartes">Martes</label>
                            </div>
                            <div style="display:flex;flex-flow:column;width:2%;margin-top: 12px;">
                                <input type="checkbox" id="chkMiercoles" name="chkMiercoles" <?php echo ($miercoles == true) ? "checked" : ""; ?> />
                            </div>
                            <div style="display:flex;flex-flow:column;width:10%;margin-top: 7px;">
                                <label  for="chkMiercoles">Miércoles</label>
                            </div>
                            <div style="display:flex;flex-flow:column;width:2%;margin-top: 12px;">
                                <input type="checkbox" id="chkJueves" name="chkJueves" <?php echo ($jueves == true) ? "checked" : ""; ?> />
                            </div>
                            <div style="display:flex;flex-flow:column;width:10%;margin-top: 7px;">
                                <label  for="chkJueves">Jueves</label>
                            </div>
                            <div style="display:flex;flex-flow:column;width:2%;margin-top: 12px;">
                                <input type="checkbox" id="chkViernes" name="chkViernes" <?php echo ($viernes == true) ? "checked" : ""; ?> />
                            </div>
                            <div style="display:flex;flex-flow:column;width:10%;margin-top: 7px;">
                                <label  for="chkViernes">Viernes</label>
                            </div>
                            <div style="display:flex;flex-flow:column;width:2%;margin-top: 12px;">
                                <input type="checkbox" id="chkSabado" name="chkSabado" <?php echo ($sabado == true) ? "checked" : ""; ?> />
                            </div>
                            <div style="display:flex;flex-flow:column;width:10%;margin-top: 7px;">
                                <label  for="chkSabado">Sábado</label>
                            </div>
                            <div style="display:flex;flex-flow:column;width:2%;margin-top: 12px;">
                                <input type="checkbox" id="chkDomingo" name="chkDomingo" <?php echo ($domingo == true) ? "checked" : ""; ?>  />
                            </div>
                            <div style="display:flex;flex-flow:column;width:10%;margin-top: 7px;">
                                <label  for="chkDomingo">Domingo</label>
                            </div>
                        </div>
                    </div>


                    <div id="divperiodo" style="padding-top: 20px;display:none;">
                        <h3>
                            Periodos reserva paquete
                        </h3>
                        <div style="border-style:solid;padding: 12px;border-width:1px;border-color:lightgrey;">
                            <div id="gridDataEstancia"></div>
                        </div>
                    </div>

                    <div id="divduracio" style="padding-top: 20px;display:none;">
                        <h3>
                            Duración Paquetes
                        </h3>
                        <div style="border-style:solid;padding: 12px;border-width:1px;border-color:lightgrey;">
                            <div id="gridDuracio"></div>
                        </div>

                    </div>

                    <div  id="divCircuitos" style="padding-top: 20px;display:none;">
                        <h3>Circuitos</h3>
                        <div>
                            <div style="width: 100%;">
                                <div><input id="searchCircuitos" autocomplete="off" style="width:100%;" class="k-textbox search-box" placeholder="Buscar circuitos..." /></div>
                                <div style="display: flex;">
                                    <select id="lista-circuitos" style="width: 50%;"></select>
                                    <select id="selected-circuitos" style="width: 50%;"></select>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top:10px">
                            <input type="checkbox" id="chkVManual" name="chkVManual" <?php echo ($vmanual == true) ? "checked" : ""; ?>><label for="chkVManual">Vuelos Manuales durante el Circuito</label>
                        </div>
                    </div>
                    <div id="divVuelos" style="padding-top: 20px;display:none;">

                        <div id="divVManual" style="display:none;">
                            <h3>VUELOS Manuales durante el Circuito</h3>
                            <div>
                                <div style="width: 100%;">
                                    <div><input id="searchVuelosm" autocomplete="off" style="width:100%;" class="k-textbox search-box" placeholder="Buscar vuelos manuales..." /></div>
                                    <div style="display: flex;">
                                        <select id="lista-vuelosm" style="width: 50%;"></select>
                                        <select id="selected-vuelosm" style="width: 50%;"></select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3>VUELOS cuando el Paquete está en primera posición</h3>
                        <div>
                            <div style="width: 100%;">
                                <div><input id="searchVuelos" autocomplete="off" style="width:100%;" class="k-textbox search-box" placeholder="Buscar vuelos..." /></div>
                                <div style="display: flex;">
                                    <select id="lista-vuelos" style="width: 50%;"></select>
                                    <select id="selected-vuelos" style="width: 50%;"></select>
                                </div>
                            </div>
                        </div>

                        <h3>VUELOS cuando el Paquete está en el resto de posiciones</h3>
                        <div>
                            <div style="width: 100%;">
                                <div><input id="searchVuelosr" autocomplete="off" style="width:100%;" class="k-textbox search-box" placeholder="Buscar vuelos..." /></div>
                                <div style="display: flex;">
                                    <select id="lista-vuelosr" style="width: 50%;"></select>
                                    <select id="selected-vuelosr" style="width: 50%;"></select>
                                </div>
                            </div>
                        </div>
                        <div style="padding:15px;border-style:solid;border-width:1px;border-color:lightgray;margin-top:15px;">
                            <div>
                                <input type="checkbox" <?php echo ($vueloVAuto == true) ? "checked" : ""; ?> id="chkVVueltaAuto" name="chkVVueltaAuto" ><label for="chkVVueltaAuto" style="font-weight:bold;">VUELO de vuelta a casa (generado automáticamente por el motor) </label>
                                <input id="btnConfHoraPaquet" type="button" codi="--" horaMinimaFechaSalida="<?php echo $horaMinimaFechaSalida ?>" horaMaximaFechaSalida="<?php echo $horaMaximaFechaSalida ?>" horaMinimaFechaLlegada="<?php echo $horaMinimaFechaLlegada ?>" horaMaximaFechaLlegada="<?php echo $horaMaximaFechaLlegada ?>"   soloVueloMismoDia="<?php echo $soloVueloMismoDia ?>" solovuelodiasiguiente="<?php echo $soloVueloDiaSiguiente ?>" resto="0" onclick="CanviarHora(this);" value="Configurar Horas" class="button button-primary" style="margin-left:10px" >
                            </div>
                            <div>
                                <label id="lblHoras" >Horas salida (<?php echo substr($horaMinimaFechaSalida, 0, -3) ?> / <?php echo substr($horaMaximaFechaSalida, 0, -3) ?>) Horas llegada (<?php echo substr($horaMinimaFechaLlegada, 0, -3) ?> / <?php echo substr($horaMaximaFechaLlegada, 0, -3) ?>) <?php   echo ($soloVueloMismoDia == '1') ? " , Sólo vuelos del mismo día" : ""; ?> <?php   echo ($soloVueloDiaSiguiente == '1') ? " , Sólo vuelos el día siguiente" : ""; ?></label>
                            </div>
                        </div>
                    </div>
                    <div id="divHoteles" style="padding-top: 5px;display:none;">
                        <h3>Hoteles</h3>
                        <div>
                            <div style="width: 100%;">
                                <div><input id="searchHoteles" autocomplete="off" style="width:100%;" class="k-textbox search-box" placeholder="Buscar hoteles..." /></div>
                                <div style="display: flex;">
                                    <select id="lista-hoteles" style="width: 50%;"></select>
                                    <select id="selected-hoteles" style="width: 50%;"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="divServicios" style="padding-top: 20px;display:none;">
                        <h3>Otros Servicios</h3>
                        <div>
                            <div style="width: 100%;">
                                <div><input id="searchServicios" autocomplete="off" style="width:100%;" class="k-textbox search-box" placeholder="Buscar servicios..." /></div>
                                <div style="display: flex;">
                                    <select id="lista-servicios" style="width: 50%;"></select>
                                    <select id="selected-servicios" style="width: 50%;"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="divSeguros" style="padding-top: 20px;display:none;">
                        <h3>Seguros</h3>
                        <div>
                            <div style="width: 100%;">
                                <div><input id="searchSeguros" autocomplete="off" style="width:100%;" class="k-textbox search-box" placeholder="Buscar seguros..." /></div>
                                <div style="display: flex;">
                                    <select id="lista-seguros" style="width: 50%;"></select>
                                    <select id="selected-seguros" style="width: 50%;"></select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--div id="divPaqueteVinculado" style="padding-top: 20px;display:none;">
                        <h3>Extensiones</h3>
                        <div>
                            <div style="width: 100%;">
                                <div><input id="searchPVinculado" autocomplete="off" style="width:100%;" class="k-textbox search-box" placeholder="Buscar extensiones..." /></div>
                                <div style="display: flex;">
                                    <select id="lista-pvinculado" style="width: 50%;"></select>
                                    <select id="selected-pvinculado" style="width: 50%;"></select>
                                </div>
                            </div>
                        </div>
                    </div-->
                    <div style="padding-top: 20px;">
                        <h3>Observaciones para el bono</h3>
                        <div>
                            <?php echo wp_editor($observacionesbono, 'observacionesb'); ?>
                        </div>
                    </div>
                    <div style="padding-top: 20px;">
                        <h3>Observaciones internas</h3>
                        <div>
                            <?php echo wp_editor($observaciones, 'observaciones'); ?>
                        </div>
                    </div>
                    <div id="logs" style="padding-top: 20px;">
                        <h3>Logs</h3>
                        <div id="gridlogs"></div>
                    </div>
                </div><!-- /post-body-content -->
                <div id="postbox-container-1" class="postbox-container">
                    <div id="side-sortables" class="meta-box-sortables ui-sortable" style="">
                        <div id="submitdiv" class="postbox">
                            <div class="postbox-header">
                                <h2 class="hndle ui-sortable-handle">Guardar</h2>
                            </div>
                            <div class="inside">
                                <?php if (!empty($fecha_creacion)) : ?>
                                    <div style="padding: 10px; display: flex; align-items: center; justify-content: space-between;">
                                        <div>
                                            <span>Fecha creación:</span>
                                        </div>
                                        <div>
                                            <span><?php echo $fecha_creacion ?></span>
                                        </div>

                                    </div>
                                <?php endif; ?>
                                <div style="padding: 10px;align-items: center; justify-content: space-between;">
                                    <div>
                                        <select  id="selTipo" style="width:100%"  disabled="disabled"></select>
                                    </div>
                                </div>
                                <div style="padding: 10px;align-items: center; justify-content: space-between;">
                                    <div>
                                        <select  id="selZona" style="width:100%" disabled="disabled"></select>
                                    </div>
                                </div>
                                <div style="padding: 10px;align-items: center; justify-content: space-between;">
                                    <div>
                                        <select  id="selDestino" style="width:100%" disabled="disabled"></select>
                                    </div>
                                </div>
                                <div style="display: none">
                                    <div>
                                        <span>Tipo Paquete: </span>
                                    </div>
                                    <div>
                                        <select name="tipoPaquete" style="width:120px;">
                                            <option value="0"  <?php echo ($tipo == "0") ? "selected" : ""; ?>>Principal</option>
                                            <option value="1" <?php echo ($tipo == "1") ? "selected" : ""; ?>>Extensión</option>
                                        </select>
                                    </div>
                                </div>
                                <div style="padding: 10px; display: flex; align-items: center; justify-content: space-between;">
                                    <div>
                                        <span>Estado: </span>
                                    </div>
                                    <div>
                                        <select name="estado">
                                            <option value="borrador" <?php echo ($estado == "borrador") ? "selected" : ""; ?>>Borrador</option>
                                            <option value="publicada" <?php echo ($estado == "publicada") ? "selected" : ""; ?>>Publicada</option>
                                            <option value="despublicada" <?php echo ($estado == "despublicada") ? "selected" : ""; ?>>Despublicada</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="major-publishing-actions">
                                    <div id="delete-action">
                                        <a class="submitdelete deletion" href="#" style="color: red;">Eliminar</a>
                                    </div>
                                    <div id="publishing-action">
                                        <?php if (!empty($id)) : ?>
                                            <input type="button" name="custom-duplicate" id="custom-duplicate" class="button button-primary" value="Duplicar">
                                            <input type="submit" name="custom-update" id="custom-update" class="button button-primary" value="Actualizar">
                                        <?php else : ?>
                                            <input type="submit" name="custom-publish" id="custom-publish" class="button button-primary" value="Guardar">
                                        <?php endif; ?>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /post-body -->
            <br class="clear">
        </div><!-- /poststuff -->
    </form>
</div>


<div id="windowH">
    <div class="divConfiguracionHora">
        <div style="display:flex;flex-flow:row">
            <div style="padding:10px;display:flex;flex-flow:column">
                <div style="margin-bottom:10px;"> Hora Mínima Fecha Salida</div>  <input id="horaMinimaFechaSalida" style="width: 100%;" />
            </div>
            <div  style="padding:10px;display:flex;flex-flow:column">
                <div style="margin-bottom:10px;">Hora Máxima Fecha Salida</div>  <input id="horaMaximaFechaSalida" style="width: 100%;" />
            </div>
        </div>
        <div style="display:flex;flex-flow:row">
            <div  style="padding:10px;display:flex;flex-flow:column">
                <div style="margin-bottom:10px;">Hora Mínima Fecha Llegada</div>  <input id="horaMinimaFechaLlegada" style="width: 100%;" />
            </div>
            <div  style="padding:10px;display:flex;flex-flow:column">
                <div style="margin-bottom:10px;">Hora Máxima Fecha Llegada</div>  <input id="horaMaximaFechaLlegada" style="width: 100%;" />
            </div>
        </div>
    </div>
    <div  style="padding:10px;padding-left: 0px;">
        <div style="display:inline-block;margin-left: 9px;"><input type="checkbox" id="chksVueloMismoDia" name="chksVueloMismoDia" > <label for="chksVueloMismoDia">Sólo vuelos del mismo día</label></div>
        <div id="divVueloDiaSiguiente" style="display:inline-block;margin-left: 5px;"><input type="checkbox" id="chksVueloDiaSiguiente" name="chksVueloDiaSiguiente" > <label for="chksVueloDiaSiguiente">Sólo vuelos el día siguiente</label></div>
    </div>
    <div style="width:100%;">
        <div style="border-style:solid;padding: 12px;border-width:1px;border-color:lightgrey;margin-top:20px;text-align:right;">
            <input id="btnGuardarHora" type="button" value="Guardar" class="k-button k-button-icontext k-primary k-grid-update" style="margin-right:5px;" onclick="GuardarHora()"/><input type="button" value="Cancelar" class="k-button k-button-icontext k-grid-cancel" onclick="CancelarHora()"/>
        </div>
    </div>
</div>
