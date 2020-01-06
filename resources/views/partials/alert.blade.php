@if ($errors->any())
    <div class="alert mt-30 mt-15-xs alert-warning" role="alert">
        <p>{{ $errors->count() > 1 ? __("Il y a :count erreurs sur ce formulaire que vous devez corriger", ['count' => $errors->count()]) : __("Il y a une erreur sur ce formulaire que vous devez corriger") }} :</p>
        <ul class="li">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@foreach (Alert::getMessages() as $type => $messages)
    @foreach ($messages as $message)
        <div class="alert mt-30 mt-15-xs alert-{{ $type }}" role="alert">
            {!! $message !!}
        </div>
    @endforeach
@endforeach