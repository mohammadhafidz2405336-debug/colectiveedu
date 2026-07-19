<?php

namespace App\Imports;

use App\Models\StudyProgram;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudyProgramsImport implements ToModel, WithHeadingRow
{
    protected $universityId;

    public function __construct($universityId)
    {
        $this->universityId = $universityId;
    }

    public function model(array $row)
    {
        // Abaikan jika baris 'nama jurusan' kosong (misal baris tak sengaja terisi spasi)
        if (empty($row['nama_jurusan'])) {
            return null;
        }

        /* 
         * updateOrCreate: 
         * Parameter 1 (Array pertama): Kondisi pencarian (Apakah jurusan ini sudah ada di kampus ini?)
         * Parameter 2 (Array kedua): Data yang akan diupdate (jika ketemu) atau dibuat (jika baru)
         */
        return StudyProgram::updateOrCreate(
            [
                'university_id' => $this->universityId,
                'name'          => strtoupper(trim($row['nama_jurusan'])), // Kita buat huruf besar agar rapi
            ],
            [
                'cluster'            => strtoupper(trim($row['rumpun'] ?? '')),
                'snbp_capacity'      => $row['daya_tampung_snbp'] ?? 0,
                'snbt_capacity'      => $row['daya_tampung_snbt'] ?? 0,
                'snbp_applicants'    => $row['peminat_snbp'] ?? 0,
                'snbt_applicants'    => $row['peminat_snbt'] ?? 0,
                // Kolom header 'Portofolio (1=Ya, 0=Tidak)' otomatis dibaca menjadi 'portofolio_1ya_0tidak' oleh Laravel Excel
                'requires_portfolio' => isset($row['portofolio_1ya_0tidak']) ? (bool) $row['portofolio_1ya_0tidak'] : false,
            ]
        );
    }
}