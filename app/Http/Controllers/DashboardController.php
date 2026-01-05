<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index()
    {
        $user = Auth::user();

        return match ($user->role) {
            'admin' => view(
                'admin.dashboard',
                $this->dashboardService->admin()
            ),
            'kasir' => view(
                'kasir.dashboard',
                $this->dashboardService->kasir($user)
            ),
            default => abort(403),
        };
    }
}
