<div class="ep">
    @foreach ($episode as $ep)
    ep{{$ep['number']}}. {{$ep['title']}}<br>

    @endforeach
</div>