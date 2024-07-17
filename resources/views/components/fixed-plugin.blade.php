@php
    use App\Models\Subjects;
    use App\Models\Competencies;
    $comptenciesPlugin = Competencies::get();
    $learningStrandsPlugin = Subjects::get();
@endphp

@if(Auth::user()->role == 3)
    @if(Auth::user()->Students->status == 1)
        <div class="fixed-plugin">
            <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
                <span class="text-sm">Time Elapsed: </span>
                <span class="fw-bolder" id="autoTimer">00:00:00</span>
            </a>
        </div>

        <script data-navigate-once>
            let timerDisplay = document.getElementById('autoTimer');
            let seconds = 0, minutes = 0, hours = 0;
            let timer;

            function addTime() {
            seconds++;
            if (seconds >= 60) {
                seconds = 0;
                minutes++;
                if (minutes >= 60) {
                    minutes = 0;
                    hours++;
                }
            }
            
            timerDisplay.textContent = 
                (hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" +
                (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" +
                (seconds > 9 ? seconds : "0" + seconds);
            }

            function startAutoTimer() {
                timer = setInterval(addTime, 1000);
            }

            window.onload = startAutoTimer; // Automatically start the timer when the page loads
        </script>
    @else
        @include('components.plugin-body')
    @endif
@else
        @include('components.plugin-body')
@endif