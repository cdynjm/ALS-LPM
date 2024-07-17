<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LearningMaterials;

class FetchLearningMaterialsCount extends Component
{
    public $countLearningMaterials;

    public function mount() {
        $this->fetchLearningMaterials();
    }
    public function fetchLearningMaterials() {
        $this->countLearningMaterials = LearningMaterials::count();
    }
    public function render(){
        return view('livewire.fetch-learning-materials-count', ['countLearningMaterials', $this->countLearningMaterials]);
    }
}
