<?php
/**
 * Codeigniter User Language File
 *
 * @author        Waldir Bertazzi Junior
 * @link            http://waldir.org/
 */

// SUCCESS MESSAGES
$lang['success_logout'] = "Uw sessie is succesvol beindigd";


// ERRORS MESSAGES
$lang['error_invalid_session'] = "Helaas, geen geldige sessie";

/**
 * BEFORE CHANGE error_invalid_login AND error_invalid_password, READ THIS PLEASE:
 *
 * For public sites, you may want to set these both string as the same.
 * The reason is that one can use a bruteforce tool for trying to find valid
 * LOGINS on your site by checking the return message.
 * If both login AND password error messages are the same, they cannot
 * be distinguished.
 */
$lang['error_invalid_login'] = "Gebruikersnaam of wachtwoord onjuist";
$lang['error_invalid_password'] = "Gebruikersnaam of wachtwoord onjuist";

?>