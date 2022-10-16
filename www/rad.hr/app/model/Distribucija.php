<?php

class Distribucija
{

    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select  a.sifra , a.mjesto ,a.vrijeme ,a.kolicina 
        ,b.ime ,b.prezime ,mjesto_stanovanja, b.oib , b.naziv_terena , b.smjena,email  
        from distribucija a 
        inner join osoba b 
        on a.osoba =b.sifra 
        where a.sifra=:sifra
            
        
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);
        return $izraz->fetch();
    }

    // CRUD - R
    public static function read()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select  a.sifra , a.mjesto ,a.vrijeme ,a.kolicina 
        ,b.ime ,b.prezime ,mjesto_stanovanja, b.oib , b.naziv_terena , b.smjena,email  
        from distribucija a 
        inner join osoba b 
        on a.osoba =b.sifra 
        group by a.sifra, a.mjesto,a.vrijeme,a.kolicina,
        b.ime ,b.prezime ,mjesto_stanovanja, b.oib , b.naziv_terena , b.smjena,email 
        order by 4,3
            


        ');
        $izraz->execute(); 
        return $izraz->fetchAll(); 
    }

    // CRUD - C
    public static function create($p) 
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
            insert into osoba (ime,prezime,mjesto_stanovanja,oib,naziv_terena,smjena,email)
            values (:ime,:prezime,:mjesto_stanovanja,:oib,:naziv_terena,:smjena,:email);
        ');
        $izraz->execute([
            'ime' => $p['ime'],
            'prezime' => $p['prezime'],
            'mjesto_stanovanja' => $p['mjesto_stanovanja'],
            'oib' => $p['oib'],
            'naziv_terena' => $p['naziv_terena'],
            'smjena' => $p['smjena'],
            'email' => $p['email']

        ]);
        $sifraOsoba = $veza->lastInsertId();
        $izraz = $veza->prepare('
            insert into distribucija (mjesto,vrijeme,kolicina,osoba)
            values (:mjesto,:vrijeme,:kolicina,:osoba);
        ');
        $izraz->execute([
            'osoba' => $sifraOsoba,
            'mjesto' => $p['mjesto'],
            'vrijeme' => $p['vrijeme'],
            'kolicina' => $p['kolicina']
        ]);
        $sifraDistribucija = $veza->lastInsertId();
        $veza->commit();
        return $sifraDistribucija;
    }

    // CRUD - U
    public static function update($p)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();

        $izraz = $veza->prepare('
        
        select osoba from distribucija where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra' => $p['sifra']
        ]);
        $sifraOsoba = $izraz->fetchColumn();

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
        $izraz->execute([
            'ime' => $p['ime'],
            'prezime' => $p['prezime'],
            'mjesto_stanovanja' => $p['mjesto_stanovanja'],
            'oib' => $p['oib'],
            'naziv_terena' => $p['naziv_terena'],
            'smjena' => $p['smjena'],
            'email' => $p['email'],
            'sifra' => $sifraOsoba
        ]);

        $izraz = $veza->prepare('
            update distribucija set
            mjesto=:mjesto,
            vrijeme=:vrijeme,
            kolicina=:kolicina
            where sifra=:sifra
        ');
        $izraz->execute([
            'mjesto' => $p['mjesto'],
            'vrijeme' => $p['vrijeme'],
            'kolicina' => $p['kolicina'],
            'sifra' => $p['sifra']
        ]);


        $veza->commit();
    }

    // CRUD - D
    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();

        $izraz = $veza->prepare('
        
        select osoba from distribucija where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);
        $sifraOsoba = $izraz->fetchColumn();

        $izraz = $veza->prepare('
            delete from distribucija where sifra=:sifra
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);

        $izraz = $veza->prepare('
            delete from osoba where sifra=:sifra
        ');
        $izraz->execute([
            'sifra' => $sifraOsoba
        ]);


        $veza->commit();
    }
}
