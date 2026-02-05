@props(['data'])

@if ($data['is_visible'] ?? true)
    <div id="event" class="text-left">
        @livewire('landing-page.home-events', ['data' => $data])
    </div>
@endif
