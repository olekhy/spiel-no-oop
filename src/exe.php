<?php

/**
 * Simple implementation of Rock Scissor Paper game
 *
 * @author  Olekhy <olekhy@gmail.com>
 * @license WTFPL http://www.wtfpl.net/about/
 */

declare(strict_types=1);

$nameOne   = 'anna';
$nameOther = 'alla';
$rounds    = 100;
$symbols   = [
    'rock',
    'scissor',
    'paper',
];

$bits = [];

foreach ($symbols as $symbol) {
    $bits[$symbol] = (1 << \array_search($symbol, $symbols, true));
}

$rules = [
    $bits['rock']    => ($bits['rock'] | $bits['scissor']),
    $bits['scissor'] => ($bits['scissor'] | $bits['paper']),
    $bits['paper']   => ($bits['paper'] | $bits['rock']),
];

$result = [
    'draws'    => 0,
    $nameOne   => 0,
    $nameOther => 0,
];

for ($i = 0; $i < $rounds; $i++) {
    $threw           = [];
    $threw[$nameOne] = 1;
    $threw[$nameOther] = (1 << \random_int(0, (\count($symbols) - 1)));

    if ($threw[$nameOne] === $threw[$nameOther]) {
        $result['draws']++;
        continue;
    }

    foreach ($rules as $winnerSymbol => $amongSymbols) {
        if (($threw[$nameOne] & $amongSymbols) !== 0 && $threw[$nameOther] === $winnerSymbol) {
            $result[$nameOther]++;
            break;
        }

        if (($threw[$nameOther] & $amongSymbols) !== 0 && $threw[$nameOne] === $winnerSymbol) {
            $result[$nameOne]++;
            break;
        }
    }
}//end for

\system('clear');
printf('%d games played%s', $rounds, PHP_EOL);
printf('Games with draws: %d%s', $result['draws'], PHP_EOL);
printf('%s wins: %d%s', ucfirst($nameOne), $result[$nameOne], PHP_EOL);
printf('%s wins: %d%s', ucfirst($nameOther), $result[$nameOther], PHP_EOL);
