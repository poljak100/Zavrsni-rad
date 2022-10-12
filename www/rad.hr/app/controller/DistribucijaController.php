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

    public function novi()
    {
        $novaDistribucija = Distribucija::create([
            'mjesto' => '',
            'vrijeme' => '',
            'kolicina' => '',
            'osoba' =>''
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
        $this->entitet->mjesto = isset($_POST['mjesto']);
        $this->entitet->sifra=$sifra;

        if ($this->kontrola()) {
            Distribucija::create((array)$this->entitet);
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
        return  $this->kontrolirajMjesto()
            && $this->kontrolirajVrijeme()
            && $this->kontrolirajKolicina();
    }

    private function kontrolirajVrijeme()
    {
        return true;
    }

    private function kontrolirajKolicina()
    {

        return true;
    }

    private function kontrolirajMjesto()
    {

        return true;
    }


    public function brisanje($sifra)
    {
        Distribucija::delete($sifra);
        header('location: ' . App::config('url') . 'distribucija');
    }
}



