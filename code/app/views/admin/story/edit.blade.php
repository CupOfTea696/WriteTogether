{{-- use the $page var (admin_story-edit or admin_story-check) to switch between edit and check. the titles need to be different. --}}
{{-- the button at the bottom needs to say save or publish, and the post needs to be to admin.story.update or admin.story.publish --}}
{{-- Also on the publish page is no need for being able to alter the facts. They are irrelevant at this point --}}

<form action="{{ URL::route('admin.story.update', to_dash_case($story->title)) }}" method="post">
    <input type="text" name="title" placeholder="title" value="{{ $story->title }}">
    
    @define $i = 0
    @foreach(json_decode($story->facts) as $fact)
        @define $i++
        <input type="text" name="facts[]" placeholder="fact {{ $i }}" value="{{ $fact }}">
        {{-- add extra fields dynamically with js to add facts. they all should have name="facts[]" set --}}
        {{-- Also prolly change the placeholder everytime u add a field :p --}}
    @endforeach
    
    <textarea name="intro">{{ $story->intro }}</textarea>
    
    @foreach($story->paragraphs as $paragraph)
    <div class="idk-man-im-not-doing-this">
        <textarea name="paragraphs[]">{{ $paragraph->paragraph }}</textarea>
        <input type="hidden" name="paragraphIDs[]" value="{{ $paragraph->paragraphID }}">
        {{-- Normally wouldn't do this but this is the admin panel and normally you trust your admins --}}
        {{-- not to do stupid shit like trying to edit hidden fields. Opinions? --}}
        <input type="hidden" name="hasChanges[]" value="0"> {{-- set to 1 when they typed in the textarea --}}
    </div>
    @endforeach
    
    <input type="submit">
</form>
