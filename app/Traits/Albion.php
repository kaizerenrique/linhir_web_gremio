<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
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
		// Validar que el texto no esté vacío
		if (empty($text)) {
			return false;
		}

		// Clave única para almacenar en caché
		$cacheKey = 'player_search_' . md5($text);

		// Intentar obtener los resultados desde la caché
		if (Cache::has($cacheKey)) {
			return Cache::get($cacheKey);
		}

		try {
			$url = 'https://gameinfo.albiononline.com/api/gameinfo/search?q=';
			$response = Http::timeout(10)->get($url . urlencode($text)); // Codificar el texto para la URL

			// Verificar si la respuesta fue exitosa
			if ($response->successful()) {
				$respuesta = json_decode($response->getBody()->getContents());

				// Verificar si hay resultados
				if (!empty($respuesta->players)) {
					// Almacenar en caché por 5 minutos (300 segundos)
					Cache::put($cacheKey, $respuesta->players, 300);
					return $respuesta->players;
				}
			}

			// Si no hay resultados o la respuesta falló
			return false;

		} catch (\Illuminate\Http\Client\ConnectionException $e) {
			// Manejar excepciones de conexión
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

	/**
	* Esta función realiza una consulta a la Pagina del gameinfo.albiononline 
    * para buscar información de los integrantes de linhir
	* 
	* @param string   $text	cadena de texto que contiene el ID
	*
	* @return Retorna un array.
	*/	

    public function integrantesdelgremiolinhir()
	{
		$linhir_id = config('app.linhir_gremio_id');
        try {
            $url = 'https://gameinfo.albiononline.com/api/gameinfo/guilds/';
			$response = Http::get($url.$linhir_id.'/members');

			$respuesta = $response->getBody()->getContents();// accedemos a el contenido	

            $integrantes = json_decode($respuesta);

			// Obtener los IDs de los miembros actuales del gremio
			$idsIntegrantesActuales = collect($integrantes)->pluck('Id')->toArray();

			// Obtener todos los personajes registrados en la base de datos que pertenecen al gremio
			$personajesRegistrados = Personaje::where('GuildId', $linhir_id)->get();

			// Marcar como "no miembro" y actualizar el GuildId de los personajes que ya no están en el gremio
			foreach ($personajesRegistrados as $personaje) {
				if (!in_array($personaje->Id_albion, $idsIntegrantesActuales)) {
					// Buscar información actual del personaje en la API
					$urlPersonaje = 'https://gameinfo.albiononline.com/api/gameinfo/players/' . $personaje->Id_albion;
					$responsePersonaje = Http::get($urlPersonaje);
	
					if ($responsePersonaje->successful()) {
						$infoPersonaje = json_decode($responsePersonaje->getBody()->getContents());
	
						// Actualizar el GuildId con el nuevo gremio o null si no tiene
						$personaje->update([
							'GuildId' => $infoPersonaje->GuildId ?? null,
							'miembro' => false,
						]);
					} else {
						// Si no se puede obtener la información, marcar como "no miembro" y GuildId como null
						$personaje->update([
							'GuildId' => null,
							'miembro' => false,
						]);
					}
				}
			}
	
			// Registrar nuevos miembros o actualizar los existentes
			foreach ($integrantes as $integrante) {
				Personaje::updateOrCreate(
					['Id_albion' => $integrante->Id],
					[
						'Name' => $integrante->Name,
						'GuildId' => $integrante->GuildId,
						'miembro' => true,
					]
				);
			}
	
			return true;
			

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            //report($e);	 
	        return false;
        }
	}

	/**
	 * Esta función realiza una consulta a la Pagina del gameinfo.albiononline
	 * para buscar información de los personajes registrados
	 */

	public function datospersonaje()
	{
		$personajesRegistrados = Personaje::all();

		foreach ($personajesRegistrados as $personajesRegistrado)
		{
			// Buscar información actual del personaje en la API
			$urlPersonaje = 'https://gameinfo.albiononline.com/api/gameinfo/players/' . $personajesRegistrado->Id_albion;
			$responsePersonaje = Http::get($urlPersonaje);

			if ($responsePersonaje->successful())
			{
				$infoPersonaje = json_decode($responsePersonaje->getBody()->getContents(), true);

				// Convertir la fecha al formato correcto
				$timestamp = Carbon::parse($infoPersonaje['LifetimeStatistics']['Timestamp'])->toDateTimeString();
				// Almacenar los datos de LifetimeStatistics
				$lifetimeStatistics = $infoPersonaje['LifetimeStatistics'];
				$lifetimeStats = $personajesRegistrado->lifetimeStatistics()->updateOrCreate(
					['personaje_id' => $personajesRegistrado->id],
					[
						'PvE_Total' => $lifetimeStatistics['PvE']['Total'],
						'PvE_Royal' => $lifetimeStatistics['PvE']['Royal'],
						'PvE_Outlands' => $lifetimeStatistics['PvE']['Outlands'],
						'PvE_Avalon' => $lifetimeStatistics['PvE']['Avalon'],
						'PvE_Hellgate' => $lifetimeStatistics['PvE']['Hellgate'],
						'PvE_CorruptedDungeon' => $lifetimeStatistics['PvE']['CorruptedDungeon'],
						'PvE_Mists' => $lifetimeStatistics['PvE']['Mists'],
						'Crafting_Total' => $lifetimeStatistics['Crafting']['Total'],
						'Crafting_Royal' => $lifetimeStatistics['Crafting']['Royal'],
						'Crafting_Outlands' => $lifetimeStatistics['Crafting']['Outlands'],
						'Crafting_Avalon' => $lifetimeStatistics['Crafting']['Avalon'],
						'CrystalLeague' => $lifetimeStatistics['CrystalLeague'],
						'FishingFame' => $lifetimeStatistics['FishingFame'],
						'FarmingFame' => $lifetimeStatistics['FarmingFame'],
						'Timestamp_Conec' => $timestamp, // Usar la fecha formateada
					]
				);

				// Almacenar los datos de GatheringStatistics
				$gatheringStatistics = $lifetimeStatistics['Gathering'];
				$resources = ['Fiber', 'Hide', 'Ore', 'Rock', 'Wood', 'All'];

				foreach ($resources as $resource) {
					$lifetimeStats->gatheringStatistics()->updateOrCreate(
						[
							'lifetime_statistics_id' => $lifetimeStats->id,
							'resource_type' => $resource,
						],
						[
							'Total' => $gatheringStatistics[$resource]['Total'],
							'Royal' => $gatheringStatistics[$resource]['Royal'],
							'Outlands' => $gatheringStatistics[$resource]['Outlands'],
							'Avalon' => $gatheringStatistics[$resource]['Avalon'],
						]
					);
				}
			}
			
		}
	}
	
}