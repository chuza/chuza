<?php
/*
Plugin Name: Canon AEDE
Plugin URI: http://fontethemes.com/es/canon-aede/
Description: Replace the URL base of the communication media who are members of CEDRO and AEDE
Version: 0.2.1
Author: Jesus Amieiro
Author URI: http://fontethemes.com
License: GPL2 or later
*/
/*
Copyright 2014  Jesus Amieiro  (email : info@fontethemes.com)
Modificado para Chuza por Manel Vilar

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Canon_AEDE { 

static $domain_list = array ('http://abc.es',
	'http://abcdesevilla.es',
	'http://aede.es',
	'http://as.com',
	'http://canarias7.es',
	'http://cincodias.com',
	'http://deia.com',
	'http://diaridegirona.cat',
	'http://diaridetarragona.com',
	'http://diarideterrassa.es',
	'http://diariocordoba.com',
	'http://diariodeavila.es',
	'http://diariodeavisos.com',
	'http://diariodeburgos.es',
	'http://diariodecadiz.es',
	'http://diariodeibiza.es',
	'http://diariodejerez.es',
	'http://diariodelaltoaragon.es',
	'http://diariodeleon.es',
	'http://diariodemallorca.es',
	'http://diariodenavarra.es',
	'http://diariodesevilla.es',
	'http://diarioinformacion.com',
	'http://diariojaen.es',
	'http://diariopalentino.es',
	'http://diariovasco.com',
	'http://eladelantado.com',
	'http://elcomercio.es',
	'http://elcorreo.com',
	'http://elcorreoweb.es',
	'http://eldiadecordoba.es',
	'http://eldiariomontanes.es',
	'http://eleconomista.es',
	'http://elmundo.es',
	'http://elpais.com',
	'http://elpais.es',
	'http://elperiodico.com',
	'http://elperiodicodearagon.com',
	'http://elperiodicoextremadura.com',
	'http://elperiodicomediterraneo.com',
	'http://elprogreso.es',
	'http://elprogreso.galiciae.com',
	'http://europasur.es',
	'http://expansion.com',
	'http://farodevigo.es',
	'http://gaceta.es',
	'http://granadahoy.com',
	'http://heraldo.es',
	'http://heraldodesoria.es',
	'http://hoy.es',
	'http://huelvainformacion.es',
	'http://ideal.es',
	'http://intereconomia.com',
	'http://lagacetadesalamanca.es',
	'http://laopinion.es',
	'http://laopinioncoruna.es',
	'http://laopiniondemalaga.es',
	'http://laopiniondemurcia.es',
	'http://laopiniondezamora.es',
	'http://laprovincia.es',
	'http://larazon.es',
	'http://larioja.com',
	'http://lasprovincias.es',
	'http://latribunadeciudadreal.es',
	'http://latribunadetalavera.es',
	'http://latribunadetoledo.es',
	'http://lavanguardia.com',
	'http://laverdad.es',
	'http://lavozdealmeria.es',
	'http://lavozdegalicia.es',
	'http://lavozdigital.es',
	'http://levante-emv.com',
	'http://lne.es',
	'http://majorcadailybulletin.es',
	'http://majorcadailybulletin.com',
	'http://malagahoy.es',
	'http://marca.com',
	'http://mundodeportivo.com',
	'http://noticiasdealava.com',
	'http://noticiasdegipuzkoa.com',
	'http://regio7.cat',
	'http://sport.es',
	'http://superdeporte.es',
	'http://ultimahora.es',
	'http://www.abc.es',
	'http://www.abcdesevilla.es',
	'http://www.aede.es',
	'http://www.as.com',
	'http://www.canarias7.es',
	'http://www.cincodias.com',
	'http://www.deia.com',
	'http://www.diaridegirona.cat',
	'http://www.diaridetarragona.com',
	'http://www.diarideterrassa.es',
	'http://www.diariocordoba.com',
	'http://www.diariodeavila.es',
	'http://www.diariodeavisos.com',
	'http://www.diariodeburgos.es',
	'http://www.diariodecadiz.es',
	'http://www.diariodeibiza.es',
	'http://www.diariodejerez.es',
	'http://www.diariodelaltoaragon.es',
	'http://www.diariodeleon.es',
	'http://www.diariodemallorca.es',
	'http://www.diariodenavarra.es',
	'http://www.diariodesevilla.es',
	'http://www.diarioinformacion.com',
	'http://www.diariojaen.es',
	'http://www.diariopalentino.es',
	'http://www.diariovasco.com',
	'http://www.eladelantado.com',
	'http://www.elcomercio.es',
	'http://www.elcorreo.com',
	'http://www.elcorreoweb.es',
	'http://www.eldiadecordoba.es',
	'http://www.eldiariomontanes.es',
	'http://www.eleconomista.es',
	'http://www.elmundo.es',
	'http://www.elpais.com',
	'http://www.elpais.es',
	'http://www.elperiodico.com',
	'http://www.elperiodicodearagon.com',
	'http://www.elperiodicoextremadura.com',
	'http://www.elperiodicomediterraneo.com',
	'http://www.elprogreso.es',
	'http://www.elprogreso.galiciae.com',
	'http://www.europasur.es',
	'http://www.expansion.com',
	'http://www.farodevigo.es',
	'http://www.gaceta.es',
	'http://www.granadahoy.com',
	'http://www.heraldo.es',
	'http://www.heraldodesoria.es',
	'http://www.hoy.es',
	'http://www.huelvainformacion.es',
	'http://www.ideal.es',
	'http://www.intereconomia.com',
	'http://www.lagacetadesalamanca.es',
	'http://www.laopinion.es',
	'http://www.laopinioncoruna.es',
	'http://www.laopiniondemalaga.es',
	'http://www.laopiniondemurcia.es',
	'http://www.laopiniondezamora.es',
	'http://www.laprovincia.es',
	'http://www.larazon.es',
	'http://www.larioja.com',
	'http://www.lasprovincias.es',
	'http://www.latribunadeciudadreal.es',
	'http://www.latribunadetalavera.es',
	'http://www.latribunadetoledo.es',
	'http://www.lavanguardia.com',
	'http://www.laverdad.es',
	'http://www.lavozdealmeria.es',
	'http://www.lavozdegalicia.es',
	'http://www.lavozdigital.es',
	'http://www.levante-emv.com',
	'http://www.lne.es',
	'http://www.majorcadailybulletin.es',
	'http://www.majorcadailybulletin.com',
	'http://www.malagahoy.es',
	'http://www.marca.com',
	'http://www.mundodeportivo.com',
	'http://www.noticiasdealava.com',
	'http://www.noticiasdegipuzkoa.com',
	'http://www.regio7.cat',
	'http://www.sport.es',
	'http://www.superdeporte.es',
	'http://www.ultimahora.es',
	'.abc.es',
	'.abcdesevilla.es',
	'.aede.es',
	'.as.com',
	'.canarias7.es',
	'.cincodias.com',
	'.deia.com',
	'.diaridegirona.cat',
	'.diaridetarragona.com',
	'.diarideterrassa.es',
	'.diariocordoba.com',
	'.diariodeavila.es',
	'.diariodeavisos.com',
	'.diariodeburgos.es',
	'.diariodecadiz.es',
	'.diariodeibiza.es',
	'.diariodejerez.es',
	'.diariodelaltoaragon.es',
	'.diariodeleon.es',
	'.diariodemallorca.es',
	'.diariodenavarra.es',
	'.diariodesevilla.es',
	'.diarioinformacion.com',
	'.diariojaen.es',
	'.diariopalentino.es',
	'.diariovasco.com',
	'.eladelantado.com',
	'.elcomercio.es',
	'.elcorreo.com',
	'.elcorreoweb.es',
	'.eldiadecordoba.es',
	'.eldiariomontanes.es',
	'.eleconomista.es',
	'.elmundo.es',
	'.elpais.com',
	'.elpais.es',
	'.elperiodico.com',
	'.elperiodicodearagon.com',
	'.elperiodicoextremadura.com',
	'.elperiodicomediterraneo.com',
	'.elprogreso.es',
	'.elprogreso.galiciae.com',
	'.europasur.es',
	'.expansion.com',
	'.farodevigo.es',
	'.gaceta.es',
	'.granadahoy.com',
	'.heraldo.es',
	'.heraldodesoria.es',
	'.hoy.es',
	'.huelvainformacion.es',
	'.ideal.es',
	'.intereconomia.com',
	'.lagacetadesalamanca.es',
	'.laopinion.es',
	'.laopinioncoruna.es',
	'.laopiniondemalaga.es',
	'.laopiniondemurcia.es',
	'.laopiniondezamora.es',
	'.laprovincia.es',
	'.larazon.es',
	'.larioja.com',
	'.lasprovincias.es',
	'.latribunadeciudadreal.es',
	'.latribunadetalavera.es',
	'.latribunadetoledo.es',
	'.lavanguardia.com',
	'.laverdad.es',
	'.lavozdealmeria.es',
	'.lavozdegalicia.es',
	'.lavozdigital.es',
	'.levante-emv.com',
	'.lne.es',
	'.majorcadailybulletin.es',
	'.majorcadailybulletin.com',
	'.malagahoy.es',
	'.marca.com',
	'.mundodeportivo.com',
	'.noticiasdealava.com',
	'.noticiasdegipuzkoa.com',
	'.regio7.cat',
	'.sport.es',
	'.superdeporte.es',
	'.ultimahora.es',
	' abc.es',
	' abcdesevilla.es',
	' aede.es',
	' as.com',
	' canarias7.es',
	' cincodias.com',
	' deia.com',
	' diaridegirona.cat',
	' diaridetarragona.com',
	' diarideterrassa.es',
	' diariocordoba.com',
	' diariodeavila.es',
	' diariodeavisos.com',
	' diariodeburgos.es',
	' diariodecadiz.es',
	' diariodeibiza.es',
	' diariodejerez.es',
	' diariodelaltoaragon.es',
	' diariodeleon.es',
	' diariodemallorca.es',
	' diariodenavarra.es',
	' diariodesevilla.es',
	' diarioinformacion.com',
	' diariojaen.es',
	' diariopalentino.es',
	' diariovasco.com',
	' eladelantado.com',
	' elcomercio.es',
	' elcorreo.com',
	' elcorreoweb.es',
	' eldiadecordoba.es',
	' eldiariomontanes.es',
	' eleconomista.es',
	' elmundo.es',
	' elpais.com',
	' elpais.es',
	' elperiodico.com',
	' elperiodicodearagon.com',
	' elperiodicoextremadura.com',
	' elperiodicomediterraneo.com',
	' elprogreso.es',
	' elprogreso.galiciae.com',
	' europasur.es',
	' expansion.com',
	' farodevigo.es',
	' gaceta.es',
	' granadahoy.com',
	' heraldo.es',
	' heraldodesoria.es',
	' hoy.es',
	' huelvainformacion.es',
	' ideal.es',
	' intereconomia.com',
	' lagacetadesalamanca.es',
	' laopinion.es',
	' laopinioncoruna.es',
	' laopiniondemalaga.es',
	' laopiniondemurcia.es',
	' laopiniondezamora.es',
	' laprovincia.es',
	' larazon.es',
	' larioja.com',
	' lasprovincias.es',
	' latribunadeciudadreal.es',
	' latribunadetalavera.es',
	' latribunadetoledo.es',
	' lavanguardia.com',
	' laverdad.es',
	' lavozdealmeria.es',
	' lavozdegalicia.es',
	' lavozdigital.es',
	' levante-emv.com',
	' lne.es',
	' majorcadailybulletin.es',
	' majorcadailybulletin.com',
	' malagahoy.es',
	' marca.com',
	' mundodeportivo.com',
	' noticiasdealava.com',
	' noticiasdegipuzkoa.com',
	' regio7.cat',
	' sport.es',
	' superdeporte.es',
	' ultimahora.es',
);	


static $host_list = array('abc.es',
	'abcdesevilla.es',
	'aede.es',
	'as.com',
	'canarias7.es',
	'cincodias.com',
	'deia.com',
	'diaridegirona.cat',
	'diaridetarragona.com',
	'diarideterrassa.es',
	'diariocordoba.com',
	'diariodeavila.es',
	'diariodeavisos.com',
	'diariodeburgos.es',
	'diariodecadiz.es',
	'diariodeibiza.es',
	'diariodejerez.es',
	'diariodelaltoaragon.es',
	'diariodeleon.es',
	'diariodemallorca.es',
	'diariodenavarra.es',
	'diariodesevilla.es',
	'diarioinformacion.com',
	'diariojaen.es',
	'diariopalentino.es',
	'diariovasco.com',
	'eladelantado.com',
	'elcomercio.es',
	'elcorreo.com',
	'elcorreoweb.es',
	'eldiadecordoba.es',
	'eldiariomontanes.es',
	'eleconomista.es',
	'elmundo.es',
	'elpais.com',
	'elpais.es',
	'elperiodico.com',
	'elperiodicodearagon.com',
	'elperiodicoextremadura.com',
	'elperiodicomediterraneo.com',
	'elprogreso.es',
	'elprogreso.galiciae.com',
	'europasur.es',
	'expansion.com',
	'farodevigo.es',
	'gaceta.es',
	'granadahoy.com',
	'heraldo.es',
	'heraldodesoria.es',
	'hoy.es',
	'huelvainformacion.es',
	'ideal.es',
	'intereconomia.com',
	'lagacetadesalamanca.es',
	'laopinion.es',
	'laopinioncoruna.es',
	'laopiniondemalaga.es',
	'laopiniondemurcia.es',
	'laopiniondezamora.es',
	'laprovincia.es',
	'larazon.es',
	'larioja.com',
	'lasprovincias.es',
	'latribunadeciudadreal.es',
	'latribunadetalavera.es',
	'latribunadetoledo.es',
	'lavanguardia.com',
	'laverdad.es',
	'lavozdealmeria.es',
	'lavozdegalicia.es',
	'lavozdigital.es',
	'levante-emv.com',
	'lne.es',
	'majorcadailybulletin.es',
	'majorcadailybulletin.com',
	'malagahoy.es',
	'marca.com',
	'mundodeportivo.com',
	'noticiasdealava.com',
	'noticiasdegipuzkoa.com',
	'regio7.cat',
	'sport.es',
	'superdeporte.es',
	'ultimahora.es',
	);	


public static function remove_shit($url) {
	foreach(self::$host_list as $host) { 
		if (strpos($url, $host) !== FALSE) {
			return true;
		}
	}
}

}
