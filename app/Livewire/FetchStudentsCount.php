<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Students;
use Illuminate\Support\Facades\Auth;

class FetchStudentsCount extends Component
{
    public $countStudents;
    
    public function mount() {
        $this->fetchStudents();
    }
    public function fetchStudents() {
        if(Auth::user()->role == 1)
            $this->countStudents = Students::count();
        if(Auth::user()->role == 2)
            $this->countStudents = Students::where(['teacher' => Auth::user()->Teachers->id])->count();
    }
    public function render() {
        return view('livewire.fetch-students-count', ['countStudents', $this->countStudents]);
    }
}
