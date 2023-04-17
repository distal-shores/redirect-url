<style>
    thead tr th { 
        text-align: left;
    }
    th, td {
        padding-right: 0.5rem;
    }
    table {
        margin-bottom: 2rem;
    }
</style>

<h1>Redirects</h1>

<table>
    <thead>
        <tr>
            <th>Source URL</th>
            <th>Target URL</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($redirects as $redirect)
            <tr>
                <td>{{ $redirect->source_url }}</td>
                <td><a href="/redirect/{{ $redirect->target_url }}">{{ $redirect->target_url }}</a></td>
            </tr>
        @endforeach
    </tbody>
</table>

<form method="POST" action="/new">
    @csrf
    <label for="url">Enter a URL to redirect:</label>
    <input type="text" name="url" id="url">
    <button type="submit">Create Redirect</button>
</form>