<?php

class ProizvodDistribucija
{

    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
select a.sifra ,a.proizvod ,a.distribucija,a.kolicina ,
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
on e.sifra= b.poslovnica 
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
        
select a.sifra ,a.proizvod ,a.distribucija , a.kolicina ,
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
            (proizvod,distribucija,kolicina)
            
            values
            (:proizvod,:distribucija,:kolicina);
            
        
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
        $sifraProizvod = $izraz->fetchColumn();

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
            'sifra' => $sifraProizvod
        ]);

        $sifraDistribucija = $izraz->fetchColumn();

        $izraz = $veza->prepare('
            UPDATE distribucija SET
            mjesto=:mjesto,
            vrijeme=:vrijeme
            WHERE sifra=:sifra
        ');
        $izraz->execute([
            'mjesto' => $p['mjesto'],
            'vrijeme' => $p['vrijeme'],
            'sifra' => $sifraDistribucija
        ]);

        $izraz = $veza->prepare('
            UPDATE proizvod_distribucija SET
            proizvod=:proizvod,
            distribucija=:distribucija,
            kolicina=:kolicina
            WHERE sifra=:sifra
        ');
        $izraz->execute([
            'proizvod' => $p['proizvod'],
            'distribucija' => $p['distribucija'],
            'kolicina' => $p['kolicina'],
            'sifra' => $sifraDistribucija
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
