@props(['items', 'title', 'numbered' => false])

@php
    $accordionId = 'accordion-'.\Illuminate\Support\Str::random(6);
@endphp

<section {{ $attributes->class('accordion') }} aria-labelledby="{{ $accordionId }}-title">
    <h2 id="{{ $accordionId }}-title" class="sr-only">{{ $title }}</h2>

    @foreach ($items as [$question, $answer])
        <article class="item">
            <input class="toggle" type="checkbox" id="{{ $accordionId }}-{{ $loop->iteration }}" />
            <label class="question" for="{{ $accordionId }}-{{ $loop->iteration }}">
                <span>
                    @if ($numbered)
                        <span class="text-brand-orange">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}.</span>
                    @endif
                    {{ $question }}
                </span>
                <span class="icon" aria-hidden="true">
                    <span class="icon-mark"></span>
                </span>
            </label>
            <div class="answer">
                <div class="answer-inner">
                    <p>{{ $answer }}</p>
                </div>
            </div>
        </article>
    @endforeach
</section>
