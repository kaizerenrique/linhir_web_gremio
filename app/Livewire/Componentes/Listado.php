<?php

namespace App\Livewire\Componentes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Personaje;
use \App\Traits\Albion;
use \App\Traits\DiscordComan;

class Listado extends Component
{
    use WithPagination; 
    use Albion;
    use DiscordComan;

    public $buscar, $lim;

    protected $queryString = [
        'buscar' => ['except' => '']
    ];


    public function render()
    {
        $linhir_id = config('app.linhir_gremio_id');

        $informacion = $this->consultargremio($linhir_id);

        if ($this->lim == null) {
            $this->lim = 6;
        } 

        if (!empty($this->buscar)) {
            $miembros = Personaje::where('GuildId', $linhir_id)
                ->where('Name', 'like', '%'.$this->buscar.'%')
                ->with('lifetimeStatistics.gatheringStatistics')
                ->orderBy('id', 'desc')
                ->paginate($this->lim);
        } else {
            $miembros = Personaje::where('GuildId', $linhir_id)
                ->with('lifetimeStatistics.gatheringStatistics')
                ->orderBy('id', 'desc')
                ->paginate($this->lim);
        }

        $listado = $this->getMembersWithRoles();
        
        return view('livewire.componentes.listado',[
            'informacion' => $informacion,
            'miembros' => $miembros,
        ]);
    }

    /**
     * Corrige la numeracion de la tabla al realizar 
     * una busqueda
     */
    public function updatingBuscar()
    {
        $this->resetPage();
    }
}
