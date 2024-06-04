<!-- resources/views/show_password.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Password Generator</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        label {
            margin-right: 10px;
        }
        input[type=number] {
            width: 50px;
        }
        #password {
            font-weight: bold;
        }
        .error {
            color: red;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<h1>Interactive Asynchronous Password Generator</h1>

<div>
    <label for="length">Password Length:</label>
    <input type="number" id="length" value="10" min="6" max="62">
</div>
<div>
    <label><input type="checkbox" id="useDigits" checked> Include Digits</label>
</div>
<div>
    <label><input type="checkbox" id="useUppercase" checked> Include Uppercase Letters</label>
</div>
<div>
    <label><input type="checkbox" id="useLowercase" checked> Include Lowercase Letters</label>
</div>
<button id="generate">Generate Password</button>
<p>Password: <span id="password"></span></p>
<div id="errorMessages" class="error"></div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#generate').click(function() {
            // Clear previous errors
            $('#errorMessages').empty();

            // Gather input data
            var length = parseInt($('#length').val());
            var useDigits = $('#useDigits').is(':checked');
            var useUppercase = $('#useUppercase').is(':checked');
            var useLowercase = $('#useLowercase').is(':checked');

            // Ensure at least one checkbox is selected
            if (!useDigits && !useUppercase && !useLowercase) {
                $('#errorMessages').append('<div>At least one of Digits, Uppercase Letters, or Lowercase Letters must be selected.</div>');
                return;
            }

            // Prepare data payload
            var data = {
                length: length,
                useDigits: useDigits,
                useUppercase: useUppercase,
                useLowercase: useLowercase,
                _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token if needed
            };

            // Use jQuery AJAX to make the GET request
            $.ajax({
                url: '{{ route("generate-password") }}',
                type: 'GET',
                data: data,
                success: function(response) {
                    // Update the UI with the generated password
                    $('#password').text(response.password);
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorContainer = $('#errorMessages');
                    $.each(errors, function(key, messages) {
                        $.each(messages, function(index, message) {
                            var errorDiv = $('<div>').text(message);
                            errorContainer.append(errorDiv);
                        });
                    });
                }
            });
        });
    });
</script>
</body>
</html>
