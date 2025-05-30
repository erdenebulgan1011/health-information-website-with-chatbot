<!DOCTYPE html>
<html>
<head>
    <title>User Export Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            word-wrap: break-word;
        }
        th {
            background-color: #f8f9fa;
            font-size: 9px;
        }
        .col-id { width: 3%; }
        .col-name { width: 12%; }
        .col-email { width: 20%; }
        .col-date { width: 8%; }
        .col-status { width: 5%; }
        .col-numbers { width: 4%; }
        .col-health { width: 6%; }
    </style>
</head>
<body>
    <div class="header">
    <h1>Хэрэглэгчийн Экспортын Тайлан</h1>
    <div class="date">Үүсгэсэн: {{ now()->format('Y-m-d H:i') }}</div>
</div>

<table>
    <thead>
        <tr>
            <th class="col-id">ID</th>
            <th class="col-name">Нэр</th>
            <th class="col-email">Имэйл</th>
            <th class="col-date">Бүртгэгдсэн</th>
            <th class="col-status">Баталгаажсан</th>
            <th class="col-numbers">Сэдвүүд</th>
            <th class="col-numbers">Хариултууд</th>
            <th class="col-date">Төрсөн огноо</th>
            <th class="col-status">Хүйс</th>
            <th class="col-numbers">Өндөр</th>
            <th class="col-numbers">Жин</th>
            <th class="col-health">Тамхичин</th>
            <th class="col-health">Өвчний байдал</th>
        </tr>
    </thead>
    <tbody>

            @foreach($data as $user)
                <tr>
                    <td>{{ $user['id'] }}</td>
                    <td>{{ Str::limit($user['name'], 20) }}</td>
                    <td>{{ Str::limit($user['email'], 25) }}</td>
                    <td>{{ $user['registered_at'] }}</td>
                    <td>{{ $user['verified'] }}</td>
                    <td>{{ $user['topics_count'] }}</td>
                    <td>{{ $user['replies_count'] }}</td>
                    <td>{{ $user['birth_date'] ?? 'N/A' }}</td>
                    <td>{{ $user['gender'] ?? 'N/A' }}</td>
                    <td>{{ $user['height'] ?? 'N/A' }}</td>
                    <td>{{ $user['weight'] ?? 'N/A' }}</td>
                    <td>{{ $user['is_smoker'] }}</td>
                    <td>{{ $user['has_chronic_conditions'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
