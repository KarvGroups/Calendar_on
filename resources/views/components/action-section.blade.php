<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>

    <div class=" md:mt-0 md:col-span-2">

        <div class="px-4 sm:p-6 bg-white shadow sm:rounded-lg">
            <x-section-title>
                <x-slot name="title">{{ $title }}</x-slot>
            </x-section-title>
            {{ $content }}
        </div>
    </div>
</div>
