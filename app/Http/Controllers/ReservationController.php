<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // عرض جميع الحجوزات (for regular users)
    public function index()
    {
        $reservations = Reservation::with(['resource', 'user'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('reservation.index', compact('reservations'));
    }

    // Admin/Responsable view of all reservations
    public function adminIndex()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $reservations = Reservation::with(['resource', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->role === 'responsable') {
            $resourceIds = Resource::where('responsable_id', $user->id)->pluck('id');
            $reservations = Reservation::with(['resource', 'user'])
                ->whereIn('resource_id', $resourceIds)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            abort(403, 'Accès interdit');
        }
        
        return view('reservations.admin', compact('reservations'));
    }

    // formulaire création réservation
    public function create()
    {
        $resources = Resource::where('etat', 'disponible')->get();
        return view('reservation.create', compact('resources'));
    }

    // تخزين حجز جديد
    public function store(Request $request)
    {
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'date_debut' => 'required|date|after:now',
            'date_fin' => 'required|date|after:date_debut',
            'justification' => 'nullable|string|max:500',
        ]);

        $resource = Resource::findOrFail($request->resource_id);
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'resource_id' => $request->resource_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'statut' => 'en_attente',
        ]);

        // Send notification to admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Notification::create([
                'user_id' => $admin->id,
                'message' => "Nouvelle réservation créée pour la ressource: {$resource->nom} par " . Auth::user()->name,
            ]);
        }

        // Send notification to resource responsable
        if ($resource->responsable_id) {
            Notification::create([
                'user_id' => $resource->responsable_id,
                'message' => "Nouvelle réservation créée pour votre ressource: {$resource->nom} par " . Auth::user()->name,
            ]);
        }

        // Send notification to user
        Notification::create([
            'user_id' => Auth::id(),
            'message' => "Votre réservation pour la ressource {$resource->nom} a été créée et est en attente d'approbation.",
        ]);

        return redirect()->route('reservations.index')
                         ->with('success', 'Réservation créée avec succès');
    }

    // Quick reservation from resource list
    public function quickReserve(Request $request, $resourceId)
    {
        $request->validate([
            'date_debut' => 'required|date|after:now',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $resource = Resource::findOrFail($resourceId);
        
        if ($resource->etat !== 'disponible') {
            return redirect()->route('resources.index')
                           ->with('error', 'Cette ressource n\'est pas disponible pour réservation.');
        }

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'resource_id' => $resourceId,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'statut' => 'en_attente',
        ]);

        // Send notification to admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Notification::create([
                'user_id' => $admin->id,
                'message' => "Nouvelle réservation créée pour la ressource: {$resource->nom} par " . Auth::user()->name,
            ]);
        }

        // Send notification to resource responsable
        if ($resource->responsable_id) {
            Notification::create([
                'user_id' => $resource->responsable_id,
                'message' => "Nouvelle réservation créée pour votre ressource: {$resource->nom} par " . Auth::user()->name,
            ]);
        }

        // Send notification to user
        Notification::create([
            'user_id' => Auth::id(),
            'message' => "Votre réservation pour la ressource {$resource->nom} a été créée et est en attente d'approbation.",
        ]);

        return redirect()->route('resources.index')
                         ->with('success', 'Réservation créée avec succès');
    }

    // تحديث حالة الحجز (admin/responsable)
    public function updateStatus(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'statut' => 'required|in:approuve,refuse',
        ]);

        $oldStatus = $reservation->statut;
        $reservation->update([
            'statut' => $request->statut === 'approuve' ? 'approuve' : 'refuse',
        ]);

        $resource = $reservation->resource;
        $statusText = $request->statut === 'approuve' ? 'approuvée' : 'refusée';

        // Send notification to user
        Notification::create([
            'user_id' => $reservation->user_id,
            'message' => "Votre réservation pour la ressource {$resource->nom} a été {$statusText}.",
        ]);

        return redirect()->back()
                         ->with('success', 'Statut de la réservation mis à jour');
    }

    // Approve reservation (admin/responsable)
    public function approve($id)
    {
        $reservation = Reservation::with(['resource', 'user'])->findOrFail($id);
        
        // Check if user is admin or responsable of the resource
        $currentUser = Auth::user();
        $canApprove = false;
        
        if ($currentUser->role === 'admin') {
            $canApprove = true;
        } elseif ($currentUser->role === 'responsable' && $reservation->resource->responsable_id === $currentUser->id) {
            $canApprove = true;
        }
        
        if (!$canApprove) {
            abort(403, 'Vous n\'avez pas la permission d\'approuver cette réservation.');
        }
        
        $reservation->update(['statut' => 'approuve']);
        
        $resource = $reservation->resource;
        $reservationUser = $reservation->user;
        
        // Send notification to user who made the reservation
        try {
            $notification = Notification::create([
                'user_id' => $reservation->user_id,
                'message' => "✅ Votre réservation pour la ressource '{$resource->nom}' a été approuvée!",
                'lu' => false,
            ]);
            
            \Log::info('Notification created', [
                'notification_id' => $notification->id,
                'user_id' => $notification->user_id,
                'message' => $notification->message
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create notification', [
                'error' => $e->getMessage(),
                'reservation_id' => $reservation->id,
                'user_id' => $reservation->user_id
            ]);
        }
        
        return redirect()->back()
                         ->with('success', 'Réservation approuvée avec succès');
    }

    // Reject reservation (admin/responsable)
    public function reject($id)
    {
        $reservation = Reservation::with(['resource', 'user'])->findOrFail($id);
        
        // Check if user is admin or responsable of the resource
        $currentUser = Auth::user();
        $canReject = false;
        
        if ($currentUser->role === 'admin') {
            $canReject = true;
        } elseif ($currentUser->role === 'responsable' && $reservation->resource->responsable_id === $currentUser->id) {
            $canReject = true;
        }
        
        if (!$canReject) {
            abort(403, 'Vous n\'avez pas la permission de refuser cette réservation.');
        }
        
        $reservation->update(['statut' => 'refuse']);
        
        $resource = $reservation->resource;
        $reservationUser = $reservation->user;
        
        // Send notification to user who made the reservation
        try {
            $notification = Notification::create([
                'user_id' => $reservation->user_id,
                'message' => "❌ Votre réservation pour la ressource '{$resource->nom}' a été refusée.",
                'lu' => false,
            ]);
            
            \Log::info('Notification created', [
                'notification_id' => $notification->id,
                'user_id' => $notification->user_id,
                'message' => $notification->message
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create notification', [
                'error' => $e->getMessage(),
                'reservation_id' => $reservation->id,
                'user_id' => $reservation->user_id
            ]);
        }
        
        return redirect()->back()
                         ->with('success', 'Réservation refusée');
    }

    // حذف حجز
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Allow user to delete only their own reservations
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Accès interdit');
        }

        $reservation->delete();

        return redirect()->route('reservations.index')
                         ->with('success', 'Réservation supprimée');
    }
}

