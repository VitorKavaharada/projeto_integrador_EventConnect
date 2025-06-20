<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
     //verificar erros de participatedEvents

    public function joinEventConfirm($id)
    {
        $event = Event::findOrFail($id);

        $now = Carbon::now('America/Sao_Paulo');
        $eventDateTime = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $event->date_event->format('Y-m-d') . ' ' . $event->time_event,
            'America/Sao_Paulo'
        );

        if ($event->is_expired || $eventDateTime->lte($now)) {
            return redirect()->back()->with('error', 'Este evento já expirou e não aceita novas inscrições.');
        }

        if ($event->participant_limit && $event->users()->count() >= $event->participant_limit) {
            return redirect('/dashboard')->with('error', 'O limite de participantes para este evento já foi atingido.');
        }

        if ($event->price > 0) {
            return redirect()->route('payment.show', $event->id);
        }

        $user = Auth::user();
        $user->participatedEvents()->attach($id);

        $ticketNumber = Str::uuid()->toString();
        $eventLocation = $event->address ?
            "{$event->address->street}, {$event->address->addressNumber}, {$event->address->neighborhood}, {$event->address->municipality} - {$event->address->state}" :
            'Local não especificado';

        Ticket::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'ticket_number' => $ticketNumber,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_cpf' => $user->cpf ?? 'Não informado',
            'event_headline' => $event->headline,
            'event_date' => $eventDateTime,
            'event_location' => $eventLocation,
            'price' => $event->price,
            'type' => 'normal',
            'qr_code' => $ticketNumber,
        ]);

        return redirect()->route('dashboard.user-events')->with('msg', 'Presença confirmada no evento: ' . $event->headline . '. Ingresso gerado com sucesso!');
    } 

    public function cancelRegistration($id)
    {
        $user = Auth::user();
        $user->participatedEvents()->detach($id);

        Ticket::where('user_id', $user->id)->where('event_id', $id)->delete();

        $event = Event::findOrFail($id);

        return redirect()->route('dashboard.user-events')->with('msg', 'Inscrição cancelada com sucesso: ' . $event->headline);
    }
}