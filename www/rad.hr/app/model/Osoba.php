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
            osoba(ime,prezime,mjesto_stanovanja,oib,naziv_terena,smjena,email)
            values(:ime,:prezime,:mjesto_stanovanja,:oib,:naziv_terena,:smjena,:email)
        
        ');
        $izraz->execute($osoba);
        return $veza->lastInsertId();//ovo
    }


    public static function read()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            select * from osoba 
        
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
