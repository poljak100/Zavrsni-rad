<?php

class Osoba
{
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
    

    public static function create($osoba)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            insert into 
            osoba(ime,prezime,mjesto_stanovanja,oib,datum_rodenja,naziv_terena,smjena,email)
            values(:ime,:prezime,:mjesto_stanovanja,:oib,:datum_rodenja,:naziv_terena,:smjena,:email)
        
        ');
        $izraz->execute($osoba);
        return $veza->lastInsertId();
    }


    public static function read()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            select * from osoba order by ime
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }


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


    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        delete from osoba where sifra=:sifra 
        
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);
    }
}
