<?php

include_once("SPSQLite.class.php");

class login extends SPSQLite
{
    var $_user;
    var $_pass;

    // {{{ function login()

    function login($user, $pass)
    {
        $this->_user = $user;
        $this->_pass = md5($pass);
    }

    // }}}

    // {{{ function checkLogin()

    function checkLogin()
    {
        $query = "SELECT * FROM users WHERE login = '$this->_user'";
        $this->query($query);

        if ($this->numRows() == 1) {
            while ($row = $this->fetchArray("assoc")) {
                if (($row['login'] == $this->_user) && ($row['password'] == $this->_pass)) {
                    $this->sessionStart();
                    $_SESSION['auth'] = "ok";
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    // }}}

    // {{{ function register()

    function register($realname, $email)
    {
        $query = "INSERT INTO users (login, password, realname, email) VALUES ('$this->_user', '$this->_pass', '$realname', '$email')";
        $this->query($query);
    }

    // }}}

    // {{{ function updateLogin()

    function updateLogin($pass)
    {
        $this->_pass = md5($pass);

        $query = "UPDATE users SET password = '$this->pass' WHERE login = '$this->user'";
        $this->query($query);
    }

    // }}}

    // {{{ function isEmpty()

    function isEmpty()
    {
        $query = "SELECT * FROM users";
        $this->query($query);

        if ($this->numRows() == 0) {
            return true;
        } else {
            return false;
        }
    }

    // }}}

    // {{{ function isLogged()

    function isLogged()
    {
        $this->sessionStart();
        if ((isset($_SESSION['auth']))  && ($_SESSION['auth'] == "ok")) {
            return true;
        } else {
            return false;
        }
    }

    // }}}

    // {{{ function logOff()

    function logOff()
    {
        $this->sessionStart();
        unset($_SESSION['auth']);
    }

    // }}}

    // {{{ function sessionStart()

    function sessionStart()
    {
        session_start();
    }

    // }}}
}

?>