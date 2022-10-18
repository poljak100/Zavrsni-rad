<?php

class Proizvod
{

    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        SELECT  
        a.sifra , a.naziv_proizvoda  ,a.cijena_proizvoda  ,a.proizvodac 
        ,b.naziv  ,b.mjesto ,b.email   
        FROM proizvod a 
        INNER join poslovnica  b 
        ON a.poslovnica  =b.sifra 
        WHERE a.sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);
        return $izraz->fetch();
    }

    // GROUP BY a.sifra , a.naziv_proizvoda  ,a.cijena_proizvoda  ,a.proizvodac,
    //     ,b.naziv  ,b.mjesto ,b.email 
    //     ORDER BY 4,3

    // CRUD - R
    public static function read()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        SELECT  
        a.sifra , a.naziv_proizvoda  ,a.cijena_proizvoda  ,a.proizvodac 
        ,b.naziv  ,b.mjesto ,b.email   
        FROM proizvod a 
        INNER join poslovnica  b 
        ON a.poslovnica  =b.sifra 
        
            


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
            INSERT INTO poslovnica (naziv,mjesto,email)
            VALUES (:naziv,:mjesto,:email);
        ');
        $izraz->execute([
            'naziv' => $p['naziv'],
            'mjesto' => $p['mjesto'],
            'email' => $p['email']
        ]);
        $sifraPoslovnica = $veza->lastInsertId();
        $izraz = $veza->prepare('
            INSERT INTO proizvod (naziv_proizvoda,cijena_proizvoda,proizvodac,poslovnica)
            VALUES (:naziv_proizvoda,:cijena_proizvoda,:proizvodac,:poslovnica);
        ');
        $izraz->execute([
            'poslovnica' => $sifraPoslovnica,
            'naziv_proizvoda' => $p['naziv_proizvoda'],
            'cijena_proizvoda' => $p['cijena_proizvoda'],
            'proizvodac' => $p['proizvodac']
        ]);
        $sifraProizvod = $veza->lastInsertId();
        $veza->commit();
        return $sifraProizvod;
    }

    // CRUD - U
    public static function update($p)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();
//dali mora ici oboje
        $izraz = $veza->prepare(' 
        
        SELECT poslovnica FROM proizvod WHERE sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra' => $p['sifra']
        ]);
        $sifraPoslovnica = $izraz->fetchColumn();

        $izraz = $veza->prepare('
            UPDATE poslovnica SET
            naziv=:naziv,
            mjesto=:mjesto,
            email=:email
            WHERE sifra=:sifra
        ');
        $izraz->execute([
            'naziv' => $p['naziv'],
            'mjesto' => $p['mjesto'],
            'email' => $p['email'],
            'sifra' => $sifraPoslovnica
        ]);

        $izraz = $veza->prepare('
            UPDATE proizvod SET
            naziv_proizvoda=:naziv_proizvoda,
            cijena_proizvoda=:cijena_proizvoda,
            proizvodac=:proizvodac
            WHERE sifra=:sifra
        ');
        $izraz->execute([
            'naziv_proizvoda' => $p['naziv_proizvoda'],
            'cijena_proizvoda' => $p['cijena_proizvoda'],
            'proizvodac' => $p['proizvodac'],
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
        
        SELECT poslovnica FROM proizvod WHERE sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);
        $sifraPoslovnica = $izraz->fetchColumn();

        $izraz = $veza->prepare('
            delete FROM proizvod WHERE sifra=:sifra
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);

        $izraz = $veza->prepare('
            delete FROM poslovnica WHERE sifra=:sifra
        ');
        $izraz->execute([
            'sifra' => $sifraPoslovnica
        ]);


        $veza->commit();
    }
}
