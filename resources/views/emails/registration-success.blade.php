<!DOCTYPE html>
<html>
<head>
    <title>SAR</title>
    <style>
        p {
            font-size: 13px;
            font-weight: 400px;
        }
    </style>
</head>
<body>
    <h3> Congratualtions !!! </h3>
    <p>You have successfully registered into {{config('app.name')}}</p>
    <p>Your Credentials are: </p>
    <p><b>Username:</b> {{ $extraSettings['username'] }}</p>
    <p><b>Password:</b> {{ $extraSettings['password'] }}</p>

    <p>Thank you</p>
</body>
</html>
