<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
</head>
<body>
<div class="register-container">
    <h3>Create Your Account</h3>
    <form method="POST" action="index.php?action=register">
    <label for="name">Name</label>
    <input type="text" id="name" name="name" placeholder="Enter your name" required autocomplete="off">
    
    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="Enter your email" required autocomplete="off">
    
    <label for="password">Create Password</label>
    <input type="password" id="password" name="password" placeholder="Enter your password" required autocomplete="off">

    <!-- Security Question Dropdown -->
    <label for="security_question">Select a Security Question</label>
    <select id="security_question" name="security_question" required autocomplete="off">
        <option value="">--Select a Question--</option>
        <option value="What is your pet's name?">What is your pet's name?</option>
        <option value="What is your favorite color?">What is your favorite color?</option>
        <option value="What is your hometown?">What is your hometown?</option>
    </select>

    <label for="security_answer">Your Answer</label>
    <input type="text" id="security_answer" name="security_answer" placeholder="Enter your answer" required autocomplete="off">

    <button type="submit">Register</button>
</form>

</div>
</body>
</html>
