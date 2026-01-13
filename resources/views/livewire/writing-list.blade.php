<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

        @foreach ($this->posts as $post)
            <x-writing-card :image="$post->image_url" :avatar="$post->author_avatar_url" :author="$post->author_display_name" :date="$post->published_at->format('M d, Y')" :read-time="$post->reading_time . ' min read'"
                :title="$post->title" :excerpt="$post->excerpt" :link="route('home', $post->slug ?? '#')" />
        @endforeach

    </div>

    <div class="mt-8 flex justify-center">
        {{ $this->posts->links() }}
    </div>
</div>
