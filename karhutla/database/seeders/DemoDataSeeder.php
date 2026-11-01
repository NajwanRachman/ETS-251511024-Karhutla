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

        // Data wilayah Bandung Raya
        $wilayah = [
            [
                'detail_address' => 'Kecamatan Baleendah',
                'city_regency' => 'Kabupaten Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Soreang',
                'city_regency' => 'Kabupaten Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Dayeuhkolot',
                'city_regency' => 'Kabupaten Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Bojongsoang',
                'city_regency' => 'Kabupaten Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Banjaran',
                'city_regency' => 'Kabupaten Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Margahayu',
                'city_regency' => 'Kabupaten Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Katapang',
                'city_regency' => 'Kabupaten Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Cileunyi',
                'city_regency' => 'Kabupaten Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Rancaekek',
                'city_regency' => 'Kabupaten Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Ciparay',
                'city_regency' => 'Kabupaten Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Majalaya',
                'city_regency' => 'Kabupaten Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Coblong',
                'city_regency' => 'Kota Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Lengkong',
                'city_regency' => 'Kota Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Kiaracondong',
                'city_regency' => 'Kota Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Antapani',
                'city_regency' => 'Kota Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Buahbatu',
                'city_regency' => 'Kota Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Ujungberung',
                'city_regency' => 'Kota Bandung',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Lembang',
                'city_regency' => 'Kabupaten Bandung Barat',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Padalarang',
                'city_regency' => 'Kabupaten Bandung Barat',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Cimahi Utara',
                'city_regency' => 'Kota Cimahi',
                'province' => 'Jawa Barat',
            ],
            [
                'detail_address' => 'Kecamatan Cimahi Tengah',
                'city_regency' => 'Kota Cimahi',
                'province' => 'Jawa Barat',
            ],
        ];

        // Alihkan tiga alamat lama tanpa menghapus relasi laporan
        $oldAddresses = [
            'Desa Sukamaju' => 'Kecamatan Baleendah',
            'Desa Mekarjaya' => 'Kecamatan Soreang',
            'Desa Sumberagung' => 'Kecamatan Dayeuhkolot',
        ];

        foreach ($oldAddresses as $oldName => $newName) {
            $address = Address::where('detail_address', $oldName)->first();

            if ($address) {
                $newData = collect($wilayah)->firstWhere('detail_address', $newName);

                $address->update($newData);
            }
        }

        // Tambahkan seluruh wilayah lainnya
        foreach ($wilayah as $data) {
            Address::updateOrCreate(
                [
                    'detail_address' => $data['detail_address'],
                    'city_regency' => $data['city_regency'],
                    'province' => $data['province'],
                ],
                [
                    'island' => 'Jawa',
                ]
            );
        }

        
    // Ambil akun demo
    $reporter = User::where('email', 'reporter@karhutla.test')->firstOrFail();
    $volunteer = User::where('email', 'volunteer@karhutla.test')->firstOrFail();
    $coordinator = User::where('email', 'coordinator@karhutla.test')->firstOrFail();

    // Ambil data wilayah
    $addresses = Address::all()->keyBy('detail_address');
    $reportData = [
        [
            'description' => 'Terlihat asap tebal di sekitar area hutan.',
            'address' => 'Kecamatan Baleendah',
            'level' => 'high',
            'latitude' => -7.0005000,
            'longitude' => 107.6307000,
            'status' => 'submitted',
            'days' => 1,
        ],
        [
            'description' => 'Ditemukan indikasi pembakaran lahan kosong.',
            'address' => 'Kecamatan Soreang',
            'level' => 'medium',
            'latitude' => -7.0249000,
            'longitude' => 107.5262000,
            'status' => 'under_review',
            'days' => 2,
        ],
        [
            'description' => 'Terlihat titik api kecil di sekitar perkebunan.',
            'address' => 'Kecamatan Dayeuhkolot',
            'level' => 'high',
            'latitude' => -6.9878000,
            'longitude' => 107.6215000,
            'status' => 'reviewed',
            'days' => 3,
        ],
        [
            'description' => 'Asap terpantau di area hutan dekat pemukiman.',
            'address' => 'Kecamatan Baleendah',
            'level' => 'high',
            'latitude' => -7.0050000,
            'longitude' => 107.6350000,
            'status' => 'forwarded',
            'days' => 4,
        ],
        [
            'description' => 'Laporan indikasi kebakaran telah ditindaklanjuti.',
            'address' => 'Kecamatan Soreang',
            'level' => 'low',
            'latitude' => -7.0300000,
            'longitude' => 107.5300000,
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
