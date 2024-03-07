<form wire:submit.prevent="save">
    <x-scribble::modals.close-button/>

    <x-scribble::modals.header>
        {{ $update ? trans('scribble::modal.update') : trans('scribble::modal.insert') . ' ' . $header }}
    </x-scribble::modals.header>

    <x-scribble::modals.content>
        <div class="rounded-lg p-4 bg-gray-100 dark:bg-gray-950 mb-4">
            <div class="grid gap-4" style="grid-template-columns: repeat({{ $data['columns'] }}, minmax(0, 1fr))">
                @if ($data['asymmetric'])
                    <div
                        class="bg-gray-300 dark:bg-gray-800 rounded-lg border border-dashed border-white dark:border-gray-600 p-0.5 text-center"
                        style="grid-column: span {{ $data['left_span'] }};"
                    >
                        <p>{{ $data['left_span'] ?? '1' }}</p>
                    </div>
                    <div
                        class="bg-gray-300 dark:bg-gray-800 rounded-lg border border-dashed border-white dark:border-gray-600 p-0.5 text-center"
                        style="grid-column: span {{ $data['right_span'] }};"
                    >
                        <p>{{ $data['right_span'] ?? '1' }}</p>
                    </div>
                @else
                    @foreach(range(1, $data['columns']) as $column)
                        <div class="bg-gray-300 dark:bg-gray-800 rounded-lg border border-dashed border-white dark:border-gray-600 p-0.5 text-center">
                            <p>{{ $column }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{ $this->form }}
    </x-scribble::modals.content>

    <x-scribble::modals.footer>
        <x-filament::button type="submit">
            {{ $update ? trans('scribble::modal.update') : trans('scribble::modal.insert') }}
        </x-filament::button>
        <x-filament::button color="gray" wire:click="closeScribbleModal">
            {{ trans('scribble::modal.cancel') }}
        </x-filament::button>
    </x-scribble::modals.footer>
</form>
