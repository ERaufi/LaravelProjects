    <div class="container">
        <h1>{{ __('Notes') }}</h1>
        <a href="/notes/create" class="btn btn-primary">{{ __('Create Note') }}</a>
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Title') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notes as $note)
                    <tr>
                        <td>{{ $note->title }}</td>
                        <td>
                            <a href="/notes/{{ $note->id }}" class="btn btn-info">{{ __('View') }}</a>
                            <a href="/notes/{{ $note->id }}/edit" class="btn btn-warning">{{ __('Edit') }}</a>
                            <form action="/notes/{{ $note->id }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
