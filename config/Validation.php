<?php

namespace config;

class Validation
{
    public static function val_pseudo(?string &$pseudo, &$dataVueErreur)
    {
        if (!isset($pseudo) || $pseudo == "") {
            $dataVueErreur['erreurNom'] = "pas de nom";
            $pseudo = "";
            return false;
        }

        if ($pseudo != filter_var($pseudo, FILTER_SANITIZE_STRING)) {
            $dataVueErreur['erreurNom'] = "Tentative d'injection de code (attaque sécurité)";
            $pseudo = "";
            return false;
        }

        $expression = '/^(([0-9A-Za-z-_.\'"àáâãäåçèéêëìíîïðòóôõöùúûüýÿ])+[[:space:]]*(\1)*)*$/';
        if (preg_match($expression, $pseudo) != 1) {
            $dataVueErreur['erreurNom'] = "Le pseudo ne peut contenir que des lettres, chiffres (au moins un des deux) et les caractères spéciaux : \" ' - _ .";
            $pseudo = "";
            return false;
        }
        return true;
    }

    public static function val_email(?string &$email, &$dataVueErreur)
    {
        if (!isset($email) || $email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $dataVueErreur['erreurEmail'] = "Email invalide";
            $email = "";
            return false;
        }

        $expressionEmail = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
        if (preg_match($expressionEmail, $email) != 1) {
            $dataVueErreur['erreurEmail'] = "Email invalide";
            $email = "";
            return false;
        }
        return true;
    }

    public static function val_mdp(?string &$mdp, &$dataVueErreur)
    {
        if (!isset($mdp) || $mdp == "") {
            $dataVueErreur['erreurMdp'] = "pas de mot de passe";
            $mdp = "";
            return false;
        }

        if ($mdp != filter_var($mdp, FILTER_SANITIZE_STRING)) {
            $dataVueErreur['erreurMdp'] = "Tentative d'injection de code (attaque sécurité)";
            $mdp = "";
            return false;
        }

        $expression = '/^(([0-9A-Za-z-_.\'"àáâãäåçèéêëìíîïðòóôõöùúûüýÿ])+[[:space:]]*(\1)*)*$/';
        if (preg_match($expression, $mdp) != 1) {
            $dataVueErreur['erreurMdp'] = "Le mot de passe ne peut contenir que des lettres, chiffres (au moins un des deux) et les caractères spéciaux : \" ' - _ .";
            $mdp = "";
            return false;
        }
        return true;
    }

    public static function val_inscription(?string &$pseudo, ?string &$email, ?string &$mdp, &$dataVueErreur)
    {
        if(!self::val_pseudo($pseudo, $dataVueErreur)) return false;
        if(!self::val_email($email, $dataVueErreur)) return false;
        if(!self::val_mdp($mdp, $dataVueErreur)) return false;
        return true;
    }

    public static function val_connection(?string &$email, ?string &$mdp, &$dataVueErreur) {
        if(!self::val_email($email, $dataVueErreur)) return false;
        if(!self::val_mdp($mdp, $dataVueErreur)) return false;
        return true;
    }


    public static function val_liste(?string &$liste, &$dataVueErreur)
    {
        if (!isset($liste) || $liste == "") {
            $dataVueErreur['erreurListe'] = "La liste doit contenir un nom";
            return false;
        }

        if ($liste != filter_var($liste, FILTER_SANITIZE_STRING)) {
            $dataVueErreur['erreurListe'] = "Nom de liste invalide. Essayez-en un autre chose";
            return false;
        }

        $expression = '/^(([0-9A-Za-z-_.\'"àáâãäåçèéêëìíîïðòóôõöùúûüýÿ])+[[:space:]]*(\1)*)*$/';
        if (preg_match($expression, $liste) != 1) {
            $dataVueErreur['erreurListe'] = "La liste ne peut contenir que des lettres, chiffres (au moins un des deux) et les caractères spéciaux : \" ' - _ .";
            return false;
        }
        return true;
    }

    public static function val_suppressionListe(?string &$liste, &$dataPageErreur)
    {
        if (!isset($liste) || $liste == "") {
            $dataPageErreur[] = "La liste à supprimer n'a pas de nom";
            return false;
        }

        if ($liste != filter_var($liste, FILTER_SANITIZE_STRING)) {
            $dataPageErreur[] = "La liste à supprimer a un nom invalide";
            return false;
        }

        $expression = '/^(([0-9A-Za-z-_.\'"àáâãäåçèéêëìíîïðòóôõöùúûüýÿ])+[[:space:]]*(\1)*)*$/';
        if (preg_match($expression, $liste) != 1) {
            $dataPageErreur[] = "La liste à supprimer a un nom invalide";
            return false;
        }
        return true;
    }

    public static function val_tache(?string &$tache, ?string &$liste, &$dataVueErreur, &$dataVueErreurNom)
    {
        if (!isset($tache) || $tache == "") {
            $dataVueErreur['erreurTache'] = "La tache doit contenir un nom";
            $dataVueErreurNom['erreurTache'] = $liste;
            return false;
        }

        if ($tache != filter_var($tache, FILTER_SANITIZE_STRING)) {
            $dataVueErreur['erreurTache'] = "Nom de tache invalide. Essayez-en un autre chose";
            $dataVueErreurNom['erreurTache'] = $liste;
            return false;
        }

        $expression = '/^(([0-9A-Za-z-_.\'"àáâãäåçèéêëìíîïðòóôõöùúûüýÿ])+[[:space:]]*(\1)*)*$/';
        if (preg_match($expression, $tache) != 1) {
            $dataVueErreur['erreurTache'] = "La tache ne peut contenir que des lettres, chiffres (au moins un des deux) et les caractères spéciaux : \" ' - _ .";
            $dataVueErreurNom['erreurTache'] = $liste;
            return false;
        }

        if (!isset($liste) || $liste == "" || $liste != filter_var($liste, FILTER_SANITIZE_STRING) || preg_match($expression, $liste) != 1) {
            $dataVueErreur['erreurTache'] = "Erreur : la liste dans laquelle ajouter ne semble pas correcte";
            $dataVueErreurNom['erreurTache'] = $liste;
            return false;
        }
        return true;
    }

    public static function val_suppressionTache(?string &$tache, &$dataPageErreur)
    {
        if (!isset($tache) || $tache == "") {
            $dataPageErreur[] = "La tâche à supprimer n'a pas de nom";
            return false;
        }

        if ($tache != filter_var($tache, FILTER_SANITIZE_STRING)) {
            $dataPageErreur[] = "La tâche à supprimer a un nom invalide";
            return false;
        }

        $expression = '/^(([0-9A-Za-z-_.\'"àáâãäåçèéêëìíîïðòóôõöùúûüýÿ])+[[:space:]]*(\1)*)*$/';
        if (preg_match($expression, $tache) != 1) {
            $dataPageErreur[] = "La tâche à supprimer a un nom invalide";
            return false;
        }


        return true;
    }

    public static function val_cocheTache(?string &$tache, ?string &$liste, &$dataPageErreur)
    {
        if (!isset($tache) || $tache == "") {
            $dataPageErreur[] = "La tâche à cocher n'a pas de nom";
            return false;
        }

        if ($tache != filter_var($tache, FILTER_SANITIZE_STRING)) {
            $dataPageErreur[] = "La tâche à cocher a un nom invalide";
            return false;
        }

        $expression = '/^(([0-9A-Za-z-_.\'"àáâãäåçèéêëìíîïðòóôõöùúûüýÿ])+[[:space:]]*(\1)*)*$/';
        if (preg_match($expression, $tache) != 1) {
            $dataPageErreur[] = "La tâche à cocher a un nom invalide";
            return false;
        }

        if (!isset($liste) || $liste == "" || $liste != filter_var($liste, FILTER_SANITIZE_STRING) || preg_match($expression, $liste) != 1) {
            $dataVueErreur['erreurTache'] = "Erreur : la liste dans laquelle ajouter ne semble pas correcte";
            $dataVueErreurNom['erreurTache'] = $liste;
            return false;
        }

        return true;
    }

    public static function val_cocheTacheUtilisateur(?string &$tache, ?string &$liste, &$email, &$dataPageErreur) {
        Validation::val_cocheTache($tache, $liste, $dataPageErreur);
        Validation::val_email($email, $dataPageErreur);
    }
}