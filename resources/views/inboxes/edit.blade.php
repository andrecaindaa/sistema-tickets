<form method="POST" action="{{ route('inboxes.update', $inbox) }}">
    @csrf
    @method('PUT')
