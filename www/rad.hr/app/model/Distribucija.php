<?php

class Distribucija
{

    public static function delete($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
        
            delete from distribucija where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
        $izraz->fetchColumn();
    }

    public static function readOne($sifra)
    {
        $veza = DB::getInstance();
        $izraz = $veza->prepare('
            select a.mjesto ,a.vrijeme ,a.kolicina ,b.ime ,b.prezime , b.oib 
            from distribucija a inner join osoba b 
            on a.osoba =b.sifra 
            where a.sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);
        return $izraz->fetch(); 
    }



}
