<?php

$dev = $_SERVER['SERVER_ADDR'] == '127.0.0.1';

if ($dev) {
    return [
        'dev' => $dev,
        'url' => 'http://rad.hr/',
        'nazivApp' => 'DEV Edunova App',
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
        'url' => 'https://predavac09.edunova.hr/',
        'nazivApp' => 'Edunova App',
        'baza' => [
            'server' => 'localhost',
            'baza' => 'cesar_edunovapp25',
            'korisnik' => 'cesar_edunova',
            'lozinka' => 'LY)eY&MMUPS%'
        ]
    ];
}
