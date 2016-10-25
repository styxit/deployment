<h1>Repositories</h1>

<table>
@foreach ($repositories as $repository)
    <tr>
        <td>{{ $repository['id'] }}</td>
        <td>{{ $repository['full_name'] }}</td>
        <td><img src="{{ $repository['owner']['avatar_url'] }}" width="20" /></td>
    </tr>
@endforeach
</table>
