<div {{ $attributes->class('flex items-center rounded-full border border-white/20 p-0.5 text-xs font-semibold') }} role="group" aria-label="{{ __('Idioma') }}">
    @foreach (config('site.locales') as $locale => $label)
        <a
            href="{{ route('locale.switch', $locale) }}"
            data-no-swup
            hreflang="{{ str_replace('_', '-', $locale) }}"
            @if ($locale !== 'es') lang="zh-Hant" @endif
            @if (app()->getLocale() === $locale) aria-current="true" @endif
            @class([
                'rounded-full px-2.5 py-1 transition',
                'bg-white text-neutral-900!' => app()->getLocale() === $locale,
                'text-white/70! hover:text-white!' => app()->getLocale() !== $locale,
            ])
        >{{ $label }}</a>
    @endforeach
</div>
