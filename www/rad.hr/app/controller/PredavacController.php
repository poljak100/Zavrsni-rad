<?php

class PredavacController extends AutorizacijaController
{

    private $phtmlDir = 'privatno' . 
        DIRECTORY_SEPARATOR . 'predavaci' .
        DIRECTORY_SEPARATOR;

    private $entitet=null;
    private $poruka='';

    public function index()
    {
        $this->view->render($this->phtmlDir . 'index',[
            'entiteti'=>Predavac::read()
        ]);
    }

    public function nova()
    {
        $noviPredavac = Predavac::create([
            'ime'=>'',
            'prezime'=>'',
            'email'=>'',
            'oib'=>'',
            'iban'=>''
        ]);
        header('location: ' . App::config('url') 
                . 'predavac/promjena/' . $noviPredavac);
    }
    
    public function promjena($sifra)
    {
        if(!isset($_POST['ime'])){

            $e = Predavac::readOne($sifra);
            if($e==null){
                header('location: ' . App::config('url') . 'predavac');
            }

            $this->view->render($this->phtmlDir . 'detalji',[
                'e' => $e,
                'poruka' => 'Unesite podatke'
            ]);
            return;
        }

        $this->entitet = (object) $_POST;
        $this->entitet->sifra=$sifra;
    
        if($this->kontrola()){
            Predavac::update((array)$this->entitet);
            header('location: ' . App::config('url') . 'predavac');
            return;
        }

        $this->view->render($this->phtmlDir . 'detalji',[
            'e'=>$this->entitet,
            'poruka'=>$this->poruka
        ]);
    }

    private function kontrola()
    {
        return $this->kontrolaIme() && $this->kontrolaPrezime()
        && $this->kontrolaOib();
    }

    private function kontrolaIme()
    {
        if(strlen($this->entitet->ime)===0){
            $this->poruka = 'Ime obavezno';
            return false;
        }
        return true;
    }

    private function kontrolaPrezime()
    {
        if(strlen($this->entitet->prezime)===0){
            $this->poruka = 'Prezime obavezno';
            return false;
        }
        return true;
    }

    private function kontrolaOib(){
        // domaća zadaća
        // ovdje implementirati https://regos.hr/app/uploads/2018/07/KONTROLA-OIB-a.pdf
        // dohvatiti si oib-e s http://oib.itcentrala.com/oib-generator/
        return true;
    }

    public function brisanje($sifra)
    {
        Predavac::delete($sifra);
        header('location: ' . App::config('url') . 'predavac');
    }

    public function testinsert()
    {
        for($i=0;$i<10;$i++){
            echo Predavac::create([
                'ime'=>'Pero ' . $i,
                'prezime'=>'Perić',
                'email'=>'',
                'oib'=>'',
                'iban'=>''
            ]);
        }
        
    }
   

}