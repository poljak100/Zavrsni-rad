<?php

class OsobaController extends AutorizacijaController
{

    private $phtmlDir = 'privatno' .
        DIRECTORY_SEPARATOR . 'osobe' .
        DIRECTORY_SEPARATOR;

    private $entitet = null;
    private $poruka = '';

    public function index()
    {
        $this->view->render($this->phtmlDir . 'index', [
            'entiteti' => Osoba::read()
        ]);
    }

    public function novi()
    {
        $novaOsoba = Osoba::create([
            'ime' => '',
            'prezime' => '',
            'mjesto_stanovanja' => '',
            'oib' => '',
            'datum_rodenja' => '',
            'naziv_terena' => '',
            'smjena' => '',
            'email' => ''
        ]);
        header('location: ' . App::config('url')
            . 'osoba/promjena/' . $novaOsoba);
    }

    public function promjena($sifra)
    {
        if (!isset($_POST['ime'])) {

            $e = Osoba::readOne($sifra);
            if ($e == null) {
                header('location: ' . App::config('url') . 'osoba');
            }

            $this->view->render($this->phtmlDir . 'detalji', [
                'e' => $e,
                'poruka' => 'Unesite podatke'
            ]);
            return;
        }

        $this->entitet = (object) $_POST;
        $this->entitet->sifra = $sifra;

        if ($this->kontrola()) {
            Osoba::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'osoba');
            return;
        }

        $this->view->render($this->phtmlDir . 'detalji', [
            'e' => $this->entitet,
            'poruka' => $this->poruka
        ]);
    }

    private function kontrola()
    {
        return $this->kontrolirajIme() && $this->kontrolirajPrezime() && $this->kontrolirajOib();
    }

    private function kontrolirajIme()
    {
        return true;
    }

    private function kontrolirajPrezime()
    {

        return true;
    }

    private function kontrolirajOib()
    {

        return true;
    }

    public function brisanje($sifra)
    {
        Osoba::delete($sifra);
        header('location: ' . App::config('url') . 'osoba');
    }
}
