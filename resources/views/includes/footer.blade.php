<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                {{ setting('site_name') }}
            </h3>
            <p class="text-gray-600">
                Minimal TastyIgniter theme template
            </p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Links</h3>
            {{-- Add footer navigation here --}}
        </div>

        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact</h3>
            {{-- Add contact information here --}}
        </div>
    </div>

    <div class="border-t border-gray-200 mt-8 pt-8 text-center text-gray-600">
        {!! sprintf(
            lang('igniter::main.site_copyright'),
            date('Y'),
            $site_name,
            lang('system::lang.system_name')
        ) !!}
    </div>
</div>
