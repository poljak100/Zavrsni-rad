<?php

class ProizvodController extends AutorizacijaController
{

    private $phtmlDir = 'privatno' .
        DIRECTORY_SEPARATOR . 'proizvodi' .
        DIRECTORY_SEPARATOR;

    private $entitet = null;
    private $poruka = '';

    public function index()
    {
        $this->view->render($this->phtmlDir . 'index', [
            'entiteti' => Proizvod::read()
        ]);
    }

    public function nova()
    {
        $noviProivodi = Proizvod::create([
            'naziv' => '',
            'mjesto' => '',
            'email' => '',
            'naziv_proizvoda' => '',
            'cijena_proizvoda' => '',
            'proizvodac' => ''
            
        ]);
        header('location: ' . App::config('url') . 'proizvod/promjena/' . $noviProivodi);
    }

    public function promjena($sifra)
    {
        if (!isset($_POST['naziv_proizvoda'])) {

            $e = Proizvod::readOne($sifra);
            if ($e == null) {
                header('location: ' . App::config('url') . 'proizvod');
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
            Proizvod::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'proizvod');
            return;
        }

        $this->view->render($this->phtmlDir . 'detalji', [
            'e' => $this->entitet,
            'poruka' => $this->poruka
        ]);
    }

    private function kontrola()
    {
        return $this->KontrolaNaziv()
            && $this->KontrolaMjesto()
            && $this->KontrolaEmail();
    }

    private function KontrolaNaziv()
    {
        if (strlen($this->entitet->naziv) === 0) {
            $this->poruka = 'Naziv obavezno';
            return false;
        }
        return true;
    }

    private function KontrolaMjesto()
    {
        if (strlen($this->entitet->mjesto) === 0) {
            $this->poruka = 'Mjesto obavezno';
            return false;
        }
        return true;
    }

    private function KontrolaEmail()
    {
        return true;
    }

    public function brisanje($sifra)
    {
        Proizvod::delete($sifra);
        header('location: ' . App::config('url') . 'proizvod');
    }
}
