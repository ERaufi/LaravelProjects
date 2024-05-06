<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome to Test Company</title>
    </head>

    <body>
        <header>
            <img src="your-company-logo.png" alt="Test Company Logo" width="150" height="50">
            <h1>Test Company</h1>
        </header>

        <body>
            <p>Hi ,{{ $user->name }}</p>
            <p>Thank you for registering with Test Company! To unlock all the features of your account, please verify your email address by clicking the
                button below.</p>
            <a href="{{ $url }}"
                style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none;">Verify Your Email
                Address</a>
            <p>Once you verify your email, you'll be able to [list some benefits of verification, e.g., access exclusive content, participate in discussions].
            </p>
            <p>If you have any questions, please feel free to contact us at [support email address] or visit our FAQ page: [link to FAQ page].</p>
        </body>
        <footer>
            <p>&copy; Test Company {{ date('Y') }}</p>
            <p><a href="[unsubscribe link]">Unsubscribe</a> from our emails.</p>
        </footer>
    </body>

</html>
