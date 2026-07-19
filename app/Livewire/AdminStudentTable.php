<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class AdminStudentTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $statusFilter = '';
    public $kelasFilter = ''; // Properti baru untuk menampung kelas yang diklik

    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatusFilter() { $this->resetPage(); }
    public function updatingKelasFilter() { $this->resetPage(); }

    public function render()
    {
        // 1. MENGAMBIL DATA STATISTIK KELAS UNTUK KARTU
        // Ambil semua siswa yang punya kelas
        $semuaSiswa = User::where('role', 'student')->whereNotNull('kelas')->with('assessment')->get();
        $kelasGrouped = $semuaSiswa->groupBy('kelas');
        
        $kelasStats = [];
        foreach ($kelasGrouped as $kelas => $students) {
            // Hitung berapa siswa di kelas ini yang statusnya 'completed'
            $selesai = $students->filter(fn($s) => $s->assessment && $s->assessment->status === 'completed')->count();
            $kelasStats[$kelas] = [
                'total' => $students->count(),
                'selesai' => $selesai
            ];
        }
        ksort($kelasStats); // Mengurutkan nama kelas dari A-Z (9A, 9B, dst)

        // 2. QUERY UNTUK TABEL UTAMA BAWAH
        $query = User::with(['assessment', 'recommendation'])->where('role', 'student');

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('nisn', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter === 'belum_tes') {
            $query->doesntHave('assessment');
        } elseif (!empty($this->statusFilter)) {
            $query->whereHas('assessment', function($q) {
                $q->where('status', $this->statusFilter);
            });
        }

        // FILTER KELAS
        if (!empty($this->kelasFilter)) {
            $query->where('kelas', $this->kelasFilter);
        }

        $students = $query->latest()->paginate(10);

        return view('livewire.admin-student-table', [
            'students' => $students,
            'kelasStats' => $kelasStats 
        ]);
    }
}