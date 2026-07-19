<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\University; // Mengubah model yang di-import

class TuSchoolTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';

    // Variabel Form & Modal
    public $isModalOpen = false;
    public $isDeleteModalOpen = false;
    
    // Properti disesuaikan dengan kolom pada tabel universities
    public $selectedId, $name, $short_name, $location;
    public $isEditMode = false;

    public function updatingSearch() { $this->resetPage(); }

    // --- FUNGSI TAMBAH DATA ---
    public function create()
    {
        $this->resetFields();
        $this->isEditMode = false;
        $this->isModalOpen = true;
    }

    // --- FUNGSI EDIT DATA ---
    public function edit($id)
    {
        $this->resetFields();
        $this->isEditMode = true;
        
        $university = University::findOrFail($id);
        $this->selectedId = $university->id;
        $this->name = $university->name;
        $this->short_name = $university->short_name;
        $this->location = $university->location;

        $this->isModalOpen = true;
    }

    // --- FUNGSI SIMPAN (TAMBAH / EDIT) ---
    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        University::updateOrCreate(
            ['id' => $this->selectedId],
            [
                'name' => $this->name,
                'short_name' => $this->short_name,
                'location' => $this->location,
            ]
        );

        session()->flash('success', $this->isEditMode ? 'Data kampus berhasil diperbarui!' : 'Kampus baru berhasil ditambahkan!');
        $this->closeModal();
    }

    // --- FUNGSI HAPUS DATA ---
    public function openDeleteModal($id)
    {
        $this->selectedId = $id;
        $this->isDeleteModalOpen = true;
    }

    public function delete()
    {
        University::findOrFail($this->selectedId)->delete();
        session()->flash('success', 'Data kampus berhasil dihapus permanen!');
        $this->closeModal();
    }

    // --- RESET & CLOSE ---
    public function resetFields()
    {
        $this->reset(['selectedId', 'name', 'short_name', 'location']);
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->isDeleteModalOpen = false;
        $this->resetFields();
    }

    public function render()
    {
        $query = University::query();

        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('short_name', 'like', '%' . $this->search . '%')
                  ->orWhere('location', 'like', '%' . $this->search . '%');
        }

        return view('livewire.tu-school-table', [
            // Variabel yang dikirimkan ke blade sekarang bernama $universities
            'universities' => $query->orderBy('name')->paginate(10)
        ]);
    }
}