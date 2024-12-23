<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors performance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 5px;
            padding: 10px;
            border: 1px solid #ddd;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 2px;
            text-align: center;
        }

        table th {
            background-color: #f4f4f4;
            height: 25px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Authors performance</h1>
    <table>
        <thead>
        <tr>
            @foreach(array_keys((array)$data[0]) as $header)
                <th>{{ ucfirst($header) }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($data as $row)
            <tr>
                @foreach($row as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
