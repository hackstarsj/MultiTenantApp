<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Optional custom styles */
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4 mb-3">Leaderboard : {{$name}}</h1>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Rank</th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Profile Picture</th>
                    <th scope="col">Points</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leaderboard as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                        @if($user->profile_image)
                            <img src="{{ $user->profile_image }}" alt="{{ $user->name }}" width="50" height="50" class="rounded-circle">
                        @else
                            <img src="https://via.placeholder.com/50" alt="{{ $user->name }}" width="50" height="50" class="rounded-circle">
                        @endif
                    </td>
                    <td>{{ $user->total_xp }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Bootstrap JS (Optional) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
