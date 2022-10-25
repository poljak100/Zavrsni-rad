<?php

class ProizvodDistribucija
{

    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
select a.sifra ,a.proizvod ,a.distribucija ,
b.naziv_proizvoda ,b.cijena_proizvoda ,b.proizvodac,
c.mjesto ,c.vrijeme,d.ime ,d.prezime
from proizvod_distribucija a 
inner join proizvod b 
on b.sifra = a.proizvod 
inner join distribucija c 
on c.sifra =a.distribucija 
inner join osoba d 
on d.sifra = c.osoba 
inner join poslovnica e 
on e.sifra= b.poslovnica ;
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
        
select a.sifra ,a.proizvod ,a.distribucija ,
b.naziv_proizvoda ,b.cijena_proizvoda ,b.proizvodac,
c.mjesto ,c.vrijeme,d.ime ,d.prezime
from proizvod_distribucija a 
inner join proizvod b 
on b.sifra = a.proizvod 
inner join distribucija c 
on c.sifra =a.distribucija 
inner join osoba d 
on d.sifra = c.osoba 
inner join poslovnica e 
on e.sifra= b.poslovnica ;



        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    // CRUD - C
    public static function create($p)
    {

        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        insert into proizvod_distribucija
            (proizvod,distribucija)
            
            values
            (:proizvod,:distribucija);
            
        
        ');
        $izraz->execute($p);
        return $veza->lastInsertId();
    }

    // CRUD - U
    public static function update($p)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();

        $izraz = $veza->prepare('
        
        SELECT proizvod FROM proizvod_distribucija WHERE sifra=:sifra
        
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
        
        SELECT proizvod FROM proizvod_distribucija WHERE sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);
        $sifraOsoba = $izraz->fetchColumn();

        $izraz = $veza->prepare('
            delete FROM proizvod_distribucija WHERE sifra=:sifra
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);

        $izraz = $veza->prepare('
            delete FROM proizvod WHERE sifra=:sifra
        ');
        $izraz->execute([
            'sifra' => $sifraOsoba
        ]);


        $veza->commit();
    }
}
