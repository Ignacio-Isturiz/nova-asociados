<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CitaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'proyecto_id' => 'required|exists:proyectos,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
            'telefono_contacto' => 'nullable|string|max:20',
        ]);

        $user = Auth::user(); // <- esto te faltaba en tu snippet

        // evitar duplicadas
        $yaExiste = Cita::where('user_id', $user->id)
            ->where('proyecto_id', $request->proyecto_id)
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->exists();

        if ($yaExiste) {
            return back()->with('error', 'Ya tienes una cita para ese proyecto en esa fecha y hora.');
        }

        // crear la cita
        $cita = Cita::create([
            'user_id'         => $user->id,
            'nombre_usuario'  => $user->name,   // ya lo estás guardando
            'proyecto_id'     => $request->proyecto_id,
            'fecha'           => $request->fecha,
            'hora'            => $request->hora,
            'telefono_contacto' => $request->telefono_contacto,
            'estado'          => 'pendiente',
        ]);

        // ==========================
        // ENVÍO WHATSAPP CON TWILIO
        // ==========================
        if (class_exists(\Twilio\Rest\Client::class)) {
            try {
                $twilio = new \Twilio\Rest\Client(
                    env('TWILIO_SID'),
                    env('TWILIO_AUTH_TOKEN')
                );

                // número destino (el que el usuario puso)
                // si en tu país no es +57, cambia esto
                $to = 'whatsapp:+57' . preg_replace('/\D/', '', $request->telefono_contacto);

                $proyectoNombre = optional($cita->proyecto)->nombre ?? 'Proyecto';

                $twilio->messages->create($to, [
                    'from' => env('TWILIO_WHATSAPP_FROM'),
                    'body' => "Hola {$user->name}, tu cita para *{$proyectoNombre}* fue agendada para el {$request->fecha} a las {$request->hora}. ✅"
                ]);

            } catch (\Throwable $e) {
                Log::error('Error enviando WhatsApp: '.$e->getMessage());
            }
        } else {
            Log::warning('Twilio SDK no está instalado, no se envió WhatsApp.');
        }

        return back()->with('success', 'Tu cita fue agendada correctamente.');
    }
}
