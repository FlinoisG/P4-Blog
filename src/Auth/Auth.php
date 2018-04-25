<?php

namespace APP\Auth;

use App\Controller\DefaultController;
use App\Database\mysqlQuery;
use App\Service\GUIDService;

/**
 * Auth class for authentification related functions
 */
class Auth {

    /**
     * Create session if username and password matches in the database
     *
     * @param string $username
     * @param string $password
     * @return void
     */
    public function login($username, $password){
        $mysqlQuery = new mysqlQuery();
        $user = $mysqlQuery->sqlQuery("SELECT username, password FROM users WHERE username='".$username."'");
        $path = __DIR__ . '/../Service/PasswordService.php';
        //require($path);
        if(!function_exists('hash_equals')) {
            function hash_equals($str1, $str2) {
                if(strlen($str1) != strlen($str2)) {
                    return false;
                } else {
                    $res = $str1 ^ $str2;
                    $ret = 0;
                    for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
                    return !$ret;
                }
            }
        }
        if($user != [] && hash_equals($user['0']['password'], crypt($password, $user['0']['password']))) {
            if(!isset($_SESSION)){
                session_start();
            }
            $_SESSION['auth'] = $user['0']['username'];
        } else {
            $DefaultController = new DefaultController();
            die($DefaultController->error(403));
        }
    }

    /**
     * Undocumented function
     *
     * @param string $email
     * @return void
     */
    public function passwordResetLink($email){
        $mysqlQuery = new mysqlQuery();
        $user = $mysqlQuery->sqlQuery("SELECT * FROM users WHERE email='".$email."'");
        if($user != []){
            $GUIDService = new GUIDService;
            $resetToken = $GUIDService->getGUID();
            $resetExpiration = date("Y-m-d H:i:s", strtotime('+24 hours'));
            $mysqlQuery->sqlQuery('UPDATE users SET passwordResetToken = \''.$resetToken.'\', passwordResetExpiration = \''.$resetExpiration.'\' WHERE email=\''.$email.'\'');
            $to      = $_POST['email'];
            $subject = 'le sujet';
            $message = 'Lien : http://gauthier.tuby.com/P4/public/?p=admin.resetPassword&token=' . $resetToken;
            $headers = 'From: webmaster@example.com' . "\r\n" .
            'Reply-To: webmaster@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
            mail($to, $subject, $message, $headers);
            return true;
        } else {
            $title = 'Blog de Jean Forteroche - Connection';
            $header = '';
            $content = "<p>Aucune adresse mail ne correspond.</p>
            <a href=\"?p=admin.connection&forgottenPassword=true\" class=\"btn btn-primary\">Retour</a>";
            die(require('../src/View/EmptyView.php'));
        }
    }

    /**
     * Undocumented function
     *
     * @param string $user
     * @param string $password
     * @return void
     */
    public function resetPassword($user, $password){
        require('../src/Service/PasswordService.php');
        $mysqlQuery = new mysqlQuery();
        $query = 'UPDATE users SET 
            password = \''.password_hash($password, PASSWORD_BCRYPT).'\', 
            passwordResetToken = \'\', 
            passwordResetExpiration = \'\' 
            WHERE username=\''.$user.'\'';
        $mysqlQuery->sqlQuery($query);
    }

}