<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use App\Models\User;
use App\Models\Incident;
use App\Models\Maintenance;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Display statistics dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $stats = [];

        if ($user->role === 'admin') {
            $stats = $this->getAdminStatistics();
        } elseif ($user->role === 'responsable') {
            $stats = $this->getResponsableStatistics($user->id);
        } else {
            $stats = $this->getUserStatistics($user->id);
        }

        return view('statistics.index', compact('stats'));
    }

    /**
     * Get statistics for admin users.
     */
    private function getAdminStatistics()
    {
        return [
            'total_users' => User::count(),
            'active_users' => User::where('active', true)->count(),
            'total_resources' => Resource::count(),
            'available_resources' => Resource::where('etat', 'disponible')->count(),
            'total_reservations' => Reservation::count(),
            'pending_reservations' => Reservation::where('statut', 'en_attente')->count(),
            'approved_reservations' => Reservation::where('statut', 'approuve')->count(),
            'rejected_reservations' => Reservation::where('statut', 'refuse')->count(),
            'reservations_this_month' => Reservation::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
            'reservations_this_week' => Reservation::whereBetween('created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])->count(),
            'most_reserved_resources' => $this->getMostReservedResources(),
            'reservations_by_month' => $this->getReservationsByMonth(),
            'resources_by_category' => $this->getResourcesByCategory(),
            'reservations_by_status' => $this->getReservationsByStatus(),
            'resource_states_data' => $this->getResourceStatesData(),
            'reservation_status_data' => $this->getReservationStatusData(),
        ];
    }

    /**
     * Get statistics for responsable users.
     */
    private function getResponsableStatistics($userId)
    {
        $resources = Resource::where('responsable_id', $userId)->pluck('id');

        return [
            'my_resources' => Resource::where('responsable_id', $userId)->count(),
            'available_resources' => Resource::where('responsable_id', $userId)
                ->where('etat', 'disponible')->count(),
            'total_reservations' => Reservation::whereIn('resource_id', $resources)->count(),
            'pending_reservations' => Reservation::whereIn('resource_id', $resources)
                ->where('statut', 'en_attente')->count(),
            'approved_reservations' => Reservation::whereIn('resource_id', $resources)
                ->where('statut', 'approuve')->count(),
            'rejected_reservations' => Reservation::whereIn('resource_id', $resources)
                ->where('statut', 'refuse')->count(),
            'reservations_this_month' => Reservation::whereIn('resource_id', $resources)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
            'reservations_this_week' => Reservation::whereIn('resource_id', $resources)
                ->whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])->count(),
            'reservations_by_month' => $this->getReservationsByMonth($resources),
            'resources_by_category' => $this->getResourcesByCategory($userId),
            'resource_states_data' => $this->getResourceStatesData($userId),
            'reservation_status_data' => $this->getReservationStatusData($resources),
        ];
    }

    /**
     * Get statistics for regular users.
     */
    private function getUserStatistics($userId)
    {
        return [
            'my_reservations' => Reservation::where('user_id', $userId)->count(),
            'pending_reservations' => Reservation::where('user_id', $userId)
                ->where('statut', 'en_attente')->count(),
            'approved_reservations' => Reservation::where('user_id', $userId)
                ->where('statut', 'approuve')->count(),
            'rejected_reservations' => Reservation::where('user_id', $userId)
                ->where('statut', 'refuse')->count(),
            'reservations_this_month' => Reservation::where('user_id', $userId)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count(),
            'reservations_this_week' => Reservation::where('user_id', $userId)
                ->whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek()
                ])->count(),
            'recent_reservations' => Reservation::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get(),
            'reservations_by_month' => $this->getReservationsByMonth(null, $userId),
            'reservation_status_data' => $this->getReservationStatusData(null, $userId),
        ];
    }

    /**
     * Get reservations grouped by month.
     */
    private function getReservationsByMonth($resourceIds = null, $userId = null)
    {
        $query = Reservation::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->limit(12);

        if ($resourceIds !== null) {
            $query->whereIn('resource_id', $resourceIds);
        }

        if ($userId !== null) {
            $query->where('user_id', $userId);
        }

        return $query->get();
    }

    /**
     * Get resources grouped by category.
     */
    private function getResourcesByCategory($responsableId = null)
    {
        $query = Resource::select(
            'resource_categories.name as category_name',
            DB::raw('COUNT(*) as count')
        )
            ->join('resource_categories', 'resources.categorie_id', '=', 'resource_categories.id')
            ->groupBy('resource_categories.name');

        if ($responsableId !== null) {
            $query->where('resources.responsable_id', $responsableId);
        }

        return $query->get();
    }

    /**
     * Get reservations grouped by status.
     */
    private function getReservationsByStatus()
    {
        return Reservation::select(
            'statut',
            DB::raw('COUNT(*) as count')
        )
            ->groupBy('statut')
            ->get();
    }

    /**
     * Get most reserved resources.
     */
    private function getMostReservedResources($limit = 5)
    {
        return Resource::select(
                'resources.id',
                'resources.nom',
                'resources.description',
                'resources.etat',
                DB::raw('COUNT(reservations.id) as reservation_count')
            )
            ->leftJoin('reservations', 'resources.id', '=', 'reservations.resource_id')
            ->groupBy('resources.id', 'resources.nom', 'resources.description', 'resources.etat')
            ->orderBy('reservation_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get resource states data for pie chart.
     */
    private function getResourceStatesData($responsableId = null)
    {
        $query = Resource::select('etat', DB::raw('COUNT(*) as count'))
            ->groupBy('etat');

        if ($responsableId !== null) {
            $query->where('responsable_id', $responsableId);
        }

        $data = $query->get();

        $labels = [];
        $values = [];
        $colors = [];

        $stateMap = [
            'disponible' => ['label' => 'Disponible', 'color' => '#10b981'],
            'maintenance' => ['label' => 'Maintenance', 'color' => '#f59e0b'],
            'desactive' => ['label' => 'Désactivé', 'color' => '#ef4444'],
        ];

        foreach ($data as $item) {
            $labels[] = $stateMap[$item->etat]['label'] ?? ucfirst($item->etat);
            $values[] = $item->count;
            $colors[] = $stateMap[$item->etat]['color'] ?? '#6b7280';
        }

        return [
            'labels' => $labels,
            'data' => $values,
            'colors' => $colors,
        ];
    }

    /**
     * Get reservation status data for pie chart.
     */
    private function getReservationStatusData($resourceIds = null, $userId = null)
    {
        $query = Reservation::select('statut', DB::raw('COUNT(*) as count'))
            ->groupBy('statut');

        if ($resourceIds !== null) {
            $query->whereIn('resource_id', $resourceIds);
        }

        if ($userId !== null) {
            $query->where('user_id', $userId);
        }

        $data = $query->get();

        $labels = [];
        $values = [];
        $colors = [];

        $statusMap = [
            'en_attente' => ['label' => 'En attente', 'color' => '#f59e0b'],
            'approuve' => ['label' => 'Approuvées', 'color' => '#10b981'],
            'refuse' => ['label' => 'Rejetées', 'color' => '#ef4444'],
        ];

        foreach ($data as $item) {
            $labels[] = $statusMap[$item->statut]['label'] ?? ucfirst($item->statut);
            $values[] = $item->count;
            $colors[] = $statusMap[$item->statut]['color'] ?? '#6b7280';
        }

        return [
            'labels' => $labels,
            'data' => $values,
            'colors' => $colors,
        ];
    }
}