<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Arsip;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name'     => 'Admin User',
                'email'    => 'admin@sipasti.id',
                'password' => Hash::make('password'),
            ]
        );

        // Create sample arsip records
        $samples = [
            [
                'nomor_definitif'   => 'ARC-2024-09',
                'seri'              => 'Laporan Keuangan Q1 2024',
                'kode_klasifikasi'  => 'KU.01.01',
                'kategori'          => 'Finance',
                'kondisi'           => 'Baik',
                'status'            => 'active',
                'file_name'         => 'Financial_Report_Q1.pdf',
            ],
            [
                'nomor_definitif'   => 'ARC-2024-045',
                'seri'              => 'Surat Keputusan Direksi No. 4',
                'kode_klasifikasi'  => 'HK.01.02',
                'kategori'          => 'Legal',
                'kondisi'           => 'Baik',
                'status'            => 'active',
                'file_name'         => 'SK_Dir_04_2024.docx',
            ],
            [
                'nomor_definitif'   => 'ARC-2023-982',
                'seri'              => 'Data Karyawan Periode 2023',
                'kode_klasifikasi'  => 'KP.02.01',
                'kategori'          => 'HR Records',
                'kondisi'           => 'Baik',
                'status'            => 'archived',
                'file_name'         => 'Employee_Records_2023.xlsx',
            ],
            [
                'nomor_definitif'   => 'ARC-2024-172',
                'seri'              => 'Kontrak Vendor IT Services',
                'kode_klasifikasi'  => 'HK.02.04',
                'kategori'          => 'Legal',
                'kondisi'           => 'Baik',
                'status'            => 'active',
                'file_name'         => 'Vendor_ContractIT.pdf',
            ],
        ];

        foreach ($samples as $data) {
            Arsip::create($data);
        }
    }
}
