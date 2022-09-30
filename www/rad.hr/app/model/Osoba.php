<?php

class Osoba
{

    public static function brisanje($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            insert into osoba
            (ime,prezime,mjesto_stanovanja,oib,datum_rodenja,naziv_terena,smjena)
            values
            (:ime,:prezime,:mjesto_stanovanja,:oib,:datum_rodenja,:naziv_terena,:smjena)
        
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);
        $ukupno = $izraz->fetchColumn();
        return $ukupno == 0;
    }

    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            select * from osoba where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);
        return $izraz->fetch();
    }


    // CRUD - C
    public static function create($osoba)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            insert into osoba
            (ime,prezime,mjesto_stanovanja,oib,datum_rodenja,naziv_terena,smjena,email)
            values (:ime,:prezime,:mjesto_stanovanja,:oib,:datum_rodenja,:naziv_terena,:smjena,:email);
        
        ');
        $izraz->execute($osoba);
    }


    // CRUD - R
    public static function read()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            select * from osoba 
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }


    // CRUD - U
    public static function update($osoba)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            update osoba set
                ime=:ime,
                prezime=:prezime,
                mjesto_stanovanja=:mjesto_stanovanja,
                oib=:oib,
                datum_rodenja=:datum_rodenja,
                naziv_terena=:naziv_terena,
                smjena=:smjena,
                email=:email
                where sifra=:sifra
        
        ');
        $izraz->execute($osoba);
    }


    // CRUD - D
    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            delete from osoba where sifra=:sifra
        
        ');
        $izraz->execute(['sifra' => $sifra]);
    }
}
