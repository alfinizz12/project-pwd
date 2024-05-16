
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Booking Form</title>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body>
<?php $number = 0; ?>

<label for="number">Angka:</label>
<form id="myForm">
    <button type="button" onclick="subtract()">-</button>
    <input type="number" id="number" name="number" value="0" min="0" max="5">
    <button type="button" onclick="add()">+</button>
</form>

<!-- <h6 id="result"></h6> -->

<script>
    function add() {
        var input = document.getElementById("number");
        var currentValue = parseInt(input.value);

        if (currentValue < 5) {
            input.value = currentValue + 1;
        }
    }

    function subtract() {
        var input = document.getElementById("number");
        var currentValue = parseInt(input.value);

        if (currentValue > 0) {
            input.value = currentValue - 1;
        }
    }
</script>
</body>
</html>