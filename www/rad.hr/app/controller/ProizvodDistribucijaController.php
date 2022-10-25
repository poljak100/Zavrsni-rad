<?php

class ProizvodDistribucijaController extends AutorizacijaController
{

    private $phtmlDir = 'privatno' .
        DIRECTORY_SEPARATOR . 'proizvoddistribucija' .
        DIRECTORY_SEPARATOR;

    private $entitet = null;
    private $poruka = '';

    public function index()
    {
        $this->view->render($this->phtmlDir . 'index', [
            'entiteti' => ProizvodDistribucija::read()
        ]);
    }

    public function nova()
    {
        $novaPD = ProizvodDistribucija::create([
            'proizvod' => '',
            'distribucija' => ''
        ]);
        header('location: ' . App::config('url')
            . 'proizvoddistribucija/promjena/' . $novaPD);
    }

    public function promjena($sifra)
    {
        if (!isset($_POST['distribucija'])) {

            $e = ProizvodDistribucija::readOne($sifra);
            if ($e == null) {
                header('location: ' . App::config('url') . 'proizvoddistribucija');
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
            ProizvodDistribucija::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'proizvoddistribucija');
            return;
        }

        $this->view->render($this->phtmlDir . 'detalji', [
            'e' => $this->entitet,
            'poruka' => $this->poruka
        ]);
    }

    private function kontrola()
    {
        return $this->kontrolaIme() && $this->kontrolaPrezime();
    }

    private function kontrolaIme()
    {
        if (strlen($this->entitet->proizvod) === 0) {
            $this->poruka = 'Ime obavezno';
            return false;
        }
        return true;
    }

    private function kontrolaPrezime()
    {
        if (strlen($this->entitet->distribucija) === 0) {
            $this->poruka = 'Prezime obavezno';
            return false;
        }
        return true;
    }


    public function brisanje($sifra)
    {
        ProizvodDistribucija::delete($sifra);
        header('location: ' . App::config('url') . 'proizvoddistribucija');
    }
}
