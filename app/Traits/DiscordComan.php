<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\AuthProvider;
use Illuminate\Support\Facades\Auth;

trait DiscordComan
{

    /**
     * Realiza una prueba de conexión con la API de Discord.
     *
     * @return mixed
     */
    public function pruebadiscord()
    {
        try {
            // Usa el token del bot, no el client_id
            $this->token = env('DISCORD_BOT_TOKEN');

            // Realiza la solicitud GET a la API de Discord
            $response = Http::withHeaders([
                'Authorization' => 'Bot ' . $this->token,
            ])->get('https://discord.com/api/v10/guilds/1096530483417993359');

            // Verifica si la solicitud fue exitosa
            if ($response->successful()) {
                // Decodifica la respuesta JSON
                return $response->json();
            } else {
                // Maneja errores de la API (por ejemplo, 401 Unauthorized)
                return [
                    'error' => true,
                    'message' => 'Error en la solicitud: ' . $response->status(),
                    'details' => $response->json(),
                ];
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Maneja errores de conexión
            return [
                'error' => true,
                'message' => 'Error de conexión: ' . $e->getMessage(),
            ];
        } catch (Exception $e) {
            // Maneja cualquier otro error
            return [
                'error' => true,
                'message' => 'Error inesperado: ' . $e->getMessage(),
            ];
        }
    }  
    
    /**
     * Obtiene la lista de usuarios del servidor de Discord y compara con los IDs de la base de datos.
     *
     * @param string $guildId
     * @return array
     */
    public function getMembersWithRoles()
    {
        
        try {
            // Token del bot
            $this->token = env('DISCORD_BOT_TOKEN');

            $guildId = env('DISCORD_SERVER_LINHIR_TOKEN');

            // Obtener la lista de miembros del servidor
            $membersResponse = Http::withHeaders([
                'Authorization' => 'Bot ' . $this->token,
            ])->get("https://discord.com/api/v10/guilds/{$guildId}/members?limit=1000");

            // Obtener la lista de roles del servidor
            $rolesResponse = Http::withHeaders([
                'Authorization' => 'Bot ' . $this->token,
            ])->get("https://discord.com/api/v10/guilds/{$guildId}/roles");

            // Verificar si las solicitudes fueron exitosas
            if ($membersResponse->successful() && $rolesResponse->successful()) {
                $members = $membersResponse->json();
                $roles = $rolesResponse->json();

                // Mapear roles por ID para facilitar la búsqueda
                $rolesMap = [];
                foreach ($roles as $role) {
                    $rolesMap[$role['id']] = $role['name'];
                }

                // Obtener todos los IDs de Discord almacenados en la base de datos
                $discordUserIds = AuthProvider::where('provider', 'discord')
                    ->pluck('provider_id')
                    ->toArray();

                // Procesar miembros y asignar nombres de roles
                $membersWithRoles = [];
                foreach ($members as $member) {
                    $userRoles = [];
                    foreach ($member['roles'] as $roleId) {
                        if (isset($rolesMap[$roleId])) {
                            $userRoles[] = $rolesMap[$roleId];
                        }
                    }

                    // Verificar si el usuario está en la base de datos
                    $isRegistered = in_array($member['user']['id'], $discordUserIds);

                    // Obtener el apodo (nick) del usuario en el servidor
                    $nickname = $member['nick'] ?? $member['user']['username']; // Usar el nickname si existe, de lo contrario usar el username

                    $membersWithRoles[] = [
                        'user_id' => $member['user']['id'] ?? 'N/A',
                        'username' => $member['user']['username'] ?? 'N/A',
                        'discriminator' => $member['user']['discriminator'] ?? 'N/A',
                        'nickname' => $nickname, // Agregar el apodo del usuario
                        'roles' => $userRoles,
                        'is_registered' => $isRegistered, // Indica si el usuario está registrado en la base de datos
                    ];
                }

                return $membersWithRoles;
            } else {
                // Manejar errores de la API
                return [
                    'error' => true,
                    'message' => 'Error en la solicitud a la API de Discord',
                    'details' => [
                        'members' => $membersResponse->json(),
                        'roles' => $rolesResponse->json(),
                    ],
                ];
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Manejar errores de conexión
            return [
                'error' => true,
                'message' => 'Error de conexión: ' . $e->getMessage(),
            ];
        } catch (Exception $e) {
            // Manejar cualquier otro error
            return [
                'error' => true,
                'message' => 'Error inesperado: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Verifica si un usuario está en el servidor de Discord.
     *
     * @param string $discordUserId
     * @param string $guildId
     * @return bool
     */
    public function isUserInDiscordServer($discordUserId)
    {
        try {
            // Token del bot
            $this->token = env('DISCORD_BOT_TOKEN');

            $guildId = env('DISCORD_SERVER_LINHIR_TOKEN');

            // Obtener la lista de miembros del servidor
            $membersResponse = Http::withHeaders([
                'Authorization' => 'Bot ' . $this->token,
            ])->get("https://discord.com/api/v10/guilds/{$guildId}/members?limit=1000");

            // Verificar si la solicitud fue exitosa
            if ($membersResponse->successful()) {
                $members = $membersResponse->json();

                // Verificar si el usuario está en la lista de miembros
                foreach ($members as $member) {
                    if ($member['user']['id'] === $discordUserId) {
                        return true; // El usuario está en el servidor
                    }
                }

                return false; // El usuario no está en el servidor
            } else {
                // Manejar errores de la API
                throw new Exception('Error en la solicitud a la API de Discord: ' . $membersResponse->status());
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Manejar errores de conexión
            throw new Exception('Error de conexión: ' . $e->getMessage());
        } catch (Exception $e) {
            // Manejar cualquier otro error
            throw new Exception('Error inesperado: ' . $e->getMessage());
        }
    }

    /**
     * Verifica si un el usuario está en el servidor de Discord.     
     */
    public function checkDiscordMembership()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        if (!$user) {
            return false; // No hay usuario autenticado
        }

        // Obtener el proveedor de Discord del usuario
        $discordProvider = $user->authProviders()
            ->where('provider', 'discord') // Asegúrate de que el campo sea 'provider' y no 'provider_name'
            ->first();

        if (!$discordProvider) {
            return false; // El usuario no tiene un proveedor de Discord vinculado
        }

        // Obtener el ID del servidor de Discord desde .env
        $guildId = env('DISCORD_SERVER_LINHIR_TOKEN'); // Asegúrate de que este sea el ID del servidor

        if (!$guildId) {
            return false; // No se ha configurado el ID del servidor
        }

        // Verificar si el usuario está en el servidor de Discord
        try {
            return $this->isUserInDiscordServer($discordProvider->provider_id, $guildId);
        } catch (Exception $e) {
            // Manejar errores (opcional)
            return false;
        }
    }

    /**
     * Obtiene la lista de canales de texto del servidor de Discord.
     *
     * @param string $guildId
     * @return array
     */
    public function getTextChannels()
    {
        try {
            $guildId = env('DISCORD_SERVER_LINHIR_TOKEN');

            // Token del bot
            $this->token = env('DISCORD_BOT_TOKEN');

            // Obtener la lista de canales del servidor
            $channelsResponse = Http::withHeaders([
                'Authorization' => 'Bot ' . $this->token,
            ])->get("https://discord.com/api/v10/guilds/{$guildId}/channels");

            // Verificar si la solicitud fue exitosa
            if ($channelsResponse->successful()) {
                $channels = $channelsResponse->json();

                // Filtrar los canales de texto (type = 0)
                $textChannels = array_filter($channels, function ($channel) {
                    return $channel['type'] === 0; // type 0 = canal de texto
                });

                // Formatear la respuesta
                $formattedChannels = array_map(function ($channel) {
                    return [
                        'id' => $channel['id'],
                        'name' => $channel['name'],
                        'position' => $channel['position'],
                    ];
                }, $textChannels);

                return $formattedChannels;
            } else {
                // Manejar errores de la API
                throw new Exception('Error en la solicitud a la API de Discord: ' . $channelsResponse->status());
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Manejar errores de conexión
            throw new Exception('Error de conexión: ' . $e->getMessage());
        } catch (Exception $e) {
            // Manejar cualquier otro error
            throw new Exception('Error inesperado: ' . $e->getMessage());
        }
    }

    /**
     * Envía un mensaje a un canal de texto de Discord.
     *
     * @param string $channelId
     * @param string $message
     * @return array
     */
    public function sendMessageToChannel($channelId, $message)
    {
        try {
            // Token del bot
            $this->token = env('DISCORD_BOT_TOKEN');

            // Enviar el mensaje al canal
            $response = Http::withHeaders([
                'Authorization' => 'Bot ' . $this->token,
                'Content-Type' => 'application/json',
            ])->post("https://discord.com/api/v10/channels/{$channelId}/messages", [
                'content' => $message,
            ]);

            // Verificar si la solicitud fue exitosa
            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Mensaje enviado correctamente.',
                    'data' => $response->json(),
                ];
            } else {
                // Manejar errores de la API
                throw new Exception('Error al enviar el mensaje: ' . $response->status());
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Manejar errores de conexión
            throw new Exception('Error de conexión: ' . $e->getMessage());
        } catch (Exception $e) {
            // Manejar cualquier otro error
            throw new Exception('Error inesperado: ' . $e->getMessage());
        }
    }

    /**
     * Envía un mensaje con un embed a un canal de texto de Discord.
     *
     * @param string $channelId
     * @param string|null $message
     * @param array|null $embed
     * @return array
     */
    public function sendMessageToChannelEmbed($channelId, $message = null, $embed = null)
    {
        try {
            // Token del bot
            $this->token = env('DISCORD_BOT_TOKEN');

            // Datos del mensaje
            $data = [];
            if ($message) {
                $data['content'] = $message;
            }
            if ($embed) {
                $data['embeds'] = [$embed]; // Los embeds se envían como una lista
            }

            // Enviar el mensaje al canal
            $response = Http::withHeaders([
                'Authorization' => 'Bot ' . $this->token,
                'Content-Type' => 'application/json',
            ])->post("https://discord.com/api/v10/channels/{$channelId}/messages", $data);

            // Verificar si la solicitud fue exitosa
            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Mensaje enviado correctamente.',
                    'data' => $response->json(),
                ];
            } else {
                // Manejar errores de la API
                throw new Exception('Error al enviar el mensaje: ' . $response->status());
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Manejar errores de conexión
            throw new Exception('Error de conexión: ' . $e->getMessage());
        } catch (Exception $e) {
            // Manejar cualquier otro error
            throw new Exception('Error inesperado: ' . $e->getMessage());
        }
    }
    
    public function sendEmbedMessage()
    {
        $channelId = '1096545249830129727'; // Reemplaza con el ID del canal

        // Definir el embed
        $embed = [
            'title' => '¡Nuevo Mensaje! <:linhir_escudo:1337557101358088313>',
            'description' => 'Este es un mensaje enviado desde Linhir Web API con un embed.',
            'color' => 0x00FF00, // Verde
            'fields' => [
                [
                    'name' => 'Campo 1',
                    'value' => 'Valor del campo 1',
                    'inline' => true, // Mostrar en línea
                ],
                [
                    'name' => 'Campo 2',
                    'value' => 'Valor del campo 2',
                    'inline' => true,
                ],
            ],
            'footer' => [
                'text' => 'Pie de página',
            ],
            'timestamp' => now()->toIso8601String(), // Marca de tiempo actual
        ];

        try {
            $result = $this->sendMessageToChannelEmbed($channelId, null, $embed);

            return response()->json($result);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Obtiene la lista de roles del servidor de Discord.
     *
     * @param string $guildId
     * @return array
     */
    public function getRoles()
    {
        try {
            // Token del bot
            $this->token = env('DISCORD_BOT_TOKEN');

            $guildId = env('DISCORD_SERVER_LINHIR_TOKEN');

            // Obtener la lista de roles del servidor
            $rolesResponse = Http::withHeaders([
                'Authorization' => 'Bot ' . $this->token,
            ])->get("https://discord.com/api/v10/guilds/{$guildId}/roles");

            // Verificar si la solicitud fue exitosa
            if ($rolesResponse->successful()) {
                $roles = $rolesResponse->json();

                // Formatear la respuesta
                $formattedRoles = array_map(function ($role) {
                    return [
                        'id' => $role['id'],
                        'name' => $role['name'],
                        'color' => $role['color'],
                        'permissions' => $role['permissions'],
                        'position' => $role['position'],
                        'mentionable' => $role['mentionable'],
                        'hoist' => $role['hoist'],
                    ];
                }, $roles);

                return $formattedRoles;
            } else {
                // Manejar errores de la API
                throw new Exception('Error en la solicitud a la API de Discord: ' . $rolesResponse->status());
            }
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Manejar errores de conexión
            throw new Exception('Error de conexión: ' . $e->getMessage());
        } catch (Exception $e) {
            // Manejar cualquier otro error
            throw new Exception('Error inesperado: ' . $e->getMessage());
        }
    }

}