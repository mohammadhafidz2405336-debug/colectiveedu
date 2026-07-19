<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TuStudentTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $kelasFilter = '';

    // Variabel untuk mengontrol tampilan Modal
    public $isEditModalOpen = false;
    public $isResetModalOpen = false;
    public $isDeleteModalOpen = false;

    // Variabel untuk menampung data siswa yang sedang dipilih
    public $selectedStudentId;
    public $editName, $editNisn, $editGender, $editKelas;

    public function updatingSearch() { $this->resetPage(); }
    public function updatingKelasFilter() { $this->resetPage(); }

    // --- FUNGSI EDIT SISWA ---
    public function openEditModal($id)
    {
        $student = User::findOrFail($id);
        $this->selectedStudentId = $student->id;
        $this->editName = $student->name;
        $this->editNisn = $student->nisn;
        $this->editGender = $student->gender;
        $this->editKelas = $student->kelas;
        
        $this->isEditModalOpen = true;
    }

    public function updateStudent()
    {
        $this->validate([
            'editName' => 'required|string|max:255',
            'editNisn' => 'required|string|max:20|unique:users,nisn,'.$this->selectedStudentId,
            'editGender' => 'nullable|in:Laki-laki,Perempuan',
            'editKelas' => 'nullable|string|max:5',
        ]);

        User::where('id', $this->selectedStudentId)->update([
            'name' => $this->editName,
            'nisn' => $this->editNisn,
            'gender' => $this->editGender,
            'kelas' => $this->editKelas,
        ]);

        session()->flash('success', 'Data siswa berhasil diperbarui!');
        $this->closeModals();
    }

    // --- FUNGSI RESET PASSWORD ---
    public function openResetModal($id)
    {
        $this->selectedStudentId = $id;
        $this->isResetModalOpen = true;
    }

    public function resetPassword()
    {
        User::where('id', $this->selectedStudentId)->update([
            'password' => Hash::make('password123') // Default password reset
        ]);

        session()->flash('success', 'Password berhasil direset menjadi: password123');
        $this->closeModals();
    }

    // --- FUNGSI HAPUS SISWA ---
    public function openDeleteModal($id)
    {
        $this->selectedStudentId = $id;
        $this->isDeleteModalOpen = true;
    }

    public function deleteStudent()
    {
        // Fitur hapus ini juga akan otomatis menghapus data assessment karena foreign key (jika diset cascade)
        User::findOrFail($this->selectedStudentId)->delete();
        
        session()->flash('success', 'Data siswa berhasil dihapus secara permanen!');
        $this->closeModals();
    }

    // --- FUNGSI MENUTUP SEMUA MODAL ---
    public function closeModals()
    {
        $this->isEditModalOpen = false;
        $this->isResetModalOpen = false;
        $this->isDeleteModalOpen = false;
        $this->reset(['selectedStudentId', 'editName', 'editNisn', 'editGender', 'editKelas']);
    }

    public function render()
    {
        $query = User::where('role', 'student');

        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('nisn', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->kelasFilter)) {
            $query->where('kelas', $this->kelasFilter);
        }

        $students = $query->latest()->paginate(15);
        $daftarKelas = User::where('role', 'student')->whereNotNull('kelas')->distinct()->pluck('kelas')->sort();

        return view('livewire.tu-student-table', [
            'students' => $students,
            'daftarKelas' => $daftarKelas
        ]);
    }
}