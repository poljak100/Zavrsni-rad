<?php

class PoslovnicaController extends AutorizacijaController
{

    private $phtmlDir = 'privatno' .
        DIRECTORY_SEPARATOR . 'poslovnice' .
        DIRECTORY_SEPARATOR;

    private $entitet = null;
    private $poruka = '';

    public function index()
    {
        $this->view->render($this->phtmlDir . 'index', [
            'entiteti' => Poslovnica::read()
        ]);
    }

    public function novi()
    {
        $novaPoslovnica = Poslovnica::create([
            'naziv' => '',
            'mjesto' => '',
            'email' => ''
        ]);
        header('location: ' . App::config('url')
            . 'poslovnica/promjena/' . $novaPoslovnica);
    }

    public function promjena($sifra)
    {
        if (!isset($_POST['naziv'])) {

            $e = Poslovnica::readOne($sifra);
            if ($e == null) {
                header('location: ' . App::config('url') . 'poslovnica');
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
            Poslovnica::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'poslovnica');
            return;
        }

        $this->view->render($this->phtmlDir . 'detalji', [
            'e' => $this->entitet,
            'poruka' => $this->poruka
        ]);
    }

    private function kontrola()
    {
        return $this->kontrolirajNaziv() && $this->kontrolirajMjesto() && $this->kontrolirajEmail();
    }

    private function kontrolirajNaziv()
    {
        return true;
    }

    private function kontrolirajEmail()
    {

        return true;
    }

    private function kontrolirajMjesto()
    {

        return true;
    }

    public function brisanje($sifra)
    {
        Poslovnica::delete($sifra);
        header('location: ' . App::config('url') . 'poslovnica');
    }
}
