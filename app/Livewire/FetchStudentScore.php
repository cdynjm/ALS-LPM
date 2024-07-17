<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use App\Models\Activities;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FetchStudentScore extends Component
{
    public $countScore;
    public $countItems;
    public $percentage;

    public function mount() {
        $this->fetchScore();
    }
    public function fetchScore() {
        if(Auth::user()->role == 2) {
            $this->countScore = Activities::where('studentID', Session::get('studentID'))->sum('score');
            $this->countItems = Activities::where('studentID', Session::get('studentID'))->sum('items');
            if($this->countScore != 0)
                $this->percentage = ($this->countScore / $this->countItems) * 100;
            else
                $this->percentage = 0;
        }
        if(Auth::user()->role == 3) { 
            $this->countScore = Activities::where('studentID', Auth::user()->Students->id)->sum('score');
            $this->countItems = Activities::where('studentID', Auth::user()->Students->id)->sum('items');
            if($this->countScore != 0)
                $this->percentage = ($this->countScore / $this->countItems) * 100;
            else
                $this->percentage = 0;
        }   
    }   
    public function render()
    {
        return view('livewire.fetch-student-score', [
            'countScore' => $this->countScore, 
            'countItems' => $this->countItems,
            'percentage' =>  $this->percentage
        ]);
    }
}
