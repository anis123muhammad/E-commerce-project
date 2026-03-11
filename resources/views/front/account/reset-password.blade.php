<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset The Password</title>


<style>
/* Body style */
body {
    font-family: 'Arial', sans-serif;
    background: #f2f2f2;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Form container */
form {
    background: #fff;
    padding: 30px 40px;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    width: 350px;
}

/* Input fields */
input.form-control {
    width: 100%;
    padding: 10px 12px;
    margin-top: 5px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    transition: border-color 0.3s;
}

/* Focus effect */
input.form-control:focus {
    border-color: #333;
    outline: none;
}

/* Labels */
label {
    font-weight: bold;
    font-size: 14px;
}

/* Button */
button.btn-dark {
    width: 100%;
    padding: 12px;
    background: #333;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s;
}

button.btn-dark:hover {
    background: #555;
}

/* Optional: responsive */
@media (max-width: 400px) {
    form {
        width: 90%;
        padding: 20px;
    }
}
</style>

</head>
<body>
<form method="POST" action="{{ route('password.update') }}">
@csrf

<input type="hidden" name="token" value="{{ $token }}">

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>New Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<div class="mb-3">
<label>Confirm Password</label>
<input type="password" name="password_confirmation" class="form-control" required>
</div>

<button type="submit" class="btn btn-dark">Reset Password</button>

</form>
</body>
</html>





