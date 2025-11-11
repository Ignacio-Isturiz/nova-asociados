<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class CitaController extends Controller
{
public function store(Request $request)
    {
        $request->validate([
            'proyecto_id' => 'required|exists:proyectos,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
            'telefono_contacto' => 'required|string|max:20',
        ]);

        $user = Auth::user();

        // Verificar si ya existe una cita en la misma fecha y hora
        $yaExiste = Cita::where('user_id', $user->id)
            ->where('proyecto_id', $request->proyecto_id)
            ->where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->exists();

        if ($yaExiste) {
            // Si la cita ya existe, redirigir con un mensaje de error
            return back()->with('error', 'Ya tienes una cita para este proyecto en esta fecha y hora.');
        }

        // Crear la nueva cita
        $cita = Cita::create([
            'user_id' => $user->id,
            'nombre_usuario' => $user->name,
            'proyecto_id' => $request->proyecto_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'telefono_contacto' => $request->telefono_contacto,
            'estado' => 'pendiente',
        ]);

        // Enviar WhatsApp (como hemos discutido antes)
        $this->enviarWhatsApp($cita, $request, $user);

        // Mostrar mensaje de éxito
        return back()->with('success', 'Tu cita fue agendada correctamente.');
    }

    private function enviarWhatsApp($cita, $request, $user)
    {
        sleep(2); // Retraso de 2 segundos para no bloquear el hilo principal

        try {
            $twilio = new \Twilio\Rest\Client(
                env('TWILIO_SID'),
                env('TWILIO_AUTH_TOKEN')
            );

            $to = 'whatsapp:+57' . preg_replace('/\D/', '', $request->telefono_contacto);
            $proyectoNombre = optional($cita->proyecto)->nombre ?? 'Proyecto';

            $mensaje = "Hola {$user->name}, tu cita para *{$proyectoNombre}* fue agendada para el {$request->fecha} a las {$request->hora}. ✅";

            // Enviar el mensaje a través de Twilio
            $twilio->messages->create($to, [
                'from' => env('TWILIO_WHATSAPP_FROM'),
                'body' => $mensaje
            ]);

        } catch (\Throwable $e) {
            \Log::error('Error enviando WhatsApp: ' . $e->getMessage());
        }
    }
    public function misCitas()
    {
        $user = auth()->user();
        $citas = Cita::where('user_id', $user->id)->orderBy('fecha', 'desc')->orderBy('hora')->get();

        // Generar un array de horas válidas de 30 en 30 minutos de 8 AM a 5 PM
        $horasDisponibles = [];
        for ($hour = 8; $hour <= 17; $hour++) {
            $horasDisponibles[] = Carbon::createFromTime($hour, 0)->format('H:i');
            $horasDisponibles[] = Carbon::createFromTime($hour, 30)->format('H:i');
        }

        return view('citas.mis-citas', compact('citas', 'horasDisponibles'));
    }


    public function todasCitas()
    {
        $citas = Cita::with('usuario', 'proyecto')->orderBy('fecha', 'desc')->orderBy('hora')->get();
        return view('citas.todas-citas', compact('citas'));
    }

public function edit(Cita $cita)
{
    $this->authorize('update', $cita);

    // Generar un array de horas válidas de 30 en 30 minutos de 8 AM a 5 PM
    $horasDisponibles = [];
    for ($hour = 8; $hour <= 17; $hour++) {
        $horasDisponibles[] = Carbon::createFromTime($hour, 0)->format('H:i'); // Horas en formato 'HH:mm'
        $horasDisponibles[] = Carbon::createFromTime($hour, 30)->format('H:i'); // Horas en formato 'HH:mm'
    }

    // Pasamos estas horas disponibles a la vista
    return view('citas.edit', compact('cita', 'horasDisponibles'));
}

public function update(Request $request, Cita $cita)
{
    $this->authorize('update', $cita);

    // Validación de los campos
    $request->validate([
        'fecha' => 'required|date',
        'hora' => 'required',
        'notas' => 'nullable|string|max:500'
    ]);

    // Actualizar la cita con los nuevos datos
    $cita->update($request->only(['fecha', 'hora', 'notas']));

    return redirect()->route('citas.mis')->with('success', 'Cita modificada correctamente.');
}


public function cancelar(Cita $cita)
{
    $this->authorize('cancel', $cita); 

    // Cancelamos directamente la cita
    $cita->update(['estado' => 'cancelada']);

    return redirect()->route('citas.mis')->with('success', 'Cita cancelada correctamente.');
}



}
