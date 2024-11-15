<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Background Job Dashboard</title>
</head>
<body>
    <h1>Background Job Dashboard</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Class</th>
                <th>Method</th>
                <th>Parameters</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Retries</th>
                <th>Error Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($jobs as $job)
                <tr>
                    <td>{{ $job->id }}</td>
                    <td>{{ $job->class }}</td>
                    <td>{{ $job->method }}</td>
                    <td>{{ json_encode($job->parameters) }}</td>
                    <td>{{ $job->status }}</td>
                    <td>{{ $job->priority }}</td>
                    <td>{{ $job->retry_attempts }}</td>
                    <td>{{ $job->error_message }}</td>
                    <td>
                        @if($job->status === 'failed')
                            <form action="{{ route('admin.jobs.retry', $job) }}" method="POST">
                                @csrf
                                <button type="submit">Retry</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
