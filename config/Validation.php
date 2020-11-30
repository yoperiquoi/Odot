<?php

namespace config;

class Validation
{
    public static function val_pseudo(string &$pseudo, &$dVueEreur)
    {
        if (!isset($pseudo) || $pseudo == "") {
            $dVueEreur[] = "pas de nom";
            $pseudo = "";
            return false;
        }

        if ($pseudo != filter_var($pseudo, FILTER_SANITIZE_STRING)) {
            $dVueEreur[] = "Tentative d'injection de code (attaque sécurité)";
            $pseudo = "";
            return false;
        }

        $expression = '/^[0-9A-Za-z-_.\'"]*$/';
        if (preg_match($expression, $tache) != 1) {
            $dVueEreur[] = "Le pseudo ne peut contenir que des lettres, chiffres et les caractères spéciaux : \" ' - _ .";
            $pseudo = "";
            return false;
        }
        return true;
    }

    public static function val_email(string &$email, &$dVueEreur)
    {
        if (!isset($email) || $email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $dVueEreur[] = "Email invalide";
            $email = "";
            return false;
        }

        $expression = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
        if (preg_match($expression, $tache) != 1) {
            echo "Email invalide";
            $email = "";
            return false;
        }
        return true;
    }

    public static function val_mdp(string &$mdp, &$dVueEreur)
    {
        if (!isset($mdp) || $mdp == "") {
            $dVueEreur[] = "pas de mot de passe";
            $pseudo = "";
            return false;
        }

        if ($mdp != filter_var($mdp, FILTER_SANITIZE_STRING)) {
            $dVueEreur[] = "Tentative d'injection de code (attaque sécurité)";
            $pseudo = "";
            return false;
        }

        $expression = '/^[0-9A-Za-z-_.\'"]*$/';
        if (preg_match($expression, $tache) != 1) {
            $dVueEreur[] = "Le mot de passe ne peut contenir que des lettres, chiffres et les caractères spéciaux : \" ' - _ .";
            $pseudo = "";
            return false;
        }
        return true;
    }

    public static function val_form(string &$pseudo, string &$email, string &$mdp, &$dVueEreur)
    {
        if(!self::val_pseudo($pseudo, $dVueEreur)) return false;
        if(!self::val_email($email, $dVueEreur)) return false;
        if(!self::val_mdp($mdp, $dVueEreur)) return false;
        return true;
    }

    public static function val_liste(string &$liste, &$dataVueErreur)
    {
        if (!isset($liste) || $liste == "") {
            $dataVueErreur['erreurListe'] = "La liste doit contenir un nom";
            return false;
        }

        if ($liste != filter_var($liste, FILTER_SANITIZE_STRING)) {
            $dataVueErreur['erreurListe'] = "Nom de liste invalide. Essayez-en un autre chose";
            return false;
        }

        $expression = '/^[0-9A-Za-z-_.\'"]*$/';
        if (preg_match($expression, $liste) != 1) {
            $dataVueErreur['erreurListe'] = "La liste ne peut contenir que des lettres, chiffres et les caractères spéciaux : \" ' - _ .";
            return false;
        }
        return true;
    }

    public static function val_suppressionListe(string &$tache, &$dataVueErreur)
    {
        if (!isset($tache) || $tache == "") {
            $dataVueErreur['pageErreur'] = "La liste à supprimer n'a pas de nom";
            return false;
        }

        if ($tache != filter_var($tache, FILTER_SANITIZE_STRING)) {
            $dataVueErreur['pageErreur'] = "La liste à supprimer a un nom invalide";
            return false;
        }

        $expression = '/^[0-9A-Za-z-_.\'"]*$/';
        if (preg_match($expression, $tache) != 1) {
            $dataVueErreur['pageErreur'] = "La liste à supprimer a un nom invalide";
            return false;
        }
        return true;
    }

    public static function val_tache(string &$tache, string &$liste, &$dataVueErreur)
    {
        if (!isset($tache) || $tache == "") {
            $dataVueErreur['erreurTache'] = "La tache doit contenir un nom";
            return false;
        }

        if ($tache != filter_var($tache, FILTER_SANITIZE_STRING)) {
            $dataVueErreur['erreurTache'] = "Nom de tache invalide. Essayez-en un autre chose";
            return false;
        }

        $expression = '/^[0-9A-Za-z-_.\'"]*$/';
        if (preg_match($expression, $tache) != 1) {
            $dataVueErreur['erreurTache'] = "La tache ne peut contenir que des lettres, chiffres et les caractères spéciaux : \" ' - _ .";
            return false;
        }

        $expression = '/^[0-9A-Za-z-_.\'"]*$/';
        if (!isset($liste) || $liste == "" || $liste != filter_var($liste, FILTER_SANITIZE_STRING) || preg_match($expression, $liste) != 1) {
            $dataVueErreur['erreurTache'] = "Erreur : la liste dans laquelle ajouter ne semble pas correcte";
            return false;
        }
        return true;
    }

    public static function val_suppressionTache(string &$tache, &$liste, &$dataVueErreur)
    {
        if (!isset($tache) || $tache == "") {
            $dataVueErreur['pageErreur'] = "La liste à supprimer n'a pas de nom";
            return false;
        }

        if ($tache != filter_var($tache, FILTER_SANITIZE_STRING)) {
            $dataVueErreur['pageErreur'] = "La liste à supprimer a un nom invalide";
            return false;
        }

        $expression = '/^[0-9A-Za-z-_.\'"]*$/';
        if (preg_match($expression, $tache) != 1) {
            $dataVueErreur['pageErreur'] = "La liste à supprimer a un nom invalide";
            return false;
        }

        $expression = '/^[0-9A-Za-z-_.\'"]*$/';
        if (!isset($liste) || $liste == "" || $liste != filter_var($liste, FILTER_SANITIZE_STRING) || preg_match($expression, $liste) != 1) {
            $dataVueErreur['pageErreur'] = "Erreur : la liste dans laquelle supprimer ne semble pas correcte";
            return false;
        }
        return true;
    }

}