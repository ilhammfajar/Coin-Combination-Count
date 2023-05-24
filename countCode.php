<?php
// ----------------------------------------------------------------
// If you want to see the possible combinations, please uncomment line 11 and 83
// *PS its 23642 line of possible combinations, so it will take a long time
// ----------------------------------------------------------------
function waysToMake3_5($amount, $coins, $currentCombination = []) {
    // If the amount is zero, found a valid combination
    if ($amount === 0) {
        // Print the current combination with grouped coins
        $groupedCombination = groupCoins($currentCombination);
        // echo implode(" + ", $groupedCombination) . "\n";
        return 1;
    }

    // If the amount is negative or there are no more coins left, return 0
    if ($amount < 0 || empty($coins)) {
        return 0;
    }

    // Get the first coin in the list to get the combination
    $currentCoin = $coins[0]['value'];
    $currentCoinName = $coins[0]['name'];
    // Remove the first coin from the list get the other combination with other coins
    $remainingCoins = array_slice($coins, 1);

    // Include the current coin and recursively check the remaining amount
    $newCombination = $currentCombination;
    $newCombination[] = $currentCoinName;
    $includeCurrentCoin = waysToMake3_5($amount - $currentCoin, $coins, $newCombination);

    // Exclude the current coin and recursively check the remaining amount
    $excludeCurrentCoin = waysToMake3_5($amount, $remainingCoins, $currentCombination);

    // Return the sum of the counts
    return $includeCurrentCoin + $excludeCurrentCoin;
}

function groupCoins($combination) {
    $groupedCombination = [];
    $count = 1;
    $prevCoin = null;

    foreach ($combination as $coin) {
        if ($coin === $prevCoin) {
            $count++;
        } else {
            if ($prevCoin !== null) {
                if ($count > 1) {
                    $groupedCombination[] = $count . "X" . $prevCoin;
                } else {
                    $groupedCombination[] = $prevCoin;
                }
            }
            $prevCoin = $coin;
            $count = 1;
        }
    }

    if ($prevCoin !== null) {
        if ($count > 1) {
            $groupedCombination[] = $count . "X" . $prevCoin;
        } else {
            $groupedCombination[] = $prevCoin;
        }
    }

    return $groupedCombination;
}

// Available coins with their names
$coins = [
    ['name' => 'G2', 'value' => 200],
    ['name' => 'G1', 'value' => 100],
    ['name' => '50S', 'value' => 50],
    ['name' => '25S', 'value' => 25],
    ['name' => '10S', 'value' => 10],
    ['name' => '5S', 'value' => 5],
    ['name' => '1S', 'value' => 1],
];
// Target amount (G3.5 = 350)
$amount = 350;

// echo "Possible combinations to make G3.5:\n";
$totalWays = waysToMake3_5($amount, $coins);
echo "Total number of ways: " . $totalWays;

?>
