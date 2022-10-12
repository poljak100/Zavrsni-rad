<?php

class Distribucija
{

    public static function brisanje($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            delete from distribucija where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);
        $izraz->fetchColumn();
    }

    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            select a.mjesto ,a.osoba  ,a.vrijeme ,a.kolicina ,b.ime ,b.prezime , b.oib , b.smjena , b.mjesto_stanovanja ,b.datum_rodenja 
            from distribucija a right join osoba b 
            on a.osoba =b.sifra 
            group by a.mjesto ,a.vrijeme ,a.kolicina ,b.ime ,b.prezime , b.oib 
            order by 4,3
        
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);
        return $izraz->fetch();
    }


    public static function create($p)
    {
        $veza = DB::getInstance();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
        
            insert into 
            distribucija (mjesto,vrijeme,kolicina,osoba)
            values (:mjesto,:vrijeme,:kolicina,:osoba)
        
        ');
        $izraz->execute(
            [
                'mjesto'=>$p['mjesto'],
                'vrijeme' => $p['vrijeme'],
                'kolicina' => $p['kolicina'],
                'osoba' => $p['osoba']
            ]
            
        );
        $veza->commit();

    }



    public static function read()
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
        select a.mjesto ,a.osoba  ,a.vrijeme ,a.kolicina ,b.ime ,b.prezime , b.oib , b.smjena , b.mjesto_stanovanja ,b.datum_rodenja 
        from distribucija a left join osoba b 
        on a.osoba =b.sifra
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }



    public static function update($p)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            update distribucija set
                mjesto=:mjesto,
                vrijeme=:vrijeme,
                kolicina=:kolicina,
                where sifra=:sifra
        
        ');
        $izraz->execute(
            [
                'mjesto'=>$p['mjesto'],
                'vrijeme' =>$p ['vrijeme'],
                'kolicina' => $p['kolicina'],
                'sifra' =>$p ['sifra']
            ]
        );
    }


    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            UPDATE distribucija
            set osoba = NULL
            WHERE osoba = :sifra
        
        ');
        $izraz->execute([
            'sifra' => $sifra
        ]);
        $veza->commit();
    }
}
