<!DOCTYPE html>
<html>
<head>
    <title>Redirecting to Payment</title>
</head>
<body onload="document.forms[0].submit();">
    <p>Redirecting to payment gateway, please wait...</p>

    <form action="https://demo.ipsp.lv/form/v2/" method="POST">
        @foreach ($data as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
    </form>
</body>
</html>

