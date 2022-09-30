<?php

class DistribucijaController extends AutorizacijaController
{
    private $phtmlDir = 'privatno' . 
        DIRECTORY_SEPARATOR . 'distribucija' .
        DIRECTORY_SEPARATOR;

    private $entitet;
    private $poruka;

    public function index()
    {
        $this->view->render($this->phtmlDir . 'index',[
            'entiteti' => Distribucija::read()
        ]);
    }

    public function nova()
    {
        $novi = Distribucija::create([
            'mjesto'=>'',
            'vrijeme'=>1,
            'kolicina'=>1,
            'osoba'=>''
            
        ]);
        header('location: ' . App::config('url') 
                . 'distribucija/promjena/' . $novi);
    }

    public function promjena($sifra)
    {
        if(!isset($_POST['naziv'])){

            $e = Distribucija::readOne($sifra);
            if($e==null){
                header('location: ' . App::config('url') . 'distribucija');
            }

            $this->view->render($this->phtmlDir . 'detalji',[
                'e' => $e,
                'osoba'=>Osoba::read(),
                'poruka' => 'Unesite podatke'
            ]);
            return;
        }

        $this->entitet = (object) $_POST;
        $this->entitet->sifra=$sifra;
    

        $this->view->render($this->phtmlDir . 'detalji',[
            'e'=>$this->entitet,
            'osoba'=>Osoba::read(),
            'poruka'=>$this->poruka
        ]);
    }
}