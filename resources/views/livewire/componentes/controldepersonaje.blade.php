<div>
    <!-- targetas de informacion -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="ml-4">
                <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight">Personajes Registrados</h2>
                <p class="mt-2 text-sm dark:text-gray-200">{{ $num }}</p>
            </div>
        </div>
        <div class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="ml-4">
                <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight">Personajes Linhir</h2>
                <p class="mt-2 text-sm dark:text-gray-200"></p>
            </div>
        </div>
        <div class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="ml-4">
                <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight">Nuevo Personaje</h2>
                <div class="flex items-center justify-end mt-4">
                    <x-button class="ml-4" wire:click="modalbuscarpersonaje()">
                        {{ __('Registrar') }}
                    </x-button>
                </div>
            </div>
        </div>
    </div>

    @if (is_null($personajes))
    @else
        @foreach ($personajes as $personaje)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                <div class="col-span-1 sm:col-span-2 md:col-span-1">
                    <!-- Seccion de identificacion del Gremio -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg ">

                        <div
                            class="flex justify-center w-full mt-6 mb-4 text-gray-200 transform hover:text-purple-500 hover:scale-110">

                            <span class="inline-flex rounded-md" type="button"
                                wire:click="consultareliminarpersonaje('{{ $personaje->Id }}')">
                                <div
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="h-10 w-10 rounded-full object-cover">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                    </svg>
                                </div>
                            </span>

                        </div>
                        <div class="mx-4 mb-4">
                            <ul>
                                <li>
                                    <h3
                                        class="font-semibold text-base text-gray-800 dark:text-gray-200 leading-tight p-1">
                                        Nombre: {{ $personaje->Name }}
                                    </h3>
                                </li>
                                <li>
                                    <h3
                                        class="font-semibold text-base text-gray-800 dark:text-gray-200 leading-tight p-1">
                                        Gremio:
                                        @if ($personaje->GuildName == 'Linhir')
                                            <a href="">
                                                {{ $personaje->GuildName }}
                                            </a>
                                        @else
                                            {{ $personaje->GuildName }}
                                        @endif
                                    </h3>
                                </li>
                                <li>
                                    <h3
                                        class="font-semibold text-base text-gray-800 dark:text-gray-200 leading-tight p-1">
                                        Alianza:
                                        @if (!empty($personaje->AllianceName))
                                            {{ $personaje->AllianceName }}
                                        @endif
                                    </h3>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- / Seccion de identificacion del Gremio -->
                    <div
                        class="flex items-start p-4 mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="ml-4">
                            <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-2">PVE:</h2>
                            <ul>
                                <li>
                                    <span
                                        class="bg-malachite dark:text-deep_fir text-sm font-medium mr-2 px-2.5 py-0.5 rounded-lg">
                                        Total: {{ number_format($personaje->LifetimeStatistics->PvE->Total) }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-span-1 sm:col-span-2 md:col-span-3">
                    <!-- targetas de informacion -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                        <div
                            class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="ml-4">
                                <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-2">Cosechador
                                </h2>
                                <ul>
                                    <li>
                                        <span
                                            class="bg-malachite dark:text-deep_fir text-sm font-medium mr-2 px-2.5 py-0.5 rounded-lg">
                                            Total:
                                            {{ number_format($personaje->LifetimeStatistics->Gathering->Fiber->Total) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div
                            class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="ml-4">
                                <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-2">Peletero
                                </h2>
                                <ul>
                                    <li>
                                        <span
                                            class="bg-pink_salmon dark:text-maroon_oak text-sm font-medium mr-2 px-2.5 py-0.5 rounded-lg">
                                            Total:
                                            {{ number_format($personaje->LifetimeStatistics->Gathering->Hide->Total) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div
                            class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="ml-4">
                                <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-2">Prospector
                                </h2>
                                <ul>
                                    <li>
                                        <span
                                            class="bg-turquoise dark:text-deep_teal text-sm font-medium mr-2 px-2.5 py-0.5 rounded-lg">
                                            Total:
                                            {{ number_format($personaje->LifetimeStatistics->Gathering->Ore->Total) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div
                            class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="ml-4">
                                <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-2">Cantero
                                </h2>
                                <ul>
                                    <li>
                                        <span
                                            class="bg-lavender_pink dark:text-toledo text-sm font-medium mr-2 px-2.5 py-0.5 rounded-lg">
                                            Total:
                                            {{ number_format($personaje->LifetimeStatistics->Gathering->Rock->Total) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div
                            class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="ml-4">
                                <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-2">Leñador
                                </h2>
                                <ul>
                                    <li>
                                        <span
                                            class="bg-malachite dark:text-deep_fir text-sm font-medium mr-2 px-2.5 py-0.5 rounded-lg">
                                            Total:
                                            {{ number_format($personaje->LifetimeStatistics->Gathering->Wood->Total) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div
                            class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="ml-4">
                                <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-2">Pescador
                                </h2>
                                <span
                                    class="bg-pink_salmon dark:text-maroon_oak text-sm font-medium mr-2 px-2.5 py-0.5 rounded-lg">
                                    Total: {{ number_format($personaje->LifetimeStatistics->FishingFame) }}
                                </span>
                            </div>
                        </div>

                        <div
                            class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="ml-4">
                                <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-2">Agricultor
                                </h2>
                                <span
                                    class="bg-turquoise dark:text-deep_teal text-sm font-medium mr-2 px-2.5 py-0.5 rounded-lg">
                                    Total: {{ number_format($personaje->LifetimeStatistics->FarmingFame) }}
                                </span>
                            </div>
                        </div>

                        <div
                            class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="ml-4">
                                <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-2">
                                    Elaboración
                                </h2>
                                <ul>
                                    <li>
                                        <span
                                            class="bg-lavender_pink dark:text-toledo text-sm font-medium mr-2 px-2.5 py-0.5 rounded-lg">
                                            Total: {{ number_format($personaje->LifetimeStatistics->Crafting->Total) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <!-- / targetas de informacion -->

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 mt-4">

                        <div
                            class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="ml-4">
                                <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-2">Fama total
                                    por
                                    Asesinatos:</h2>
                                <ul>
                                    <li>
                                        <span
                                            class="bg-malachite dark:text-deep_fir text-sm font-medium mr-2 px-2.5 py-0.5 rounded-lg">
                                            Total: {{ number_format($personaje->KillFame) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div
                            class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="ml-4">
                                <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-2">Fama total
                                    por
                                    Muertes:</h2>
                                <ul>
                                    <li>
                                        <span
                                            class="bg-malachite dark:text-deep_fir text-sm font-medium mr-2 px-2.5 py-0.5 rounded-lg">
                                            Total: {{ number_format($personaje->DeathFame) }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div
                            class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="ml-4">
                                <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight mb-2">Relación:
                                </h2>
                                <ul>
                                    <li>
                                        <span
                                            class="bg-malachite dark:text-deep_fir text-sm font-medium mr-2 px-2.5 py-0.5 rounded-lg">
                                            Total: {{ $personaje->FameRatio }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        @endforeach

    @endif




    <!-- Buscar Personaje Modal-->
    <x-dialog-modal wire:model="modalBuscarPersonaje">
        <x-slot name="title">
            Buscar Personaje
        </x-slot>

        <x-slot name="content">
            <div>
                <x-input id="buscar" class="block mt-1 w-full" type="search" name="buscar" wire:model.live="buscar"
                    placeholder="Buscar" />
            </div>
            <div class="mt-4">
                <!-- Tabla -->
                <div class="overflow-x-auto">
                    <div class="dark:bg-gray-800 shadow-md rounded my-6">
                        <table class="min-w-max w-full table-auto">
                            <thead>
                                <tr class="dark:bg-gray-800 dark:text-gray-100 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Nombre</th>
                                </tr>
                            </thead>
                            @if ($resultados == false)
                            @else
                                <tbody class="text-gray-600 text-sm font-light">
                                    @foreach ($resultados as $resultado)
                                        <tr class="border-b border-gray-200 hover:bg-gray-600 dark:text-gray-100"
                                            type="button" wire:click="datosdepersonaje('{{ $resultado->Id }}')">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                                {{ $resultado->Name }}
                                            </td>
                                            <td
                                                class="py-3 px-6 text-left whitespace-nowraptext-gray-200 transform hover:text-purple-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                                </svg>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif

                        </table>
                    </div>
                </div>
                <!-- / Tabla -->
            </div>


        </x-slot>

        <x-slot name="footer">
            <div class="px-4 py-2 m-2">
                <x-danger-button class="ml-2" wire:click="$toggle('modalBuscarPersonaje')"
                    wire:loading.attr="disabled">
                    Cancelar
                </x-danger-button>
            </div>
        </x-slot>
        </x-dialog-modall>
        <!-- /Buscar Personaje Modal-->

        <!-- Seccion que contiene el modal para eliminar -->
        <x-confirmation-modal wire:model="modalConfirmarPersonaje">
            <x-slot name="title">
                Agregar Personaje
            </x-slot>

            <x-slot name="content">
                ¿Confirmas que el personaje {{ $nombrepersonaje }} es de tu propiedad ?
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="agregarpersonaje('{{ $identificador }}')"
                    wire:loading.attr="disabled">
                    Agregar Personaje
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="$toggle('modalConfirmarPersonaje')"
                    wire:loading.attr="disabled">
                    Cancelar
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
        <!-- / Seccion que contiene el modal para eliminar -->

        <!-- Seccion que contiene el modal para eliminar personaje-->
        <x-confirmation-modal wire:model="modalBorrarPersonaje">
            <x-slot name="title">
                {{ $titulo }}
            </x-slot>

            <x-slot name="content">
                {{ $mensaje }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="eliminarpersonaje('{{ $identificador }}')"
                    wire:loading.attr="disabled">
                    Borrar Personaje
                </x-secondary-button>

                <x-danger-button class="ml-2" wire:click="$toggle('modalBorrarPersonaje')"
                    wire:loading.attr="disabled">
                    Cancelar
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
        <!-- / Seccion que contiene el modal para eliminar personaje-->

        <!-- Seccion que contiene el modal para eliminar -->
        <x-confirmation-modal wire:model="mensajeModal">
            <x-slot name="title">
                {{ $titulo }}
            </x-slot>

            <x-slot name="content">
                {{ $mensaje }}
            </x-slot>

            <x-slot name="footer">
                <x-danger-button class="ml-2" wire:click="$toggle('mensajeModal')" wire:loading.attr="disabled">
                    Cerrar
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
        <!-- / Seccion que contiene el modal para eliminar -->

</div>
