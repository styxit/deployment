<h1>Deployments for my repositories</h1>

<table>
@foreach ($deployments as $deployment)
    <tr>
        <td>{{ $deployment['id'] }}</td>
        <td>{{ $deployment['created_at'] }}</td>
        <td>{{ $deployment['ref'] }}</td>
        <td>{{ $deployment['task'] }}</td>
        <td>{{ $deployment['environment'] }}</td>
        <td>{{ $deployment['description'] }}</td>
        <td><img src="{{ $deployment['creator']['avatar_url'] }}" width="20" /></td>
    </tr>
@endforeach
</table>
