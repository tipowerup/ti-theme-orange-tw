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
                @if($theme->social ?? false)
                    <div class="flex space-x-4">
                        @if($theme->social['facebook'] ?? false)
                            <a href="{{ $theme->social['facebook'] }}" target="_blank" rel="noopener" class="text-text-muted hover:text-primary transition-colors" aria-label="Facebook">
                                <x-tipowerup-orange-tw::icon name="facebook" class="w-5 h-5" />
                            </a>
                        @endif
                        @if($theme->social['twitter'] ?? false)
                            <a href="{{ $theme->social['twitter'] }}" target="_blank" rel="noopener" class="text-text-muted hover:text-primary transition-colors" aria-label="Twitter">
                                <x-tipowerup-orange-tw::icon name="twitter" class="w-5 h-5" />
                            </a>
                        @endif
                        @if($theme->social['instagram'] ?? false)
                            <a href="{{ $theme->social['instagram'] }}" target="_blank" rel="noopener" class="text-text-muted hover:text-primary transition-colors" aria-label="Instagram">
                                <x-tipowerup-orange-tw::icon name="instagram" class="w-5 h-5" />
                            </a>
                        @endif
                        @if($theme->social['youtube'] ?? false)
                            <a href="{{ $theme->social['youtube'] }}" target="_blank" rel="noopener" class="text-text-muted hover:text-primary transition-colors" aria-label="YouTube">
                                <x-tipowerup-orange-tw::icon name="youtube" class="w-5 h-5" />
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Quick Links --}}
            <div>
                <h3 class="text-lg font-semibold text-text mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ page_url('home') }}" class="text-text-muted hover:text-primary transition-colors" wire:navigate>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ page_url('locations') }}" class="text-text-muted hover:text-primary transition-colors" wire:navigate>
                            Locations
                        </a>
                    </li>
                    <li>
                        <a href="{{ page_url('menus') }}" class="text-text-muted hover:text-primary transition-colors" wire:navigate>
                            Menu
                        </a>
                    </li>
                    <li>
                        <a href="{{ page_url('account/login') }}" class="text-text-muted hover:text-primary transition-colors" wire:navigate>
                            Account
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Legal Links --}}
            <div>
                <h3 class="text-lg font-semibold text-text mb-4">Legal</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ page_url('privacy') }}" class="text-text-muted hover:text-primary transition-colors" wire:navigate>
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="{{ page_url('terms') }}" class="text-text-muted hover:text-primary transition-colors" wire:navigate>
                            Terms of Service
                        </a>
                    </li>
                    <li>
                        <a href="{{ page_url('contact') }}" class="text-text-muted hover:text-primary transition-colors" wire:navigate>
                            Contact Us
                        </a>
                    </li>
                </ul>
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
