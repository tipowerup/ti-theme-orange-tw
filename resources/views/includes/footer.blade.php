<footer class="bg-surface border-t border-border">
    <div class="container mx-auto px-4 py-8 md:py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            {{-- About Section --}}
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-text mb-4">
                    {{ setting('site_name') }}
                </h3>
                <p class="text-text-muted mb-4">
                    {{ setting('site_description') ?? 'Delicious food delivered to your doorstep' }}
                </p>

                {{-- Social Links --}}
                @php($social = $themeData['social'] ?? [])
                @if(array_filter($social))
                    <div class="flex space-x-4">
                        @if(!empty($social['facebook']))
                            <a href="{{ $social['facebook'] }}" target="_blank" rel="noopener" class="text-text-muted hover:text-primary transition-colors" aria-label="Facebook">
                                <x-tipowerup-orange-tw::icon name="facebook" class="w-5 h-5" />
                            </a>
                        @endif
                        @if(!empty($social['twitter']))
                            <a href="{{ $social['twitter'] }}" target="_blank" rel="noopener" class="text-text-muted hover:text-primary transition-colors" aria-label="Twitter">
                                <x-tipowerup-orange-tw::icon name="twitter" class="w-5 h-5" />
                            </a>
                        @endif
                        @if(!empty($social['instagram']))
                            <a href="{{ $social['instagram'] }}" target="_blank" rel="noopener" class="text-text-muted hover:text-primary transition-colors" aria-label="Instagram">
                                <x-tipowerup-orange-tw::icon name="instagram" class="w-5 h-5" />
                            </a>
                        @endif
                        @if(!empty($social['youtube']))
                            <a href="{{ $social['youtube'] }}" target="_blank" rel="noopener" class="text-text-muted hover:text-primary transition-colors" aria-label="YouTube">
                                <x-tipowerup-orange-tw::icon name="youtube" class="w-5 h-5" />
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Dynamic footer menu (theme pages + static pages from admin) --}}
            <div class="md:col-span-2">
                <x-tipowerup-orange-tw::nav code="footer-menu" />
            </div>
        </div>

        {{-- Copyright --}}
        <div class="border-t border-border mt-8 pt-8 text-center text-text-muted text-sm">
            {!! sprintf(
                lang('igniter::main.site_copyright'),
                date('Y'),
                $site_name ?? setting('site_name'),
                lang('system::lang.system_name')
            ) !!}
        </div>
    </div>
</footer>
