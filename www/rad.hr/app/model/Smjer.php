<?php

class Smjer
{

    public static function brisanje($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            select count(*) from grupa where smjer=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
        $ukupno = $izraz->fetchColumn();
        return $ukupno==0; 
    }

    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            select * from smjer where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
        return $izraz->fetch(); 
    }

    // CRUD - R
    public static function read()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            select * from smjer order by naziv
        
        ');
        $izraz->execute(); // OVO MORA BITI OBAVEZNO
        return $izraz->fetchAll(); // vraća indeksni niz objekata tipa stdClass
    }

    // CRUD - C
    public static function create($smjer)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            insert into 
            smjer(naziv,cijena,trajanje,upisnina,certificiran)
            values (:naziv,:cijena,:trajanje,:upisnina,:certificiran);
        
        ');
        $izraz->execute($smjer);
    }

    // CRUD - U
    public static function update($smjer)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            update smjer set
                naziv=:naziv,
                cijena=:cijena,
                trajanje=:trajanje,
                upisnina=:upisnina,
                certificiran=:certificiran
                    where sifra=:sifra
        
        ');
        $izraz->execute($smjer);
    }

     // CRUD - D
    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            delete from smjer where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
    }
}