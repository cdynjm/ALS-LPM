<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Teachers;

class FetchTeachersCount extends Component
{
    public $countTeachers;

    public function mount() {
        $this->fetchTeachers();
    }
    public function fetchTeachers() {
        $this->countTeachers = Teachers::count();
    }
    public function render(){
        return view('livewire.fetch-teachers-count', ['countTeachers', $this->countTeachers]);
    }
}
