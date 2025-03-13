<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <div class="col-span-1 sm:col-span-2 md:col-span-1">
            <!-- Seccion de identificacion del Gremio -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg ">
                <div class="flex justify-center w-full mt-4">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ $informacion->guild->Name }}
                    </h2>
                </div>
                <div class="flex justify-center w-full my-6">
                    <img src="{{ asset('/plantilla/linhir_escudo.png') }}" class="h-36" />
                </div>
                <div class="mx-4 mb-6">
                    <ul>
                        <li>
                            <h3 class="font-semibold text-base text-gray-800 dark:text-gray-200 leading-tight p-1">
                                Fundador: <a href="#">{{ $informacion->guild->FounderName }}</a>
                            </h3>
                        </li>
                        <li>
                            <h3 class="font-semibold text-base text-gray-800 dark:text-gray-200 leading-tight p-1">
                                Fecha de fundación:

                                {{ Carbon\Carbon::parse($informacion->guild->Founded)->format('d-m-Y') }}
                            </h3>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- / Seccion de identificacion del Gremio -->

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg mt-4">
                <div class="mx-4 mb-8">
                    <ul>
                        <li>
                            <h3 class="font-semibold text-base text-gray-800 dark:text-gray-200 leading-tight p-1">
                                Fama total por Asesinatos: {{ number_format($informacion->guild->killFame) }}
                            </h3>
                        </li>
                        <li>
                            <h3 class="font-semibold text-base text-gray-800 dark:text-gray-200 leading-tight p-1">
                                Fama total por Muertes: <a
                                    href="#">{{ number_format($informacion->guild->DeathFame) }}</a>
                            </h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-span-1 sm:col-span-2 md:col-span-2">
            <!-- targetas de informacion -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                <div class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="ml-4">
                        <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight">Integrantes</h2>
                        <p class="mt-2 text-sm dark:text-gray-200">{{ $informacion->basic->memberCount }}</p>
                    </div>
                </div>

                <div class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="ml-4">
                        <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight">Asesinatos</h2>
                        <p class="mt-2 text-sm dark:text-gray-200">{{ $informacion->overall->kills }} kills</p>
                    </div>
                </div>

                <div class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="ml-4">
                        <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight">Muertes</h2>
                        <p class="mt-2 text-sm dark:text-gray-200">{{ $informacion->overall->deaths }} deaths</p>
                    </div>
                </div>

                <div class="flex items-start p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="ml-4">
                        <h2 class="font-semibold text-gray-800 dark:text-gray-200 leading-tight">Relación</h2>
                        <p class="mt-2 text-sm dark:text-gray-200">{{ $informacion->overall->ratio }}</p>
                    </div>
                </div>

            </div>
            <!-- / targetas de informacion -->

            <!-- seccion top players -->
            <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div
                    class="relative flex flex-col min-w-0 break-words bg-gray-50 dark:bg-gray-800 w-full shadow-lg rounded">
                    <div class="rounded-t mb-0 px-0 border-0">
                        <div class="flex flex-wrap items-center px-4 py-2">
                            <div class="relative w-full max-w-full flex-grow flex-1">
                                <h3 class="font-semibold text-base text-gray-900 dark:text-gray-50">Top 5 PVP</h3>
                            </div>
                        </div>
                        <div class="block w-full">
                            <table class="items-center w-full bg-transparent border-collapse">
                                <thead>
                                    <tr>
                                        <th
                                            class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle 
                                        border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 
                                        border-r-0 whitespace-nowrap font-semibold text-left">
                                            Nombre</th>
                                        <th
                                            class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle 
                                        border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 
                                        border-r-0 whitespace-nowrap font-semibold text-left">
                                            Fama por Matar</th>
                                        <th
                                            class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle 
                                        border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 
                                        border-r-0 whitespace-nowrap font-semibold text-left">
                                            Fama por Muerte</th>
                                        <th
                                            class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle 
                                        border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 
                                        border-r-0 whitespace-nowrap font-semibold text-left">
                                            Relación</th>
                                        <th
                                            class="px-4 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-100 align-middle 
                                        border border-solid border-gray-200 dark:border-gray-500 py-3 text-xs uppercase border-l-0 
                                        border-r-0 whitespace-nowrap font-semibold text-left">
                                            Asesinatos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($informacion->topPlayers as $registro)
                                        <tr class="text-gray-700 dark:text-gray-100">
                                            <th
                                                class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                {{ $registro->Name }}
                                            </th>
                                            <th
                                                class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                {{ number_format($registro->KillFame, 0, ',', '.') }}
                                            </th>
                                            <th
                                                class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                {{ number_format($registro->DeathFame, 0, ',', '.') }}
                                            </th>
                                            <th
                                                class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                {{ $registro->FameRatio }}
                                            </th>
                                            <th
                                                class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                {{ number_format($registro->totalKills) }}
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / seccion top players -->
        </div>

    </div>

    <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

        <div class="flex flex-wrap items-center px-4 py-2">
            <div class="relative w-full max-w-full flex-grow flex-1">
                <h3 class="font-semibold text-base text-gray-800 dark:text-gray-200 leading-tight">Listado de usuarios
                    Registrados</h3>
            </div>
            <div class="flex flex-col items-center w-full max-w-xl">
                <x-input class="block mt-1 w-100" type="search" wire:model.live="buscar" placeholder="Buscar" />

            </div>
            <div class="relative w-full max-w-full flex-grow flex-1 text-right mt-1">
                <select wire:model.live="lim"
                    class="w-25 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-500 focus:ring-blue-500 dark:focus:ring-blue-500 rounded-md shadow-sm">
                    <option value="6" selected>6</option>
                    <option value="12">12</option>
                    <option value="24">24</option>
                    <option value="36">36</option>
                    <option value="48">48</option>
                </select>
            </div>
        </div>

        <!-- mensaje -->
        <div>
            @if (session()->has('message'))
                <div class="max-w-lg mx-auto">
                    <div class="flex bg-emerald-100 rounded-lg p-4 mb-4 text-sm text-emerald-700" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-5 w-5 mr-3"
                            fill="none" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <span class="font-medium">{{ session('message') }}</span>.
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <!-- / mensaje -->

        <!-- tabla -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Usuario Web</th>
                            <th class="px-4 py-3">Discord</th>
                            <th class="px-4 py-3">Fama PVE</th>
                            <th class="px-4 py-3">Fama de crafteo</th>
                            
                            <th class="px-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($miembros as $miembro)
                            <tr class="text-gray-700 dark:text-gray-100">
                                <!-- nombre de personaje -->
                                <th class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                    {{ $miembro->Name }}
                                </th>
                                <!-- Registrado en la web -->
                                @if (!empty($miembro->user_id))
                                    <th class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">                                       
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                        </svg>                                                                                                                                                                   
                                    </th>
                                @else
                                    <th class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                        </svg>                                                                                                                                                                    
                                    </th>
                                @endif
                                <!-- Registrado en discord -->
                                @if (!empty($miembro->discord_user_id))
                                    <th class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8">
                                            <path fill-rule="evenodd" d="M12.516 2.17a.75.75 0 0 0-1.032 0 11.209 11.209 0 0 1-7.877 3.08.75.75 0 0 0-.722.515A12.74 12.74 0 0 0 2.25 9.75c0 5.942 4.064 10.933 9.563 12.348a.749.749 0 0 0 .374 0c5.499-1.415 9.563-6.406 9.563-12.348 0-1.39-.223-2.73-.635-3.985a.75.75 0 0 0-.722-.516l-.143.001c-2.996 0-5.717-1.17-7.734-3.08Zm3.094 8.016a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                        </svg>                                                                                                                              
                                    </th>
                                @else
                                    <th class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8">
                                            <path fill-rule="evenodd" d="M11.484 2.17a.75.75 0 0 1 1.032 0 11.209 11.209 0 0 0 7.877 3.08.75.75 0 0 1 .722.515 12.74 12.74 0 0 1 .635 3.985c0 5.942-4.064 10.933-9.563 12.348a.749.749 0 0 1-.374 0C6.314 20.683 2.25 15.692 2.25 9.75c0-1.39.223-2.73.635-3.985a.75.75 0 0 1 .722-.516l.143.001c2.996 0 5.718-1.17 7.734-3.08ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75ZM12 15a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75v-.008a.75.75 0 0 0-.75-.75H12Z" clip-rule="evenodd" />
                                        </svg>                                                                                                                           
                                    </th>
                                @endif
                                <!-- info de fama-->
                                @if ($miembro->lifetimeStatistics)
                                    <th class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                        {{number_format($miembro->lifetimeStatistics->PvE_Total, 0, ',', '.')}}
                                    </th>
                                    <th class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                        {{number_format($miembro->lifetimeStatistics->Crafting_Total, 0, ',', '.')}}
                                    </th>
                                                                    
                                @else
                                    <th class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                        No hay estadísticas disponibles
                                    </th>
                                    <th class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                        No hay estadísticas disponibles
                                    </th>
                                @endif   
                                
                                
                                <!-- Acciones -->
                                <th class="border-t-0 px-4 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clip-rule="evenodd" />
                                        <path d="m10.076 8.64-2.201-2.2V4.874a.75.75 0 0 0-.364-.643l-3.75-2.25a.75.75 0 0 0-.916.113l-.75.75a.75.75 0 0 0-.113.916l2.25 3.75a.75.75 0 0 0 .643.364h1.564l2.062 2.062 1.575-1.297Z" />
                                        <path fill-rule="evenodd" d="m12.556 17.329 4.183 4.182a3.375 3.375 0 0 0 4.773-4.773l-3.306-3.305a6.803 6.803 0 0 1-1.53.043c-.394-.034-.682-.006-.867.042a.589.589 0 0 0-.167.063l-3.086 3.748Zm3.414-1.36a.75.75 0 0 1 1.06 0l1.875 1.876a.75.75 0 1 1-1.06 1.06L15.97 17.03a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                    </svg>
                                </th>
                                
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div
                class="grid px-4 py-3 text-xs font-semibold tracking-wide uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-2
                dark:text-gray-300 dark:bg-gray-800">
                <span class="flex col-span-6 mt-2 md:mt-auto md:justify-end">
                    {{ $miembros->links() }}
                </span>
            </div>
        </div>
        <!-- \tabla -->

    </div>
</div>
