<?php

class Distribucija
{


    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
           select * from distribucija where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);
        $distribucija = $izraz->fetch();

        $izraz = $veza->prepare('
        
                select  a.ime, a.prezime ,a.naziv_terena  ,b.mjesto , b.vrijeme , b.kolicina 
                from osoba  a inner join distribucija  b
                on a.sifra =b.osoba where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);
        $distribucija->osoba = $izraz->fetchAll();

        return $distribucija;
    }

    public static function read()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
         
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function create($p)
    {

        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        insert into distribucija
            (naziv,datumpocetka,maksimalnopolaznika,
            smjer,predavac)
            values
            (:naziv,:datumpocetka,:maksimalnopolaznika,
            :smjer,:predavac);
        
        ');
        $izraz->execute($p);
        return $veza->lastInsertId();
    }

    public static function update($p)
    {
    }

    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        delete from distribucija where sifra=:sifra 
        
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);
    }
}
