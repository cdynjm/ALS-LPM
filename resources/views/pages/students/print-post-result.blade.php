<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Post-Test Result</title>
</head>
<style>
    .page-break {
        page-break-after: always;
    }
    .encircle-letter {
        display: inline-block;
        width: 1.5em;
        height: 1.5em;
        line-height: 1.5em;
        border-radius: 50%;
        border: 2px solid black;
        text-align: center;
    }
    .score-box {
        display: inline-block;
        padding: 10px 20px;
        font-size: 20px;
        border: 1px solid black;
    }

</style>

<body style="font-family: arial; margin: 20px;">
    <div>
        <h4 style="text-align: center">FLT JUNIOR HIGH SCHOOL LEVEL (Post-Test)</h4>
        <h4 style="text-align: center">SAGUTANG PAPEL</h4>

        @foreach ($subjects as $sj)

                @php
                    $score = 0;
                @endphp
                @foreach ($exams as $ex)
                    @if($ex->subjectID == $sj->id)
                        @if($ex->Answers->correctAnswer == 1)
                            @php
                                $score += 1;
                            @endphp
                        @endif
                    @endif
                @endforeach

        <div class="page-break">
            <div>
                <h4 style="margin-bottom: 0px;">Name: 
                    @if(auth()->user()->role == 3)
                        {{ Auth::user()->Students->firstname }} {{ Auth::user()->Students->middlename }} {{ Auth::user()->Students->lastname }}</h4>
                    @endif
                    @if(auth()->user()->role == 2)
                        {{ $student->firstname }} {{ $student->middlename }} {{ $student->lastname }}</h4>
                    @endif
                </h4>
                <hr style="background-color: black; border: 0; height: 2px; margin-left: 50px;">
            </div>

            <div>
                <h4 style="text-align: center;">{{ $sj->subject }}</h4>
            </div>
            <div>
                <h4>
                    <span style="border-bottom: 2px solid black;">Directions:</span>
                     Encircle the letter of the correct answer. <span class="score-box" style="float: right;">{{ $score }}</span>
                </h4>
                @php
                    $num = 1;
                @endphp
                @foreach ($exams as $ex)
                    @if($ex->subjectID == $sj->id)
                        <p><span style="margin-right: 10px;">{{ $num }}. </span>

                            @php
                                $letter = 'A';
                            @endphp
                            @foreach ($choices as $ch)
                                @if($ch->questionID == $ex->questionID)
                                    <span @if($ch->id == $ex->answerID) class="encircle-letter" @endif style=" margin-right: 20px;">{{ $letter }}</span>
                                @php
                                    $letter ++;
                                @endphp
                                @endif
                            @endforeach
                            @if($ex->Answers->correctAnswer == 1)
                                <span style="color: rgb(60, 170, 60)">✔</span>
                            @else
                                <span style="color: red;">x</span>
                            @endif
                        </p>
                        @php
                            $num += 1;
                        @endphp
                    @endif
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>