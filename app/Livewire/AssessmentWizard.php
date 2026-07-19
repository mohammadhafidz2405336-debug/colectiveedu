<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Assessment;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class AssessmentWizard extends Component
{
    public $step = 1;
    public $has_no_achievements = false;

    // --- STATE TES DINAMIS (Minat Bakat & Kepribadian) ---
    public string $current_type = 'interest'; 
    public bool $is_testing = false;
    public bool $is_completed = false;
    public $current_questions = [];
    public $current_question_index = 0;
    public $user_answers = []; 

    // --- TRACKING PENYELESAIAN SUB-TES ---
    public bool $interest_completed = false;
    public bool $personality_completed = false;

    // --- HASIL TES ---
    public $saved_dominant_talent = null;
    public $saved_personality = null; 

    // --- ASPEK 3: PRESTASI ---
    public $achievements = [
        'primary' => ['name' => '', 'level' => '', 'type' => ''],
        'secondary' => ['name' => '', 'level' => '', 'type' => '']
    ];

    // --- ASPEK 4: PILIHAN AKHIR ---
    public $student_preference = '';
    public $student_preference_secondary = '';
    public $parent_preference = '';
    public $preference_notes = '';

    public function mount()
    {
        $draft = Assessment::where('user_id', Auth::id())->first();
        
        if ($draft) {
            $this->achievements = $draft->achievements ?? $this->achievements;
            $this->student_preference = $draft->student_preference;
            $this->student_preference_secondary = $draft->academic_scores['student_preference_secondary'] ?? ''; // Tambahkan baris ini
            $this->parent_preference = $draft->parent_preference;
            $this->preference_notes = $draft->preference_notes;
            
            $this->saved_dominant_talent = $draft->dominant_talent;
            $this->saved_personality = $draft->academic_scores['saved_personality'] ?? null;

            // Cek status penyelesaian sub-tes berdasarkan ketersediaan skor/hasil cetak
            if ($this->saved_dominant_talent) {
                $this->interest_completed = true;
            }
            if ($this->saved_personality) {
                $this->personality_completed = true;
            }

            // Atur state awal halaman/step 1
            if ($this->interest_completed) {
                $this->is_completed = true;
            }

            if (($this->achievements['primary']['name'] ?? '') === 'Belum Ada') {
                $this->has_no_achievements = true;
            }
        }
    }

    public function startTest($type = 'interest')
    {
        $this->current_type = $type;
        $this->current_question_index = 0;
        
        $draft = Assessment::where('user_id', Auth::id())->first();

        // Ambil data soal dinamis berdasarkan tipe kategori
        $this->current_questions = Question::where('category', $type)
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();

        if (empty($this->current_questions)) {
            $this->is_testing = false;
            session()->flash('error', "Gagal memuat soal. Pastikan data soal dengan kategori '{$type}' sudah di-input ke database.");
            return;
        }

        // Ambil restore data jawaban sementara dari session database JSON
        if ($draft && isset($draft->academic_scores['temp_answers'][$type])) {
            $this->user_answers = $draft->academic_scores['temp_answers'][$type];
            $this->current_question_index = count($this->user_answers);
            
            if ($this->current_question_index >= count($this->current_questions)) {
                $this->current_question_index = 0;
                $this->user_answers = [];
            }
        } else {
            $this->user_answers = [];
        }

        $this->is_testing = true;
        $this->is_completed = false;
    }

    public function nextQuestion($selectedAnswer)
    {
        $type = $this->current_type;
        $this->user_answers[$this->current_question_index] = $selectedAnswer;

        // BACKUP LIVE DATA KE DB (Anti-Lag & Anti-Refresh)
        $draft = Assessment::where('user_id', Auth::id())->first();
        $academicScores = $draft ? ($draft->academic_scores ?? []) : [];
        $academicScores['temp_answers'][$type] = $this->user_answers;

        Assessment::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'academic_scores' => $academicScores,
                'status' => 'draft'
            ]
        );

        if ($this->current_question_index < count($this->current_questions) - 1) {
            $this->current_question_index++;
        } else {
            // Sesi Tes Selesai
            $this->is_testing = false;
            $this->is_completed = true;
            
            $sectionName = ($type == 'interest') ? 'minat' : 'kepribadian';
            
            // Wipe data backup temporer sub-tes ini karena sudah rampung
            $academicScores['temp_answers'][$type] = [];
            Assessment::where('user_id', Auth::id())->update(['academic_scores' => $academicScores]);

            $this->finishSubSection($sectionName);
        }
    }
    
    public function finishSubSection($section)
    {
        if ($section == 'minat') {
            $this->saved_dominant_talent = $this->calculateDominantTalent();
            $this->interest_completed = true;
        } elseif ($section == 'kepribadian') {
            $this->saved_personality = $this->calculatePersonalityResult();
            $this->personality_completed = true;
        }

        $this->saveAsDraft();
    }

    public function validateStep()
    {
        if ($this->step == 1) {
            if (!$this->interest_completed || !$this->saved_dominant_talent) {
                $this->addError('step1_incomplete', 'Anda harus menyelesaikan Tes Minat & Bakat terlebih dahulu.');
                return false;
            }
        } 
        elseif ($this->step == 2) {
            if (!$this->personality_completed || !$this->saved_personality) {
                $this->addError('step2_incomplete', 'Anda harus menyelesaikan Pemetaan Tipe Kepribadian terlebih dahulu.');
                return false;
            }
        }
        elseif ($this->step == 3) {
            if (!$this->has_no_achievements) {
                $this->validate([
                    'achievements.primary.name' => 'required|min:3',
                    'achievements.primary.level' => 'required',
                    'achievements.primary.type' => 'required',
                ]);
            } else {
                $this->achievements['primary'] = [
                    'name' => 'Belum Ada', 
                    'level' => 'Tidak Ada', 
                    'type' => 'Tidak Ada'
                ];
            }
        }
        return true;
    }

    public function calculateDominantTalent()
    {
        $scores = [
            'Realistic' => 0, 'Investigative' => 0, 'Artistic' => 0, 
            'Social' => 0, 'Enterprising' => 0, 'Conventional' => 0
        ];

        $hasAnswer = false;
        foreach ($this->current_questions as $index => $q) {
            if (($q['category'] == 'interest') && isset($this->user_answers[$index])) {
                $hasAnswer = true;
                $ans = $this->user_answers[$index];
                
                $points = match($ans) {
                    'Sangat Suka' => 4,
                    'Suka' => 3,
                    'Kurang Suka' => 2,
                    'Sangat Tidak Suka' => 1,
                    default => 0
                };
                
                $type = $q['interest_type'] ?? 'Social';
                if (isset($scores[$type])) {
                    $scores[$type] += $points;
                }
            }
        }

        if (!$hasAnswer) return $this->saved_dominant_talent ?: 'Social';

        arsort($scores);
        return array_key_first($scores);
    }

    public function calculatePersonalityResult()
    {
        // Menghitung jawaban yang paling sering dipilih (Modus) untuk penentuan tipe karakter
        $answerCounts = [];
        foreach ($this->user_answers as $ans) {
            if (!empty($ans)) {
                $answerCounts[$ans] = ($answerCounts[$ans] ?? 0) + 1;
            }
        }

        if (empty($answerCounts)) {
            return $this->saved_personality ?: 'Analitis & Logis';
        }

        arsort($answerCounts);
        $dominantAnswer = array_key_first($answerCounts);

        // Map teks jawaban ke tipe klaster kepribadian ringkas
        if (str_contains($dominantAnswer, 'Analisis') || str_contains($dominantAnswer, 'Membaca') || str_contains($dominantAnswer, 'tenang')) {
            return 'Pemikir Analitis';
        } elseif (str_contains($dominantAnswer, 'Membicarakan') || str_contains($dominantAnswer, 'Berkumpul') || str_contains($dominantAnswer, 'Pemimpin')) {
            return 'Komunikator Sosial';
        } elseif (str_contains($dominantAnswer, 'Mencoba') || str_contains($dominantAnswer, 'Mempraktikkan') || str_contains($dominantAnswer, 'Pelaksana')) {
            return 'Praktis Eksekutor';
        } else {
            return 'Kreatif Intuitif';
        }
    }

    public function saveAsDraft()
    {
        $draft = Assessment::where('user_id', Auth::id())->first();
        $academicScores = $draft ? ($draft->academic_scores ?? []) : [];
        
        // Selipkan status kepribadian ke JSON agar tidak merusak relasi kolom tabel kaku
        $academicScores['saved_personality'] = $this->saved_personality;

        Assessment::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'dominant_talent' => $this->saved_dominant_talent,
                'achievements' => $this->achievements,
                'academic_scores' => $academicScores,
                'status' => 'draft',
            ]
        );
    }

    public function previousQuestion()
    {
        // Cek agar index tidak minus
        if ($this->current_question_index > 0) {
            
            // 1. Mundurkan index pertanyaan
            $this->current_question_index--;
            
            // 2. Hapus data jawaban terakhir yang tersimpan di array
            // (Pastikan kamu menyesuaikan nama variabel $answers sesuai dengan 
            // variabel yang kamu pakai untuk menampung jawaban sementara)
            if (!empty($this->answers)) {
                array_pop($this->answers);
            }
        }
    }

    public function submit()
    {
        $this->validate([
            'student_preference' => 'required',
            'parent_preference' => 'required',
        ]);

        $draft = Assessment::where('user_id', Auth::id())->first();
        $academicScores = $draft ? ($draft->academic_scores ?? []) : [];
        $academicScores['saved_personality'] = $this->saved_personality;
        $academicScores['student_preference_secondary'] = $this->student_preference_secondary; // Tambahkan baris ini

        Assessment::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'dominant_talent' => $this->saved_dominant_talent,
                'achievements' => $this->achievements,
                'academic_scores' => $academicScores,
                'student_preference' => $this->student_preference,
                'parent_preference' => $this->parent_preference,
                'preference_notes' => $this->preference_notes,
                'status' => 'completed',
            ]
        );

        return redirect()->route('recommendation.generate');
    }

    public function nextStep()
    {
        if ($this->validateStep()) {
            $this->saveAsDraft();
            $this->step++;
            
            // Sinkronisasi tombol UI (is_completed) setiap perpindahan langkah halaman kuis baru
            if ($this->step == 1) {
                $this->is_completed = $this->interest_completed;
            } elseif ($this->step == 2) {
                $this->is_completed = $this->personality_completed;
            } else {
                $this->is_completed = false;
            }
            
            $this->is_testing = false;
        }
    }

    public function previousStep() 
    { 
        if ($this->step > 1) {
            $this->step--;
            
            // Sinkronisasi tombol UI saat kembali mundur halaman kuis
            if ($this->step == 1) {
                $this->is_completed = $this->interest_completed;
            } elseif ($this->step == 2) {
                $this->is_completed = $this->personality_completed;
            } else {
                $this->is_completed = false;
            }
            
            $this->is_testing = false;
        }
    }

    public function render() 
    { 
        return view('livewire.assessment-wizard'); 
    }
}