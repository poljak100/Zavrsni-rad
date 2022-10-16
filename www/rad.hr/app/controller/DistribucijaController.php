<?php

class DistribucijaController extends AutorizacijaController
{

    private $phtmlDir = 'privatno' .
        DIRECTORY_SEPARATOR . 'distribucije' .
        DIRECTORY_SEPARATOR;

    private $entitet = null;
    private $poruka = '';

    public function index()
    {
        $this->view->render($this->phtmlDir . 'index', [
            'entiteti' => Distribucija::read()
        ]);
    }

    public function nova()
    {
        $novaDistribucija = Distribucija::create([
            'ime' => '',
            'prezime' => '',
            'mjesto_stanovanja' => '',
            'oib' => '',
            'naziv_terena' => '',
            'smjena' => '',
            'email' => '',
            'mjesto' => '',
            'vrijeme' => '',
            'kolicina' => ''
        ]);
        header('location: ' . App::config('url')
            . 'distribucija/promjena/' . $novaDistribucija);
    }

    public function promjena($sifra)
    {
        if (!isset($_POST['ime'])) {

            $e = Distribucija::readOne($sifra);
            if ($e == null) {
                header('location: ' . App::config('url') . 'distribucija');
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
            Distribucija::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'distribucija');
            return;
        }

        $this->view->render($this->phtmlDir . 'detalji', [
            'e' => $this->entitet,
            'poruka' => $this->poruka
        ]);
    }

    private function kontrola()
    {
        return $this->kontrolaIme()
            && $this->kontrolaPrezime()
            && $this->kontrolaOib();
    }

    private function kontrolaIme()
    {
        if (strlen($this->entitet->ime) === 0) {
            $this->poruka = 'Ime obavezno';
            return false;
        }
        return true;
    }

    private function kontrolaPrezime()
    {
        if (strlen($this->entitet->prezime) === 0) {
            $this->poruka = 'Prezime obavezno';
            return false;
        }
        return true;
    }

    private function kontrolaOib()
    {
        return true;
    }

    public function brisanje($sifra)
    {
        Distribucija::delete($sifra);
        header('location: ' . App::config('url') . 'distribucija');
    }

}
