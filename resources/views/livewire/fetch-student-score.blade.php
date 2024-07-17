<div>
    <div wire:poll.visible="fetchScore">
        {{ $countScore }} / {{ $countItems }} | <span class="badge 
        @if($percentage >= 75)
            bg-gradient-success
        @endif
        @if($percentage >= 50 && $percentage <= 74)
            bg-gradient-warning
        @endif
        @if($percentage <= 49)
            bg-gradient-danger
        @endif
        ">{{ number_format($percentage, 2) }} %</span>
    </div>
</div>
