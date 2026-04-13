<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 Forbidden</title>
    <style>
        :root {
            --bg: #f3f6fb;
            --card: #ffffff;
            --primary: #2f80ed;
            --text: #1f2937;
            --muted: #64748b;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .card {
            width: min(92vw, 520px);
            background: var(--card);
            border-radius: 12px;
            text-align: center;
            padding: 42px 28px;
            box-shadow: 0 10px 35px rgba(16, 24, 40, 0.1);
        }

        .code {
            margin: 0;
            font-size: 70px;
            line-height: 1;
            color: #70a5f7;
            letter-spacing: 2px;
        }

        .title {
            margin: 12px 0 6px;
            font-size: 30px;
            font-weight: 700;
        }

        .desc {
            margin: 0 0 22px;
            color: var(--muted);
            font-size: 18px;
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            background: var(--primary);
            color: #fff;
            border-radius: 7px;
            padding: 10px 18px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="card">
        <p class="code">403</p>
        <p class="title">Access Denied</p>
        <p class="desc">You can't access this page.</p>
        <a href="{{ url()->previous() }}" class="btn">Back</a>
    </div>
</body>
</html>
