<?php

namespace controleur;

class Validation
{

    static function val_action($action)
    {

        if (!isset($action)) {
            throw new Exception('pas d\'action');
        }
    }

    static function val_pseudo(string &$pseudo, &$dVueEreur)
    {
        if (!isset($pseudo) || $pseudo == "") {
            $dVueEreur[] = "pas de nom";
            $pseudo = "";
        }

        if ($pseudo != filter_var($pseudo, FILTER_SANITIZE_STRING)) {
            $dVueEreur[] = "Tentative d'injection de code (attaque sécurité)";
            $pseudo = "";
        }

        $expression = "([:alnum:]*[-_.]*)*";
        if (!preg_match($expression, $pseudo)) {
            $dVueEreur[] = "Le pseudo ne peut contenir que des lettres, chiffres - _ .";
            $pseudo = "";
        }
    }

    static function val_email(string &$email, &$dVueEreur)
    {
        if (!isset($email) || $email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $dVueEreur[] = "Email invalide";
            $email = "";
        }

        $expression = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
        if (!preg_match($expression, $email)) {
            echo "Email invalide";
            $email = "";
        }
    }

    static function val_mdp(string &$mdp, &$dVueEreur) {
        if (!isset($mdp) || $mdp == "") {
            $dVueEreur[] = "pas de mot de passe";
            $pseudo = "";
        }

        if ($mdp != filter_var($mdp, FILTER_SANITIZE_STRING)) {
            $dVueEreur[] = "Tentative d'injection de code (attaque sécurité)";
            $pseudo = "";
        }

        $expression = "([:alnum:]*[-_.]*)*";
        if (!preg_match($expression, $mdp)) {
            $dVueEreur[] = "Le mot de passe ne peut contenir que des lettres, chiffres - _ .";
            $pseudo = "";
        }
    }

    static function val_form(string &$pseudo, string &$email, string &$mdp, &$dVueEreur)
    {
        self::val_pseudo($pseudo, $dVueEreur);
        self::val_email($email, $dVueEreur);
        self::val_mdp($mdp, $dVueEreur);
    }


}