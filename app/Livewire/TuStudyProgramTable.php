<?php

namespace App\Livewire;

use App\Models\StudyProgram;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudyProgramsImport;

class TuStudyProgramTable extends Component
{
    use WithPagination, WithFileUploads;

    public $universityId;
    public $search = '';
    public $file; 

    public function mount($universityId)
    {
        $this->universityId = $universityId;
    }

    public function updatingSearch() { $this->resetPage(); }

    // Fungsi Upload Excel
    public function importExcel()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120', 
        ]);

        try {
            Excel::import(new StudyProgramsImport($this->universityId), $this->file->getRealPath());
            
            session()->flash('success', 'Data jurusan berhasil diimpor!');
            $this->reset('file');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat impor: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        StudyProgram::findOrFail($id)->delete();
        session()->flash('success', 'Jurusan dihapus.');
    }

    public function render()
    {
        $query = StudyProgram::where('university_id', $this->universityId);

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('cluster', 'like', '%' . $this->search . '%');
        }

        return view('livewire.tu-study-program-table', [
            'programs' => $query->orderBy('cluster')->orderBy('name')->paginate(15)
        ]);
    }

    public function exportExcel()
    {
        // Mengunduh file excel menggunakan class Export yang akan kita buat
        return Excel::download(new \App\Exports\StudyProgramsExport($this->universityId), 'Data_Jurusan.xlsx');
    }
}