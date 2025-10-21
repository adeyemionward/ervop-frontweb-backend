<?php

namespace App\Http\Controllers\API\Professionals;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function summary(Request $request)
    {
        $filter = $request->query('filter', 'thisMonth'); // default filter
        [$startDate, $endDate] = $this->getDateRange($filter);

        // 💰 Revenue
        $thisPeriodRevenue = Revenue::whereBetween('created_at', [$startDate, $endDate])->sum('amount');
        $totalRevenue = Revenue::sum('amount');

        // 🧾 Invoices
        $thisPeriodInvoices = Invoice::whereBetween('created_at', [$startDate, $endDate])->sum('subtotal');
        $totalInvoices = Invoice::sum('subtotal');

        // 🏗️ Projects
        $thisPeriodProjects = Project::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalProjects = Project::count();

        // 📅 Appointments
        $thisPeriodAppointments = Appointment::whereBetween('date', [$startDate, $endDate])->count();
        $totalAppointments = Appointment::count();

        // 👥 New Clients
        $thisPeriodClients = Contact::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalClients = Contact::count();

        return response()->json([
            'filter' => $filter,

            'revenue' => [
                'current' => $thisPeriodRevenue,
                'total' => $totalRevenue,
            ],

            'invoices' => [
                'current' => $thisPeriodInvoices,
                'total' => $totalInvoices,
            ],

            'projects' => [
                'current' => $thisPeriodProjects,
                'total' => $totalProjects,
            ],

            'appointments' => [
                'current' => $thisPeriodAppointments,
                'total' => $totalAppointments,
            ],

            'clients' => [
                'current' => $thisPeriodClients,
                'total' => $totalClients,
            ],
        ]);
    }

    private function getDateRange($filter)
    {
        $today = Carbon::today();

        return match ($filter) {
            'today' => [$today->copy()->startOfDay(), $today->copy()->endOfDay()],
            'thisWeek' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'lastWeek' => [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()],
            'lastMonth' => [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()],
            default => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()], // thisMonth
        };
    }
}
