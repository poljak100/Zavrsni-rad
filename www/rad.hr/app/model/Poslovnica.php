<?php

    class Poslovnica
    {

        public static function brisanje($sifra)
        {
            $veza = DB::getInstance();
            $izraz = $veza->prepare('
        
            delete from poslovnica where sifra=:sifra
        
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
        
            select * from poslovnica where sifra=:sifra
        
        ');
            $izraz->execute([
                'sifra' => $sifra
            ]);
            return $izraz->fetch();
        }


    public static function create($poslovnica)
    {
        $veza = DB::getInstance();

        $izraz = $veza->prepare('
        
            insert into 
            poslovnica(naziv,mjesto,email)
            values (:naziv,:mjesto,:email)
        
        ');
        $izraz->execute($poslovnica);
        return $veza->lastInsertId();
    }


        
        public static function read()
        {
            $veza = DB::getInstance();
            $izraz = $veza->prepare('
        
            select * from poslovnica 
        
        ');
            $izraz->execute();
            return $izraz->fetchAll();
        }

        
        
        public static function update($poslovnica)
        {
            $veza = DB::getInstance();
            $izraz = $veza->prepare('
        
            update poslovnica set
                naziv=:naziv,
                mjesto=:mjesto,
                email=:email
                where sifra=:sifra
        
        ');
            $izraz->execute($poslovnica);
        }

        
        public static function delete($sifra)
        {
            $veza = DB::getInstance();
            $izraz = $veza->prepare('
        
            delete from poslovnica where sifra=:sifra
        
        ');
            $izraz->execute([
                'sifra' => $sifra
            ]);
        }
    }
