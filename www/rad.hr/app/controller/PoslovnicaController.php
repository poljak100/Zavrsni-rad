<?php

class PoslovnicaController extends AutorizacijaController
{

    private $phtmlDir = 'privatno' .
        DIRECTORY_SEPARATOR . 'poslovnica' .
        DIRECTORY_SEPARATOR;

    private $poslovnica = null;
    private $poruka = '';

    public function index()
    {
        $this->view->render($this->phtmlDir . 'index', [
            'poslovnica' => Poslovnica::read()
        ]);
    }

    public function nova()
    {
        $poslovnica = Poslovnica::create([
            'naziv' => '',
            'mjesto' => '',
            'email' => 'Ledo@gmail.hr'
            
        ]);
        header('location: ' . App::config('url')
            . 'poslovnica/promjena/' . $poslovnica);
    }

    public function promjena($sifra)
    {
        if (!isset($_POST['naziv'])) // NIJE DOBRO
        {

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

        $this->poslovnica = (object) $_POST;
        $this->poslovnica->sifra = $sifra;

        

        $this->view->render($this->phtmlDir . 'detalji', [
            'e' => $this->poslovnica,
            'poruka' => $this->poruka
        ]);
    }


    public function brisanje($sifra)
    {
        Poslovnica::delete($sifra);
        header('location: ' . App::config('url') . 'poslovnica');
    }
}
