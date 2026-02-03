@props(['data'])

@if ($data['is_visible'] ?? true)
    <div id="event" class="text-left mt-12">
        @livewire('landing-page.home-events', ['data' => $data])
    </div>
@endif
