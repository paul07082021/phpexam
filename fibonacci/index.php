<?php

  function fibonacci($n) {
        $fib = [];

        $fib[0] = 0;
        $fib[1] = 1;

        for ($i = 2; $i <= $n; $i++) {
            $fib[$i] = $fib[$i-1] + $fib[$i-2];
        }
        return array_slice($fib, 0, $n);
    }

    if(isset($_POST['number'])){
        $input = $_POST['number'];
        $result = fibonacci($input);
        $res =  "Input: $input, Output: " . implode(", ", $result);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fibonacci</title>
</head>
<body>
    <h1> Fibonacci </h1>
    <form method="POST" action="">
    <input type="text" name="number" placeholder="Input Number" required><br><br>
    <button type="submit">Submit</button>
    </form><br>
    <span style="color:blue;"><?= isset($res) ? $res:''?></span>
</body>
</html>