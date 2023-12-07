@if ($bloc->titre)
    <h2>{{ $bloc->titre }}</h2>
@endif
<div id="accordion" class="accordion aos-init aos-animate" data-aos="zoom-out">
    @foreach($bloc->questions as $key => $faq)
    <h2 id="heading{{ $key }}" class="accordion-header">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapse{{ $key }}">
            {{ $faq->question }}
        </button>
    </h2>
    <div id="collapse{{ $key }}" class="accordion-collapse collapse {{ empty($key) ? 'show' : '' }}" aria-labelledby="heading{{ $key }}" data-bs-parent="#accordion">
        <div class="accordion-body">
            <p>{!! $faq->reponse !!}</p>
        </div>
    </div>
    @endforeach
</div>
