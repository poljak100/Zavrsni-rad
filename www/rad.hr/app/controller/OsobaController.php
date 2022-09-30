<?php

class OsobaController extends AutorizacijaController
{

    private $phtmlDir = 'privatno' .
        DIRECTORY_SEPARATOR . 'osoba' .
        DIRECTORY_SEPARATOR;

    private $osoba = null;
    private $poruka = '';

    public function index()
    {
        $this->view->render($this->phtmlDir . 'read', [
            'osoba' => Osoba::read()
        ]);
    }

    public function promjena($sifra)
    {
        if (!isset($_POST['naziv'])) {

            $osoba = Osoba::readOne($sifra);
            if ($osoba == null) {
                header('location: ' . App::config('url') . 'osoba');
            }

            $this->view->render($this->phtmlDir . 'update', [
                'osoba' => $osoba,
                'poruka' => 'Promjenite podatke'
            ]);
            return;
        }

        $this->osoba = (object) $_POST;
        $this->osoba->sifra = $sifra;


        if ($this->kontrolaPromjena()) {
            Osoba::update((array)$this->osoba);
            //header('location: ' . App::config('url') . 'osoba');
            return;
        }

        $this->view->render($this->phtmlDir . 'update', [
            'osoba' => $this->osoba,
            'poruka' => $this->poruka
        ]);
    }

    public function brisanje($sifra)
    {

        $osoba = Osoba::readOne($sifra);
        if ($osoba == null) {
            header('location: ' . App::config('url') . 'osoba');
        }

        //  if (!isset($_POST['obrisi'])) {
        //      $this->view->render($this->phtmlDir . 'delete', [
        //          'osoba' => $osoba,
        //          'brisanje' => Osoba::brisanje($sifra),
        //          'poruka' => 'Detalji osobe za brisanje'
        //      ]);
        //      return;
        //  }

        Osoba::delete($sifra);
        header('location: ' . App::config('url') . 'osoba');
    }

    public function novi()
    {
        if (!isset($_POST['naziv'])) {

            $this->PripremiOsoba();
            $this->view->render($this->phtmlDir . 'create', [
                'osoba' => $this->osoba,
                'poruka' => 'Popunite sve podatke'
            ]);
            return;
        }
        $this->osoba = (object) $_POST;


        if ($this->kontrolaNovi()) {
            Osoba::create((array)$this->osoba);
            header('location: ' . App::config('url') . 'osoba');
            return;
        }

        $this->view->render($this->phtmlDir . 'create', [
            'osoba' => $this->osoba,
            'poruka' => $this->poruka
        ]);
    }
    // NE
    private function kontrolaNovi()
    {
        return $this->kontrolaNaziv();
    }

    private function kontrolaPromjena()
    {
        return $this->kontrolaNaziv();
    }

    private function kontrolaNaziv()
    {
        Log::log($this->osoba->naziv);
        $this->osoba->naziv = str_replace('&nbsp;', ' ', $this->osoba->naziv);
        $this->osoba->naziv = trim($this->osoba->naziv);
        Log::log($this->osoba->naziv);
        if (strlen($this->osoba->naziv) === 0) {
            $this->poruka = 'Naziv obavezno';
            return false;
        }
        return true;
    }


    private function PripremiOsoba()
    {
        $this->osoba = new stdClass();
        $this->osoba->ime = '';
        $this->osoba->prezime = '';
        $this->osoba->mjesto_stanovanja = '';
        $this->osoba->oib = '';
        $this->osoba->datum_rodenja = '';
        $this->osoba->naziv_terena = '';
        $this->osoba->smjena = '';
        $this->osoba->email = '';
    }
}
