<?php
/***********************************************************************************************************

GNUPanel es un programa para el control de hospedaje WEB 
Copyright (C) 2006  Ricardo Marcelo Alvarez rmalvarezkai@gmail.com

------------------------------------------------------------------------------------------------------------

Este archivo es parte de GNUPanel.

	GNUPanel es Software Libre; Usted puede redistribuirlo y/o modificarlo
	bajo los t�rminos de la GNU Licencia P�blica General (GPL) tal y como ha sido
	p�blicada por la Free Software Foundation; o bien la versi�n 2 de la Licencia,
	o (a su opci�n) cualquier versi�n posterior.

	GNUPanel se distribuye con la esperanza de que sea �til, pero SIN NINGUNA
	GARANT�A; tampoco las impl�citas garant�as de MERCANTILIDAD o ADECUACI�N A UN
	PROP�SITO PARTICULAR. Consulte la GNU General Public License (GPL) para m�s
	detalles.

	Usted debe recibir una copia de la GNU General Public License (GPL)
	junto con GNUPanel; si no, escriba a la Free Software Foundation Inc.
	51 Franklin Street, 5� Piso, Boston, MA 02110-1301, USA.

------------------------------------------------------------------------------------------------------------

This file is part of GNUPanel.

	GNUPanel is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	GNUPanel is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with GNUPanel; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

------------------------------------------------------------------------------------------------------------

***********************************************************************************************************/

function inicia_logueo($procesador,$mensaje)
{
    global $idioma;
    global $escribir;
    $procesador_get = generar_link_con_gets($procesador);
    print "<div id=\"formulario\" > \n";
    print "<ins> \n";
    print "<br/> \n";
    print "<form method=\"post\" action=\"$procesador_get\" > \n";
    print "<table> \n";
    print "<tr> \n";
    print "<td> \n";
    print $escribir['ing_user'];
    print "</td> \n";
    print "<td> \n";
    print "<input id=\"id_usuario_user\" name=\"usuario_user\" size=\"20\" maxlength=\"255\" > \n";
    print "@";
    print "<input id=\"id_usuario_dominio\" name=\"usuario_dominio\" size=\"20\" maxlength=\"255\" > \n";
    print "</td> \n";
    print "</tr> \n";
    print "<tr> \n";
    print "<td> \n";
    print $escribir['ing_contr'];
    print "</td> \n";
    print "<td> \n";
    print "<input id=\"id_usuario_pasaporte\" type=\"password\" name=\"usuario_pasaporte\" size=\"20\" maxlength=\"255\" > \n";
    print "</td> \n";
    print "</tr> \n";
    print "<tr> \n";
    print "<td> \n";
    print "</td> \n";
    print "<td> \n";
    print "<input id=\"id_ingresando\" type=\"hidden\" name=\"ingresando\" value=\"1\" > \n";
    print "<input type=\"submit\" name=\"Ingresar\" value=\"".$escribir['ingresar']."\" > \n";
    print "<input type=\"reset\" name=\"Borrar\" value=\"".$escribir['borrar']."\" > \n";
    print "</td> \n";
    print "</tr> \n";
    print "</table> \n";
    print "</form> \n";
    print "</ins> \n";
    if($mensaje) print "$mensaje <br/> \n";
    print "</div> \n";

    print "<div id=\"botones\" > \n";
    print "</div> \n";
    print "<div id=\"ayuda\" > \n";
    $escriba = $escribir['help'];
    print "$escriba\n";
    print "</div> \n";
}

function procesa_logueo($procesador)
{
    global $escribir;
    global $_SESSION;
    global $_POST;
    $verifica = "WARN";
    $procesador_get = generar_link_con_gets($procesador);
    if(cadena_valida(trim($_POST['usuario_user'])) && cadena_valida(trim($_POST['usuario_pasaporte'])) && cadena_valida(trim($_POST['usuario_dominio'])))
    {
	$verifica = checkea_pasaporte_usuario(pg_escape_string(trim($_POST['usuario_user'])),pg_escape_string(trim($_POST['usuario_dominio'])),pg_escape_string(trim($_POST['usuario_pasaporte'])));
    }
    else
    {
	$verifica = "2";
    }

    if($verifica == "1")
    {
	$_SESSION['id_usuario'] = dame_id_usuario_correo(pg_escape_string(trim($_POST['usuario_user'])),pg_escape_string(trim($_POST['usuario_dominio'])));
	$_SESSION['address'] = $_POST['usuario_user']."@".$_POST['usuario_dominio'];
	$_SESSION['logueado'] = "1";
	require("login.php");
    }
    else
    {
	switch ($verifica)
	{
	    case "0":
	    inicia_logueo($procesador,$escribir['mal_contr']." ");
	    break;
	    case "2":
	    inicia_logueo($procesador,$escribir['carac_inv']." ");
	    break;
	    default:
	    inicia_logueo($procesador,$escribir['user_no_existe']." ");
	}    
    }
}

function terminar_sesion()
{
    global $_SESSION;
    $_SESSION = array();
    session_destroy();
}

function login_init($nombre_script)
{
	global $_POST;
	if($_POST['ingresando']=="1")
	{
		procesa_logueo($nombre_script);
	}
	else
	{
		inicia_logueo($nombre_script,NULL);
	}
}


?>
