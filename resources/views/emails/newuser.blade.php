
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://scrypteur.com/css/tailwindcss.css" rel="stylesheet">
    <link href="http://scrypteur.com/css/app.css" rel="stylesheet"> 
</head>
<body>
    <div>
        <h1>Welcome to Scrypteur</h1>
        <p>
            You have successfully created an account on Scrypteur.
        </p>
        <p>
            Please click the link below to verify your email address.
        </p>
        <a href="{{ route('confirm-account', $token) }}">Verify Email</a>
    </div>
</body>
</html>