<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Ticket;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Event;

class DashboardController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * Retorna a página principal do dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $data = $this->getDashboardData();

        return view('events.dashboard', [
            'createdEvents' => $data['createdEvents'],
            'participatedEvents' => $data['participatedEvents'],
            'historicalEvents' => $data['historicalEvents'],
            'tickets' => $data['tickets'],
            'pendingPayments' => $data['pendingPayments']
        ]);
    }

    /**
     * Retorna a página de eventos do usuário (ingressos, jogos inscritos e histórico).
     *
     * @return \Illuminate\View\View
     */
    public function userEvents()
    {
        $data = $this->getDashboardData();

        return view('events.user-events', [
            'participatedEvents' => $data['participatedEvents'],
            'historicalEvents' => $data['historicalEvents'],
            'tickets' => $data['tickets'],
            'pendingPayments' => $data['pendingPayments'] // Adicionado
        ]);
    }

    /**
     * Retorna a página de jogos criados pelo usuário.
     *
     * @return \Illuminate\View\View
     */
    public function createdEvents()
    {
        $data = $this->getDashboardData();

        return view('events.created-events', [
            'createdEvents' => $data['createdEvents'] // Removido pendingPayments
        ]);
    }

    /**
     * Obtém todos os dados necessários para o dashboard e suas subpáginas.
     *
     * @return array
     */
    private function getDashboardData()
    {
        $user = Auth::user();
        $now = Carbon::now('America/Sao_Paulo');

        // Eventos criados
        $createdEvents = $this->getFilteredEvents($user->events()->where('is_expired', false)->get(), $now);

        // Eventos em que o usuário está inscrito
        $participatedEvents = $this->getFilteredEvents($user->participatedEvents()->where('is_expired', false)->get(), $now);

        // Histórico de eventos
        $historicalEvents = $user->participatedEvents()->where('is_expired', true)->get();

        // Ingressos do usuário
        $tickets = Ticket::where('user_id', $user->id)->get();

        // Pagamentos pendentes
        $pendingPayments = $this->getPendingPayments($user);

        return [
            'createdEvents' => $createdEvents,
            'participatedEvents' => $participatedEvents,
            'historicalEvents' => $historicalEvents,
            'tickets' => $tickets,
            'pendingPayments' => $pendingPayments
        ];
    }

    /**
     * Filtra eventos, marcando como expirados aqueles cuja data e hora já passaram.
     *
     * @param \Illuminate\Database\Eloquent\Collection $events
     * @param \Carbon\Carbon $now
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getFilteredEvents($events, $now)
    {
        return $events->filter(function ($event) use ($now) {
            $eventDateTime = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $event->date_event->format('Y-m-d') . ' ' . $event->time_event,
                'America/Sao_Paulo'
            );
            if ($eventDateTime->lte($now) && !$event->is_expired) {
                $event->update(['is_expired' => true]);
                return false;
            }
            return true;
        });
    }

    /**
     * Obtém pagamentos pendentes para o usuário nos últimos 30 dias.
     *
     * @param \App\Models\User $user
     * @return array
     */
    private function getPendingPayments($user)
    {
        $pendingPayments = [];
        $thirtyDaysAgo = Carbon::now()->subDays(30)->timestamp;
        $paymentIntents = PaymentIntent::all([
            'limit' => 100,
            'created' => ['gte' => $thirtyDaysAgo],
        ])->data;

        foreach ($paymentIntents as $paymentIntent) {
            $metadata = $paymentIntent->metadata;
            if (
                isset($metadata['event_id']) && isset($metadata['user_id']) &&
                $metadata['user_id'] === (string) $user->id &&
                $paymentIntent->status === 'succeeded'
            ) {
                $eventId = $metadata['event_id'];
                $event = Event::find($eventId);
                if ($event && !$event->tickets()->where('user_id', $user->id)->exists()) {
                    $pendingPayments[$eventId] = $event;
                }
            }
        }

        return $pendingPayments;
    }
}