<?php

class Predavac
{

    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select a.sifra, a.iban,
        b.ime, b.prezime, b.email, b.oib from 
        predavac a inner join
        osoba b on a.osoba =b.sifra 
        where a.sifra=:sifra
        
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
        
            select a.sifra, a.iban,
            b.ime, b.prezime, b.email, 
            b.oib, count(c.sifra) as grupa from 
            predavac a inner join
            osoba b on a.osoba =b.sifra 
            left join grupa c 
            on a.sifra = c.predavac 
            group by a.sifra, a.iban,
            b.ime, b.prezime, b.email, 
            b.oib order by 4,3
        
        ');
        $izraz->execute(); // OVO MORA BITI OBAVEZNO
        return $izraz->fetchAll(); // vraća indeksni niz objekata tipa stdClass
    }

    // CRUD - C
    public static function create($p) //$p kao parametri - napisano skraćeno
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
            insert into osoba (ime,prezime,email,oib)
            values (:ime,:prezime,:email,:oib);
        ');
        $izraz->execute([
            'ime'=>$p['ime'],
            'prezime'=>$p['prezime'],
            'email'=>$p['email'],
            'oib'=>$p['oib']
        ]);
        $sifraOsoba = $veza->lastInsertId();
        $izraz = $veza->prepare('
            insert into predavac (osoba,iban)
            values (:osoba,:iban);
        ');
        $izraz->execute([
            'osoba'=>$sifraOsoba,
            'iban'=>$p['iban']
        ]);
        $sifraPredavac = $veza->lastInsertId();
        $veza->commit();
        return $sifraPredavac;
    }

    // CRUD - U
    public static function update($p)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();

        $izraz = $veza->prepare('
        
           select osoba from predavac where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$p['sifra']
        ]);
        $sifraOsoba = $izraz->fetchColumn();

        $izraz = $veza->prepare('
            update osoba set
            ime=:ime,
            prezime=:prezime,
            email=:email,
            oib=:oib
            where sifra=:sifra
        ');
        $izraz->execute([
            'ime'=>$p['ime'],
            'prezime'=>$p['prezime'],
            'email'=>$p['email'],
            'oib'=>$p['oib'],
            'sifra'=>$sifraOsoba
        ]);

        $izraz = $veza->prepare('
            update predavac set
            iban=:iban
            where sifra=:sifra
        ');
        $izraz->execute([
            'iban'=>$p['iban'],
            'sifra'=>$p['sifra']
        ]);


        $veza->commit();

    }

     // CRUD - D
    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();

        $izraz = $veza->prepare('
        
           select osoba from predavac where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
        $sifraOsoba = $izraz->fetchColumn();

        $izraz = $veza->prepare('
            delete from predavac where sifra=:sifra
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);

        $izraz = $veza->prepare('
            delete from osoba where sifra=:sifra
        ');
        $izraz->execute([
            'sifra'=>$sifraOsoba
        ]);


        $veza->commit();
    }
}