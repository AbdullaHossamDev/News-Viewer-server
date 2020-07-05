<!-- Hello <strong>{{ $detailes['title'] }}</strong>,
<p>{{ $detailes['body'] }}</p> -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $detailes['title'] }}</title>
</head>

<body>
  <h3><small>Hello </small> {{ $detailes['name'] }}</h3>
  <p>We are so happy for your interest to register with our app,</p>
  <p>please use this credentials for login:</p>
  <p>Email: {{ $detailes['email'] }}</p>
  <p>password: {{ $detailes['password'] }}</p>

  <p><strong>Thank you</strong></p>
</body>

</html>