<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Report;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::get('/login', [AuthController::class, 'showLoginForm']);

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');
});

Route::middleware('auth')->group(function () {

    // Arahkan pengguna sesuai role
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;

        if ($role === 'reporter') {
            return redirect()->route('reporter.dashboard');
        }

        if ($role === 'volunteer') {
            return redirect()->route('volunteer.dashboard');
        }

        if ($role === 'coordinator') {
            return redirect()->route('coordinator.dashboard');
        }

        abort(403);
    })->name('dashboard');

    // Dashboard dan laporan reporter
    Route::middleware('role:reporter')->group(function () {

        Route::get('/reporter/dashboard', function () {
            $reports = Report::where('reporter_id', Auth::id());

            $totalReports = (clone $reports)->count();

            $underReview = (clone $reports)
                ->whereIn('status', ['submitted', 'under_review'])
                ->count();

            $completed = (clone $reports)
                ->where('status', 'closed')
                ->count();

            return view('reporter.dashboard', compact(
                'totalReports',
                'underReview',
                'completed'
            ));
        })->name('reporter.dashboard');

        // Daftar laporan reporter
        Route::get('/reporter/reports', [ReportController::class, 'index'])
        ->name('reporter.reports.index');

        // Form buat laporan
        Route::get('/reporter/reports/create', [ReportController::class, 'create'])
            ->name('reporter.reports.create');

        // Detail laporan
        Route::get('/reporter/reports/{id}', [ReportController::class, 'show'])
        ->name('reporter.reports.show');

        // Simpan laporan
        Route::post('/reporter/reports', [ReportController::class, 'store'])
            ->name('reporter.reports.store');
    });

    
        // Dashboard volunteer
        Route::middleware('role:volunteer')->group(function () {

            // Dashboard Volunteer
            Route::get('/volunteer/dashboard', function () {
                $totalReports = Report::count();

                $needReview = Report::whereIn('status', [
                    'submitted',
                    'under_review'
                ])->count();

                $reviewed = Report::whereIn('status', [
                    'reviewed',
                    'forwarded',
                    'closed'
                ])->count();

                return view('volunteer.dashboard', compact(
                    'totalReports',
                    'needReview',
                    'reviewed'
                ));
            })->name('volunteer.dashboard');

            // Daftar laporan untuk Volunteer
            Route::get('/volunteer/reports', [ReportController::class, 'volunteerIndex'])
                ->name('volunteer.reports.index');

            // Detail laporan untuk Volunteer
            Route::get('/volunteer/reports/{id}', [ReportController::class, 'volunteerShow'])
                ->name('volunteer.reports.show');

            // Menyimpan hasil pemeriksaan
            Route::post('/volunteer/reports/{id}/review', [ReportController::class, 'review'])
                ->name('volunteer.reports.review');

        });

    // Dashboard coordinator
    Route::middleware('role:coordinator')->group(function () {

        Route::get('/coordinator/dashboard', function () {
            $totalReports = Report::count();

            $waitingForwarding = Report::whereIn('status', [
                'submitted',
                'under_review',
                'reviewed'
            ])->count();

            $forwarded = Report::whereIn('status', [
                'forwarded',
                'closed'
            ])->count();

            return view('coordinator.dashboard', compact(
                'totalReports',
                'waitingForwarding',
                'forwarded'
            ));
        })->name('coordinator.dashboard');
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});
