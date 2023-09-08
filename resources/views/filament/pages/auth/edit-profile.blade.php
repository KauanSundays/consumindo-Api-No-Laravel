<div>

    <header class="fi-simple-header py-8">
        <h1 class="fi-header-heading text-2x1 font-bold tracking-tight text-gray-950 dark:text-white sm:text3x1">
            My Profile
        </h1>

        <p class="">
            Manage your user profile here
        </p>
    </header>

    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>

</div>