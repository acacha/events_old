<h1>Event:</h1>

@foreach ($events as $event)
    <ul>
        <li>Name: {{ $event->name }}</li>
        <li>Description: {{ $event->description }}</li>
    </ul>
@endforeach
