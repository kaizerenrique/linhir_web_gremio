<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Personaje;
use Carbon\Carbon;

trait Albion 
{
    /**
	* Esta función realiza una consulta a la Pagina del gameinfo.albiononline 
    * para buscar información de los personajes por su nombre. 
	* 
	* @param string   $text	cadena de texto que contiene el nombre del personaje
	*
	* @return Retorna un array.
	*/	

    public function buscarpersonajepornombre($text)
	{
        try {
            $url = 'https://gameinfo.albiononline.com/api/gameinfo/search?q=';
			$response = Http::get($url.$text);

			$respuesta = $response->getBody()->getContents();// accedemos a el contenido			

            $respuesta = json_decode($respuesta); //convertimos en json	

			if (!empty($respuesta->players)) {
				return $respuesta->players;
			} else {
				return false;
			}	

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            //report($e);	 
	        return false;
        }
	}

    /**
	* Esta función realiza una consulta a la Pagina del gameinfo.albiononline 
    * para buscar información de los personajes segun su id. 
	* 
	* @param string   $identificador cadena de texto que contiene el id de albion 
	* del personaje
	*
	* @return Retorna un array.
	*/

	public function consultarpersonaje($identificador) 
	{
		try {
            $url = 'https://gameinfo.albiononline.com/api/gameinfo/players/';
			$response = Http::get($url.$identificador);

			$respuesta = $response->getBody()->getContents();// accedemos a el contenido			

            $respuesta = json_decode($respuesta); //convertimos en json	

			return $respuesta;
				

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            //report($e);	 
	        return false;
        }

	}

    /**
	* Esta función realiza una consulta a la Pagina del gameinfo.albiononline 
    * para buscar información de los gremios por nombre. 
	* 
	* @param string   $text	cadena de texto que contiene el nombre del gremio
	*
	* @return Retorna un array.
	*/	

    public function buscargremiopornombre($text)
	{
        try {
            $url = 'https://gameinfo.albiononline.com/api/gameinfo/search?q=';
			$response = Http::get($url.$text);

			$respuesta = $response->getBody()->getContents();// accedemos a el contenido			

            $respuesta = json_decode($respuesta); //convertimos en json	

			if (!empty($respuesta->guilds)) {
				return $respuesta->guilds;
			} else {
				return false;
			}	

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            //report($e);	 
	        return false;
        }
	}

    /**
	* Esta función realiza una consulta a la Pagina del gameinfo.albiononline 
    * para buscar información de los gremios por su id. 
	* 
	* @param string   $text	cadena de texto que contiene el ID
	*
	* @return Retorna un array.
	*/	

    public function consultargremio($text)
	{
        try {
            $url = 'https://gameinfo.albiononline.com/api/gameinfo/guilds/';
			$response = Http::get($url.$text.'/data');

			$respuesta = $response->getBody()->getContents();// accedemos a el contenido			

            $respuesta = json_decode($respuesta); //convertimos en json	
			
			return $respuesta;			

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            //report($e);	 
	        return false;
        }
	} 
}