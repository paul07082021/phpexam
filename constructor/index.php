<?php

class ArraySorter {
    private $data;

    public function __construct($array) {
        $this->data = $array;
        $this->applyBubbleSort();
    }

    private function applyBubbleSort() {
        $n = count($this->data);
        for ($i = 0; $i < $n-1; $i++) {
            for ($j = 0; $j < $n-$i-1; $j++) {
                if ($this->data[$j] > $this->data[$j+1]) {
                    $temp = $this->data[$j];
                    $this->data[$j] = $this->data[$j+1];
                    $this->data[$j+1] = $temp;
                }
            }
        }
    }

    public function getSortedArray() {
        return $this->data;
    }
}

class MedianAndMaxValueFinder {
    private $arraySorter;

    public function __construct($array) {
        $this->arraySorter = new ArraySorter($array);
    }

    public function findMedian() {
        $sortedArray = $this->arraySorter->getSortedArray();
        $n = count($sortedArray);
        
        if ($n % 2 == 0) {
            $median = ($sortedArray[$n / 2 - 1] + $sortedArray[$n / 2]) / 2;
        } else {
            $median = $sortedArray[floor($n / 2)];
        }
        
        return $median;
    }

    public function findMaxValue() {
        $sortedArray = $this->arraySorter->getSortedArray();
        $n = count($sortedArray);
        
        $maxValue = $sortedArray[$n - 1];
        
        return $maxValue;
    }

    public function getSortedArray() {
        return $this->arraySorter->getSortedArray();
    }
}

if (isset($_POST['array'])) {
    $inputArray = $_POST['array'];
    $array = array_map('intval', explode(',', $inputArray));
    $finder = new MedianAndMaxValueFinder($array);

    $result = "Input Array: " . implode(', ', $array) . "<br>" .
    "Sorted Array: " . implode(', ', $finder->getSortedArray()) . "<br>" .
    "Median: " . $finder->findMedian() . "<br>" .
    "Max Value: " . $finder->findMaxValue() . "<br>";
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Array Sorter and Finder</title>
</head>
<body>
    <form method="post" action="">
     Enter array (comma-separated number):
    <input type="text" name="array" placeholder="example: 5, 3, 8, 2, 7, 6" required>
    <input type="submit" value="Submit"><br><br>
    Result:<br><?= isset($result) ?$result : ''?>
    </form>
</body>
</html>
