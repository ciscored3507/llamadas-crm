<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Click-to-Call</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="font-family: system-ui; padding: 24px;">
    <div style="max-width:720px; margin:0 auto;">
        <h1>Click-to-Call</h1>

        @if (session('status'))
        <div style="padding:10px; background:#e8ffe8; border:1px solid #b6f5b6; margin:12px 0;">
            {{ session('status') }}
        </div>
        @endif

        @if ($errors->any())
        <div style="padding:10px; background:#ffe8e8; border:1px solid #f5b6b6; margin:12px 0;">
            <ul style="margin:0;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('calls.store') }}">
            @csrf

            <div style="margin-bottom:10px;">
                <label>Número del agente (E.164)</label><br>
                <input name="agent_number" value="{{ old('agent_number') }}" placeholder="+52..." style="width:100%; padding:8px;">
            </div>

            <div style="margin-bottom:10px;">
                <label>Número del cliente (E.164)</label><br>
                <input name="customer_number" value="{{ old('customer_number') }}" placeholder="+52..." style="width:100%; padding:8px;">
            </div>

            <button type="submit" style="padding:10px 14px;">Iniciar llamada</button>
        </form>
    </div>
</body>

</html>