<?php

namespace App\Livewire\Componentes;

use Livewire\Component;
use \App\Traits\Albion;
use App\Models\Personaje;


class Controldepersonaje extends Component
{
    use Albion;

    public $modalBuscarPersonaje = false;
    public $buscar, $identificador, $nombrepersonaje;
    public $modalConfirmarPersonaje = false;
    public $modalBorrarPersonaje = false;
    public $titulo, $mensaje;
    public $mensajeModal = false;

    protected $queryString = [
        'buscar' => ['except' => '']
    ];

    protected function rules()
    {
        if ($modalBuscarPersonaje = true) {
            return [
                'buscar' => 'required|string|min:4',                
            ];
        }        
    }

    public function render()
    {
        //$prueba = $this->datospersonaje();
        
        
        $linhir_id = config('app.linhir_gremio_id');

        $resultados = $this->buscarpersonajepornombre($this->buscar);
        //$informacion = $this->consultargremio($linhir_id);

        $perfiles = auth()->user()->personajes;  

        foreach ($perfiles as $perfil){
            $Id_albions[] = $perfil->Id_albion;
            
        }
        
        $num = 0;
        if (empty($Id_albions)) {            
            $personajes = null;            
        } else {
            foreach ($Id_albions as $Id_albion) {
                $personajes[] = $this->consultarpersonaje($Id_albion);
            }
            $num = count($personajes);            
        }   
        
        return view('livewire.componentes.controldepersonaje',[
            'resultados' => $resultados,
            'personajes' => $personajes,
            'num' => $num,
        ]);
    }

    /**
     * Desplegamos el modal para buscar un personaje por su nombre
     */

    public function modalbuscarpersonaje()
    {
        $this->reset(['buscar']);                
        $this->modalBuscarPersonaje = true;
    }

    /**
     * Modal para confirmar el personaje
     */
    public function datosdepersonaje($identificador)
    {
        $this->modalBuscarPersonaje = false;
        $datosdelpersonaje = $this->consultarpersonaje($identificador);
        $this->identificador = $datosdelpersonaje->Id;
        $this->nombrepersonaje = $datosdelpersonaje->Name;
        $this->modalConfirmarPersonaje = true;
        
    }

    /**
     * esta función agrega un personaje
     */
    public function agregarpersonaje($identificador)
    {
        $this->reset(['buscar']);
        $this->modalConfirmarPersonaje = false;
        $linhir_id = config('app.linhir_gremio_id');
        $datosdelpersonaje = $this->consultarpersonaje($identificador);
    
        // Verificar si el personaje ya existe en la base de datos
        $personajeExistente = Personaje::where('Id_albion', $datosdelpersonaje->Id)->first();
    
        if ($personajeExistente) {
            // Si el personaje ya tiene un usuario propietario
            if ($personajeExistente->user_id) {
                $this->titulo = 'El personaje ya está registrado';
                $this->mensaje = '¡El personaje ' . $datosdelpersonaje->Name . ' ya está registrado por otro usuario!';
                $this->mensajeModal = true;
                $this->redirect('/dashboard');
            } else {
                // Si el personaje no tiene un usuario propietario, asignarlo al usuario actual
                $personajeExistente->update([
                    'user_id' => auth()->user()->id,
                    'miembro' => ($datosdelpersonaje->GuildId == $linhir_id), // Actualizar el estado de miembro
                ]);
    
                $this->titulo = 'Personaje asignado';
                $this->mensaje = '¡El personaje ' . $datosdelpersonaje->Name . ' ha sido asignado a tu cuenta!';
                $this->mensajeModal = true;
                $this->redirect('/dashboard');
            }
        } else {
            // Si el personaje no existe, crearlo y asignarlo al usuario actual
            $miembro = ($datosdelpersonaje->GuildId == $linhir_id);
    
            Personaje::create([
                'user_id' => auth()->user()->id,
                'Name' => $datosdelpersonaje->Name,
                'Id_albion' => $datosdelpersonaje->Id,
                'GuildId' => $datosdelpersonaje->GuildId,
                'miembro' => $miembro,
            ]);
    
            $this->titulo = 'Personaje registrado';
            $this->mensaje = '¡El personaje ' . $datosdelpersonaje->Name . ' ha sido registrado exitosamente!';
            $this->mensajeModal = true;
            $this->redirect('/dashboard');
        }
    }

    /***
     * esta función recupera los datos de un personaje 
     * para consultar su eliminación 
     */
    public function consultareliminarpersonaje($personajeId)
    {
        $personaje = Personaje::where('Id_albion', $personajeId )->get();
        
        foreach ($personaje as $id)
        {
            $idp = $id->id;
            $nombre = $id->Name;
        }

        $this->titulo = 'Borrar personaje de su lista';
        $this->mensaje = '¿Confirma que desea eliminar el personaje '. $nombre .' de su listado ?';
        $this->identificador = $idp;
        $this->modalBorrarPersonaje = true;
        
    }

    /**
     * 
     */
    public function eliminarpersonaje($identificador)
    {
        $this->modalBorrarPersonaje = false;

        $remover = Personaje::find($identificador);
        $nombre = $remover->Name;
        $remover->delete();
        
        $this->titulo = 'Personaje eliminado con éxito';
        $this->mensaje = '¡El personaje de nombre '. $nombre .' ha sido eliminado de nuestro registro de forma exitosa!';        
        $this->mensajeModal = true;
    }
}
