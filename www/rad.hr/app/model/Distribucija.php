<?php

class Distribucija
{

    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        SELECT  
        a.sifra , a.mjesto ,a.vrijeme ,a.kolicina 
        ,b.ime ,b.prezime ,mjesto_stanovanja, b.oib , b.naziv_terena , b.smjena,email  
        FROM distribucija a 
        INNER join osoba b 
        ON a.osoba =b.sifra 
        WHERE a.sifra=:sifra
            
        
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
        
        SELECT  a.sifra , a.mjesto ,a.vrijeme ,a.kolicina 
        ,b.ime ,b.prezime ,mjesto_stanovanja, b.oib , b.naziv_terena , b.smjena,email  
        FROM distribucija a 
        INNER join osoba b 
        on a.osoba =b.sifra 
        GROUP BY a.sifra, a.mjesto,a.vrijeme,a.kolicina,
        b.ime ,b.prezime ,mjesto_stanovanja, b.oib , b.naziv_terena , b.smjena,email 
        ORDER BY 4,3
            


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
            INSERT INTO osoba (ime,prezime,mjesto_stanovanja,oib,naziv_terena,smjena,email)
            VALUES (:ime,:prezime,:mjesto_stanovanja,:oib,:naziv_terena,:smjena,:email);
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
            INSERT INTO distribucija (mjesto,vrijeme,kolicina,osoba)
            VALUES (:mjesto,:vrijeme,:kolicina,:osoba);
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
        
        SELECT osoba FROM distribucija WHERE sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra' => $p['sifra']
        ]);
        $sifraOsoba = $izraz->fetchColumn();

        $izraz = $veza->prepare('
            UPDATE osoba SET
            ime=:ime,
            prezime=:prezime,
            mjesto_stanovanja=:mjesto_stanovanja,
            oib=:oib,
            naziv_terena=:naziv_terena,
            smjena=:smjena,
            email=:email
            WHERE sifra=:sifra
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
            UPDATE distribucija SET
            mjesto=:mjesto,
            vrijeme=:vrijeme,
            kolicina=:kolicina
            WHERE sifra=:sifra
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
        
        SELECT osoba FROM distribucija WHERE sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);
        $sifraOsoba = $izraz->fetchColumn();

        $izraz = $veza->prepare('
            delete FROM distribucija WHERE sifra=:sifra
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);

        $izraz = $veza->prepare('
            delete FROM osoba WHERE sifra=:sifra
        ');
        $izraz->execute([
            'sifra' => $sifraOsoba
        ]);


        $veza->commit();
    }
}
