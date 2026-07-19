<?php

namespace App\Exports;

use App\Models\StudyProgram;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StudyProgramsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $universityId;

    public function __construct($universityId)
    {
        $this->universityId = $universityId;
    }

    public function collection()
    {
        // Jika belum ada jurusan, ini akan mengembalikan data kosong (hanya header saja saat didownload)
        // Jika sudah ada, ini akan mengambil semua jurusan di kampus tersebut
        return StudyProgram::where('university_id', $this->universityId)->get();
    }

    public function map($program): array
    {
        return [
            $program->name,
            $program->cluster,
            $program->snbp_capacity,
            $program->snbt_capacity,
            $program->snbp_applicants,
            $program->snbt_applicants,
            $program->requires_portfolio ? '1' : '0',
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Jurusan', 
            'Rumpun', 
            'Daya Tampung SNBP', 
            'Daya Tampung SNBT', 
            'Peminat SNBP', 
            'Peminat SNBT', 
            'Portofolio (1=Ya, 0=Tidak)'
        ];
    }
}