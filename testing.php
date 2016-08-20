<?php

$arr1 = Array(
    1 => Array(
        0 => 123,
        1 => 423,
        2 => 546,
        3 => 567,
        4 => 234,
        5 => 464,
        6 => 675
    )
);

$arr2 = Array(
    37 => Array(
        40 => "40",
        21 => "21",
        22 => "22",
        83 => "83",
        44 => "44",
        56 => "56",
        69 => "69"
    )
);

function key_compare_func($a, $b){
    if ($a === $b) {
        return 1;
    }
    return ($a > $b)? 1:-1;
}

$arr3 = array_diff_uassoc($arr2, $arr1, "key_compare_func");
echo "<pre>";
print_r($arr3);
echo "</pre>";
?>