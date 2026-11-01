<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Hash;
use App\Models\Report;
use App\Models\ReportReview;
use App\Models\ReportForwarding;
use App\Models\ReportStatusLog;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Akun reporter
        User::updateOrCreate(
            ['email' => 'reporter@karhutla.test'],
            [
                'name' => 'Demo Reporter',
                'password' => Hash::make('password123'),
                'phone_number' => '081234567890',
                'role' => 'reporter',
            ]
        );

        // Akun volunteer
        User::updateOrCreate(
            ['email' => 'volunteer@karhutla.test'],
            [
                'name' => 'Demo Volunteer',
                'password' => Hash::make('password123'),
                'phone_number' => '081234567891',
                'role' => 'volunteer',
            ]
        );

        // Akun coordinator
        User::updateOrCreate(
            ['email' => 'coordinator@karhutla.test'],
            [
                'name' => 'Demo Coordinator',
                'password' => Hash::make('password123'),
                'phone_number' => '081234567892',
                'role' => 'coordinator',
            ]
        );

        // Data wilayah
        Address::updateOrCreate(
            [
                'detail_address' => 'Desa Sukamaju',
                'city_regency' => 'Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'island' => 'Jawa',
            ]
        );

        Address::updateOrCreate(
            [
                'detail_address' => 'Desa Mekarjaya',
                'city_regency' => 'Garut',
                'province' => 'Jawa Barat',
            ],
            [
                'island' => 'Jawa',
            ]
        );

        Address::updateOrCreate(
            [
                'detail_address' => 'Desa Sumberagung',
                'city_regency' => 'Banyuwangi',
                'province' => 'Jawa Timur',
            ],
            [
                'island' => 'Jawa',
            ]
        );

        
// Ambil akun demo
$reporter = User::where('email', 'reporter@karhutla.test')->firstOrFail();
$volunteer = User::where('email', 'volunteer@karhutla.test')->firstOrFail();
$coordinator = User::where('email', 'coordinator@karhutla.test')->firstOrFail();

// Ambil data wilayah
$addresses = Address::all()->keyBy('detail_address');

$reportData = [
    [
        'description' => 'Terlihat asap tebal di sekitar area hutan.',
        'address' => 'Desa Sukamaju',
        'level' => 'high',
        'latitude' => -6.9000000,
        'longitude' => 107.6000000,
        'status' => 'submitted',
        'days' => 1,
    ],
    [
        'description' => 'Ditemukan indikasi pembakaran lahan kosong.',
        'address' => 'Desa Mekarjaya',
        'level' => 'medium',
        'latitude' => -7.2000000,
        'longitude' => 107.9000000,
        'status' => 'under_review',
        'days' => 2,
    ],
    [
        'description' => 'Terlihat titik api kecil di sekitar perkebunan.',
        'address' => 'Desa Sumberagung',
        'level' => 'high',
        'latitude' => -8.2000000,
        'longitude' => 114.3000000,
        'status' => 'reviewed',
        'days' => 3,
    ],
    [
        'description' => 'Asap terpantau di area hutan dekat pemukiman.',
        'address' => 'Desa Sukamaju',
        'level' => 'high',
        'latitude' => -6.9100000,
        'longitude' => 107.6100000,
        'status' => 'forwarded',
        'days' => 4,
    ],
    [
        'description' => 'Laporan indikasi kebakaran telah ditindaklanjuti.',
        'address' => 'Desa Mekarjaya',
        'level' => 'low',
        'latitude' => -7.2100000,
        'longitude' => 107.9100000,
        'status' => 'closed',
        'days' => 5,
    ],
];

foreach ($reportData as $data) {
    $report = Report::firstOrCreate(
        [
            'reporter_id' => $reporter->user_id,
            'report_description' => $data['description'],
        ],
        [
            'address_id' => $addresses[$data['address']]->address_id,
            'incident_time' => now()->subDays($data['days']),
            'condition_level' => $data['level'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'status' => $data['status'],
        ]
    );

    // Buat review untuk laporan yang sudah ditinjau
    if (in_array($data['status'], ['under_review', 'reviewed', 'forwarded', 'closed'])) {
        ReportReview::firstOrCreate(
            [
                'report_id' => $report->report_id,
                'volunteer_id' => $volunteer->user_id,
            ],
            [
                'review_data' => 'Pemeriksaan awal laporan',
                'review_note' => 'Informasi laporan telah diperiksa.',
                'follow_up_required' => true,
            ]
        );
    }

    // Buat data forwarding
    if (in_array($data['status'], ['forwarded', 'closed'])) {
        ReportForwarding::firstOrCreate(
            [
                'report_id' => $report->report_id,
                'coordinator_id' => $coordinator->user_id,
            ],
            [
                'forwarded_at' => now()->subDays($data['days']),
                'forwarding_note' => 'Laporan diteruskan untuk tindak lanjut.',
                'destination_name' => 'Instansi terkait',
            ]
        );
    }

    // Catat riwayat perubahan status
    $statusHistory = [
        'submitted' => [],
        'under_review' => [
            ['submitted', 'under_review', $volunteer->user_id],
        ],
        'reviewed' => [
            ['submitted', 'under_review', $volunteer->user_id],
            ['under_review', 'reviewed', $volunteer->user_id],
        ],
        'forwarded' => [
            ['submitted', 'under_review', $volunteer->user_id],
            ['under_review', 'reviewed', $volunteer->user_id],
            ['reviewed', 'forwarded', $coordinator->user_id],
        ],
        'closed' => [
            ['submitted', 'under_review', $volunteer->user_id],
            ['under_review', 'reviewed', $volunteer->user_id],
            ['reviewed', 'forwarded', $coordinator->user_id],
            ['forwarded', 'closed', $coordinator->user_id],
        ],
    ];

    // Status awal laporan
    if ($data['status'] === 'submitted') {
        ReportStatusLog::firstOrCreate(
            [
                'report_id' => $report->report_id,
                'old_status' => null,
                'new_status' => 'submitted',
            ],
            [
                'changed_by' => $reporter->user_id,
            ]
        );
    }

    foreach ($statusHistory[$data['status']] as $history) {
        ReportStatusLog::firstOrCreate(
            [
                'report_id' => $report->report_id,
                'old_status' => $history[0],
                'new_status' => $history[1],
            ],
            [
                'changed_by' => $history[2],
            ]
        );
    }
}

    }
}
