@props(['tip'])

<a class="card" href="{{route('tipsPage', $tip->id)}}">
    <img src="{{ asset('storage/' . $tip->image_path) }}" alt="Uploaded Photo">
    <div class="card-body">
        <h5>{{ $tip->title }}</h5>
        <p>{{ $tip->description}}</p>
    </div>
</a>
