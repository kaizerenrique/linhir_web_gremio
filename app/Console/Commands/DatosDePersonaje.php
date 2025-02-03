<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Traits\Albion;

class DatosDePersonaje extends Command
{
    use Albion;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consulta:datos-de-personaje';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'consulta los datos de cada personaje registrado en la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $operacion = $this->integrantesdelgremiolinhir();

       if ($operacion == true) {
            $op = $this->datospersonaje();
       } 
       
    }
}
