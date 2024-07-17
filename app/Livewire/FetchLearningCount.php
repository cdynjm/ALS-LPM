<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subjects;

class FetchLearningCount extends Component
{
    public $countLearningStrands;
    
    public function mount() {
        $this->fetchLearningStrands();
    }
    public function fetchLearningStrands() {
        $this->countLearningStrands = Subjects::count();
    }
    public function render() {
        return view('livewire.fetch-learning-count', ['countLearningStrands', $this->countLearningStrands]);
    }
}
