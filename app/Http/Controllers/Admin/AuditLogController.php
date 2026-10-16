<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $action = $request->input('action');

        $query = AuditLog::query()
            ->when($search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('description', 'like', "%{$search}%")
                        ->orWhere('user_name', 'like', "%{$search}%")
                        ->orWhere('ip_address', 'like', "%{$search}%");
                });
            })
            ->when($action, function ($q, $action) {
                $q->where('action', $action);
            })
            ->latest();

        $auditLogs = $query->paginate(15)->withQueryString();

        // Predefined common actions or distinct from table
        $actions = ['Create', 'Update', 'Delete', 'Update setting', 'Approve', 'Login', 'Logout'];
        $existingActions = AuditLog::select('action')->distinct()->pluck('action')->toArray();
        $allActions = array_values(array_unique(array_merge($actions, $existingActions)));

        return view('admin.audit-logs.index', [
            'auditLogs' => $auditLogs,
            'actions' => $allActions,
            'search' => $search,
            'selectedAction' => $action,
        ]);
    }
}
