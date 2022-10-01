<?php

$dev = $_SERVER['SERVER_ADDR'] == '127.0.0.1';

if ($dev) {
    return [
        'dev' => $dev,
        'url' => 'http://rad.hr/',
        'nazivApp' => 'DEV Tvrtka',
        'baza' => [
            'server' => 'localhost',
            'baza' => 'tvrtka',
            'korisnik' => 'dino',
            'lozinka' => 'dino'
        ]
    ];
} else {
    // PRODUKCIJA
    return [
        'dev' => $dev,
        'url' => 'https://polaznik09.edunova.hr/',
        'nazivApp' => 'Tvrtka',
        'baza' => [
            'server' => 'localhost',
            'baza' => 'temida_tvrtka',
            'korisnik' => 'temida_tvrtka',
            'lozinka' => 'Temida99945'
        ]
    ];
}
