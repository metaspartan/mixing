<?php
    date_default_timezone_set("UTC");
    require_once(__DIR__."/config/dev_configs.php");
    //=============================================================================================================\\
    //-------------------------------------- Frontend content delivery --------------------------------------------\\

    function frontendStructure() {
        $structure = array(
            "static"  => array(
                "head"     => __DIR__."/../html/head/head.php",
                "header_0" => __DIR__."/../html/header/header_0.html",
                "header_1" => __DIR__."/../html/header/header_1.html",
                "header_2" => __DIR__."/../html/header/header_2.html",
                "header_3" => __DIR__."/../html/header/header_3.html",
                "footer"   => __DIR__."/../html/footer/footer.php",
                "LSwatch"  => __DIR__."/../html/LSwatcher.php"
            ),
            "dynamic" => array(
                "/"                 => array("show" => array(0, 1, 2, 3), "title" => "Mix Bitcoins with Whisk", "content" => __DIR__."/../html/contents/index.php"),
                "/jsfree"           => array("show" => array(0, 1, 2, 3), "title" => "Mix Bitcoins with Whisk", "content" => __DIR__."/../html/contents/jsfree.php"),
                "/jsfree/1"         => array("show" => array(0, 1, 2, 3), "title" => "Mix Bitcoins with Whisk", "content" => __DIR__."/../html/contents/jsfree/1.php"),
                "/jsfree/2"         => array("show" => array(0, 1, 2, 3), "title" => "Mix Bitcoins with Whisk", "content" => __DIR__."/../html/contents/jsfree/2.php"),
                "/jsfree/3"         => array("show" => array(0, 1, 2, 3), "title" => "Mix Bitcoins with Whisk", "content" => __DIR__."/../html/contents/jsfree/3.php"),
                "/jsfree/4"         => array("show" => array(0, 1, 2, 3), "title" => "Mix Bitcoins with Whisk", "content" => __DIR__."/../html/contents/jsfree/4.php"),
                "/jsfree/5"         => array("show" => array(0, 1, 2, 3), "title" => "Mix Bitcoins with Whisk", "content" => __DIR__."/../html/contents/jsfree/5.php"),
                "/jsfree/6"         => array("show" => array(0, 1, 2, 3), "title" => "Mix Bitcoins with Whisk", "content" => __DIR__."/../html/contents/jsfree/6.php"),
                "/jsfree/7"         => array("show" => array(0, 1, 2, 3), "title" => "Mix Bitcoins with Whisk", "content" => __DIR__."/../html/contents/jsfree/7.php"),
                "/jsfree/8"         => array("show" => array(0, 1, 2, 3), "title" => "Mix Bitcoins with Whisk", "content" => __DIR__."/../html/contents/jsfree/8.php"),
                "/jsfree/9"         => array("show" => array(0, 1, 2, 3), "title" => "Mix Bitcoins with Whisk", "content" => __DIR__."/../html/contents/jsfree/9.php"),
                "/jsfree/10"        => array("show" => array(0, 1, 2, 3), "title" => "Mix Bitcoins with Whisk", "content" => __DIR__."/../html/contents/jsfree/10.php"),
                "/faq"              => array("show" => array(0, 1, 2, 3), "title" => "FAQ",                     "content" => __DIR__."/../html/contents/faq.php"),
                "/fees"             => array("show" => array(0, 1, 2, 3), "title" => "Fees",                    "content" => __DIR__."/../html/contents/fees.php"),
                "/status"           => array("show" => array(0, 1, 2, 3), "title" => "Order status",            "content" => __DIR__."/../html/contents/status.php"),
                "/donation"         => array("show" => array(0, 1, 2, 3), "title" => "Donation",                "content" => __DIR__."/../html/contents/donation.php"),
                "/api/docs"         => array("show" => array(0, 1, 2, 3), "title" => "API documentation",       "content" => __DIR__."/../html/contents/apidocs.php"),
                "/features"         => array("show" => array(0, 1, 2, 3), "title" => "Our features",            "content" => __DIR__."/../html/contents/features.php"),             
                "/signin"           => array("show" => array(0),          "title" => "Sign into account",       "content" => __DIR__."/../html/contents/signin.php"),
                "/signup"           => array("show" => array(0),          "title" => "Registration",            "content" => __DIR__."/../html/contents/signup.php"),
                "/restore"          => array("show" => array(0),          "title" => "Restore access",          "content" => __DIR__."/../html/contents/restore.php"),
                "/verify"           => array("show" => array(1),          "title" => "Verify account",          "content" => __DIR__."/../html/contents/verify.php"),
                "/signature"        => array("show" => array(2),          "title" => "Provide your signature",  "content" => __DIR__."/../html/contents/signature.php"),
                "/profile"          => array("show" => array(3),          "title" => "Profile",                 "content" => __DIR__."/../html/contents/profile.php"),
                "/profile/password" => array("show" => array(3),          "title" => "Manage password",         "content" => __DIR__."/../html/contents/profile/password.php"),
                "/profile/protect"  => array("show" => array(3),          "title" => "Protect account",         "content" => __DIR__."/../html/contents/profile/protect.php"),
                "/profile/deposit"  => array("show" => array(3),          "title" => "Account deposit",         "content" => __DIR__."/../html/contents/profile/deposit.php"),
                "/partner"          => array("show" => array(0, 1, 2, 3), "title" => "Become a partner",        "content" => __DIR__."/../html/contents/partner.php"),
                "/partner/withdraw" => array("show" => array(3),          "title" => "Request a withdraw",      "content" => __DIR__."/../html/contents/partner/withdraw.php"),
                "/stats"            => array("show" => array(3),          "title" => "Mixer statistics",        "content" => __DIR__."/../html/contents/stats.php"),
                "/mixing"           => array("show" => array(3),          "title" => "Mix Bitcoins with Whisk", "content" => __DIR__."/../html/contents/mixing.php"),
                "/403"              => array("show" => array(0, 1, 2, 3), "content" => __DIR__."/../html/errors/403.html", "error" => true),
                "/404"              => array("show" => array(0, 1, 2, 3), "content" => __DIR__."/../html/errors/404.html", "error" => true),
                "/405"              => array("show" => array(0, 1, 2, 3), "content" => __DIR__."/../html/errors/405.html", "error" => true),
                "/429"              => array("show" => array(0, 1, 2, 3), "content" => __DIR__."/../html/errors/429.html", "error" => true),
                "/500"              => array("show" => array(0, 1, 2, 3), "content" => __DIR__."/../html/errors/500.html", "error" => true)
            ),
            "userOrderPage" => array(
                "show" => array(3), 
                "title" => array(
                    "locked" => "The stash is prepared, waiting for payment", 
                    "open" => "Payment received, take away the key"
                )
            )
        );
        return $structure;
    }

    function echoHTML($uri) {
        global  $_LOG_FILE_AUTH;
        $userOrderPage = false;
        $structure = frontendStructure();
        $session   = getAuthSession();
        $status    = $session["status"];
        if ($status == -2) {
            echo file_get_contents(__DIR__."/../html/errors/auth_error.html");
            file_put_contents($_LOG_FILE_AUTH, $session["error"].PHP_EOL, FILE_APPEND);
            exit();
        }
        if ($status == -1) {
            echo file_get_contents(__DIR__."/../html/errors/session_expired_error.html");
            exit();
        }
        if (!isset($structure["dynamic"][$uri])) {
            echo file_get_contents(__DIR__."/../html/errors/404.html");
            exit();
        }
        if (!in_array($status, $structure["dynamic"][$uri]["show"])) {
            echo file_get_contents(__DIR__."/../html/errors/403.html");
            exit();
        }
        if (!isset($structure["dynamic"][$uri]["error"])) {
            include($structure["dynamic"][$uri]["content"]);
            exit();
        } else {
            echo file_get_contents($structure["dynamic"][$uri]["content"]);
        }
    }

    function echoOrderHTML($ID) {
        global  $_LOG_FILE_AUTH;
        $userOrderPage = true;
        $structure = frontendStructure();
        $session = getAuthSession();
        $status = $session["status"];
        if ($status == -2) {
            echo file_get_contents(__DIR__."/../html/errors/auth_error.html");
            file_put_contents($_LOG_FILE_AUTH, $session["error"].PHP_EOL, FILE_APPEND);
            exit();
        }
        if ($status < 3) {
            echo file_get_contents(__DIR__."/../html/errors/404.html");
            exit();
        }

        $login = $session["data"]["login"];
        $data = selectOrderInfo($login, $ID);

        if (!$data["info"]["success"]) {
            echo file_get_contents(__DIR__."/../html/errors/500.html");
            file_put_contents($_LOG_FILE_AUTH, $data["log"].PHP_EOL, FILE_APPEND);
            exit();
        }

        if (!$data["info"]["exists"]) {
            echo file_get_contents(__DIR__."/../html/errors/404.html");
            exit();
        }

        $orderInfo = $data["info"]["order"];
        include(__DIR__."/../html/contents/mixing/userOrder.php");
    }

    function numberFormat($number, $decimals) {
        return rtrim(rtrim(number_format($number, $decimals, ".", ""), "0"), ".");
    }

    //------------------------------------- Backend content permissions -------------------------------------------\\    

    function backendStructure() {
        $structure = array(
            "createUser.php"       => array("permissions" => array(0)),
            "signinUser.php"       => array("permissions" => array(0)),
            "setRestoreCode.php"   => array("permissions" => array(0)),
            "restoreAccess.php"    => array("permissions" => array(0)),
            "verifyUser.php"       => array("permissions" => array(1)),
            "checkSignature.php"   => array("permissions" => array(2)),
            "changePassword.php"   => array("permissions" => array(3)),
            "protectAccount.php"   => array("permissions" => array(3)),
            "depLetter.php"        => array("permissions" => array(3)),
            "invLetter.php"        => array("permissions" => array(3)),
            "registerWithdraw.php" => array("permissions" => array(3)),
            "showStats.php"        => array("permissions" => array(3)),
            "prepareTakeaway.php"  => array("permissions" => array(3)),
            "listTakeaways.php"    => array("permissions" => array(3)),
            "letterTakeaway.php"   => array("permissions" => array(3)),
            "deleteTakeaway.php"   => array("permissions" => array(3))
        );
        return $structure;
    }

    function getPermissionAndSessionData($fullPath) {
        global  $_LOG_FILE_AUTH;
        $shortName = defineShortScriptName($fullPath);
        $session   = getAuthSession();
        $status    = $session["status"];
        $structure = backendStructure();
        if ($status == -2) {
            file_put_contents($_LOG_FILE_AUTH, $session["error"].PHP_EOL, FILE_APPEND);
        }
        if (!in_array($status, $structure[$shortName]["permissions"])) {
            return array("permission" => false);
        }
        $response = array("permission" => true);
        if ($status > 0) {
            $response["data"] = $session["data"];
        }
        return $response;
    }

    function defineShortScriptName($fullPath) {
        $x = explode("/", $fullPath);
        return $x[count($x)-1];
    }

    //------------------------------------------ Managing sessions ------------------------------------------------\\

    function getAuthSession() {
        // List of statuses: 
        // -2 - authorization error (then destroy session and cookie => next requests should come with status 0)
        // -1 - session expired or never existed (then destroy session and cookie => next requests should come with status 0)
        //  0 - not authorized
        //  1 - authorized but not verified 
        //  2 - authorized, verified, 2fa required
        //  3 - authorized, verified, 2fa passed or missing

        global $_SERVERNAME, 
               $_SESSIONS_USERNAME, 
               $_SESSIONS_PASSWORD, 
               $_DB_SESSIONS,
               $_DB_SESSIONS_TABLE_AUTH,               
               $_USERS_USERNAME, 
               $_USERS_PASSWORD, 
               $_DB_USERS,
               $_DB_USERS_TABLE_ACCOUNTS,
               $_DB_USERS_TABLE_TWOFACTOR,
               $_LOG_FILE_AUTH;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        if (!isset($_COOKIE["auth"])) {
            return array("status" => 0);
        }
        $id = $_COOKIE["auth"];
        $sessionConn = mysqli_connect($_SERVERNAME, $_SESSIONS_USERNAME, $_SESSIONS_PASSWORD, $_DB_SESSIONS);
        if (!$sessionConn) {
            destroyAuthSession($id);
            $message = "{$ip} - {$date} - [error] [0] - getAuthSession: No connection to sessions database. Session ID: {$id}.";
            return array("status" => -2, "error" => $message);
        }
        $stmt = mysqli_prepare($sessionConn, "SELECT login, 
                                                     two_factor 
                                              FROM {$_DB_SESSIONS_TABLE_AUTH} 
                                              WHERE id=?");
        if (!$stmt) {
            $error = mysqli_error($sessionConn);
            mysqli_close($sessionConn);
            destroyAuthSession($id);
            $message = "{$ip} - {$date} - [error] [1] - getAuthSession: {$error}. Session ID: {$id}.";
            return array("status" => -2, "error" => $message);
        }
        mysqli_stmt_bind_param($stmt, "s", $id);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($sessionConn);
            mysqli_close($sessionConn);
            destroyAuthSession($id);
            $message = "{$ip} - {$date} - [error] [2] - getAuthSession: {$error}. Session ID: {$id}.";
            return array("status" => -2, "error" => $message);
        }
        mysqli_stmt_bind_result($stmt, $login, $twoFactorSI);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if (!$login) {       
            mysqli_close($sessionConn);
            //destroyAuthSession($id); nothing to destroy here, just kill the cookie
            setcookie("auth", $id, time()-3600*48, "/", "bitwhisk.io", true, true);
            $message = "{$ip} - {$date} - [warning] - getAuthSession: Invalid or expired client cookie, no corresponding session found. Cookie ID: {$id}.";
            file_put_contents($_LOG_FILE_AUTH, $message.PHP_EOL, FILE_APPEND);
            return array("status" => -1);
        }

        $time = time();
        $stmt = mysqli_prepare($sessionConn, "UPDATE {$_DB_SESSIONS_TABLE_AUTH} 
                                              SET last_visit='{$time}' 
                                              WHERE id=?");
        mysqli_stmt_bind_param($stmt, "s", $id);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($sessionConn);
            $message = "{$ip} - {$date} - [error] [3] - getAuthSession: Haven't updated last_visit session field. {$error}. Session ID: {$id}.";
            file_put_contents($_LOG_FILE_AUTH, $message.PHP_EOL, FILE_APPEND);
        }
        mysqli_stmt_close($stmt);
        mysqli_close($sessionConn);

        $usersConn = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
        if (!$usersConn) {
            destroyAuthSession($id);
            $message = "{$ip} - {$date} - [error] [4] - getAuthSession: No connection to users database. Session ID: {$id}.";
            return array("status" => -2, "error" => $message);
        }

        $stmt = mysqli_prepare($usersConn, "SELECT  email,
                                                    code,
                                                    max_amount,
                                                    dep_balance,
                                                    dep_address,
                                                    dep_stamp,
                                                    inv_balance,
                                                    inv_address,
                                                    inv_stamp,
                                                    reg_time,
                                                    last_login,
                                                    verified, 
                                                    two_factor,
                                                    sign_address 
                                            FROM {$_DB_USERS_TABLE_ACCOUNTS} 
                                            WHERE login=?");
        if (!$stmt) {
            $error = mysqli_error($usersConn);
            mysqli_close($usersConn);
            destroyAuthSession($id);
            $message = "{$ip} - {$date} - [error] [5] - getAuthSession: {$error}. Session ID: {$id}.";
            return array("status" => -2, "error" => $message);
        }
        mysqli_stmt_bind_param($stmt, "s", $login);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($usersConn);
            mysqli_close($usersConn);
            destroyAuthSession($id);
            $message = "{$ip} - {$date} - [error] [6] - getAuthSession: {$error}. Session ID: {$id}.";
            return array("status" => -2, "error" => $message);
        }
        mysqli_stmt_bind_result($stmt,  $email,
                                        $code,
                                        $maxAmount,
                                        $depBalance,
                                        $depAddress,
                                        $depStamp,
                                        $invBalance,
                                        $invAddress,
                                        $invStamp,
                                        $regTime,
                                        $lastLogin,
                                        $verified, 
                                        $twoFactorUI,
                                        $signAddress);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        
        if (!$verified) {
            // wtf? how come session was created?
            mysqli_close($usersConn);
            destroyAuthSession($id);
            $message = "{$ip} - {$date} - [error] [7] - getAuthSession: Could not find user with session login. Session ID: {$id}.";
            return array("status" => -2, "error" => $message);
        }

        $userData = array(
            "login"       => $login,
            "email"       => $email,
            "code"        => $code,
            "maxAmount"   => $maxAmount,
            "depBalance"  => $depBalance,
            "depAddress"  => $depAddress,
            "depStamp"    => $depStamp,
            "invBalance"  => $invBalance,
            "invAddress"  => $invAddress,
            "invStamp"    => $invStamp,
            "regTime"     => $regTime,
            "lastLogin"   => $lastLogin,
            "verified"    => $verified,  
            "twoFactorUI" => $twoFactorUI,
            "twoFactorSI" => $twoFactorSI            
        );
        if ($verified === "no") {
            return array("status" => 1, "data" => $userData);
        }
        if ($twoFactorSI === "required") {
            $userData["signAddress"] = $signAddress;
            $stmt = mysqli_prepare($usersConn, "SELECT check_text
                                                FROM {$_DB_USERS_TABLE_TWOFACTOR} 
                                                WHERE login=?");
            if (!$stmt) {
                $error = mysqli_error($usersConn);
                mysqli_close($usersConn);
                destroyAuthSession($id);
                $message = "{$ip} - {$date} - [error] [8] - getAuthSession: {$error}. Session ID: {$id}.";
                return array("status" => -2, "error" => $message);
            }
            mysqli_stmt_bind_param($stmt, "s", $login);
            if (!mysqli_stmt_execute($stmt)) {
                $error = mysqli_error($usersConn);
                mysqli_close($usersConn);
                destroyAuthSession($id);
                $message = "{$ip} - {$date} - [error] [9] - getAuthSession: {$error}. Session ID: {$id}.";
                return array("status" => -2, "error" => $message);
            }
            $checkString = false;
            mysqli_stmt_bind_result($stmt, $checkString);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            if (!$checkString) {
                $error = mysqli_error($usersConn);
                mysqli_close($usersConn);
                destroyAuthSession($id);
                $message = "{$ip} - {$date} - [error] [10] - getAuthSession: {$error}. Session ID: {$id}.";
                return array("status" => -2, "error" => $message);
            }
            $userData["checkString"] = $checkString;
            mysqli_close($usersConn);
            return array("status" => 2, "data" => $userData);
        }
        mysqli_close($usersConn);
        return array("status" => 3, "data" => $userData);        
    }

    function destroyAuthSession($id) {
        global $_SERVERNAME,
               $_SESSIONS_USERNAME,
               $_SESSIONS_PASSWORD,
               $_DB_SESSIONS,
               $_DB_SESSIONS_TABLE_AUTH,
               $_LOG_FILE_AUTH;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        setcookie("auth", $id, time()-3600*48, "/", "bitwhisk.io", true, true);

        $connSess = mysqli_connect($_SERVERNAME, $_SESSIONS_USERNAME, $_SESSIONS_PASSWORD, $_DB_SESSIONS);
        if (!$connSess) {
            $message = "{$ip} - {$date} - [error] [0] - destroyAuthSession: No connection to sessions database. Session ID: {$id}.";
            file_put_contents($_LOG_FILE_AUTH, $message.PHP_EOL, FILE_APPEND);
            return false;
        }
        $stmt = mysqli_prepare($connSess, " DELETE FROM {$_DB_SESSIONS_TABLE_AUTH} 
                                            WHERE BINARY id=?");
        if (!$stmt) {
            $error = mysqli_error($connSess);
            mysqli_close($connSess);
            $message = "{$ip} - {$date} - [error] [1] - destroyAuthSession: {$error}. Session ID: {$id}.";
            file_put_contents($_LOG_FILE_AUTH, $message.PHP_EOL, FILE_APPEND);
            return false;
        }

        mysqli_stmt_bind_param($stmt, "s", $id);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connSess);
            mysqli_stmt_close($stmt);
            mysqli_close($connSess);
            $message = "{$ip} - {$date} - [error] [2] - destroyAuthSession: {$error}. Session ID: {$id}.";
            file_put_contents($_LOG_FILE_AUTH, $message.PHP_EOL, FILE_APPEND);
            return false;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($connSess);
        $message = "{$ip} - {$date} - [notice] - destroyAuthSession: Successfully destroyed session with ID {$id}.";
        file_put_contents($_LOG_FILE_AUTH, $message.PHP_EOL, FILE_APPEND);
        return true;
    }

    function totalDestroyAuthSession($id) {
        global $_SERVERNAME,
               $_SESSIONS_USERNAME,
               $_SESSIONS_PASSWORD,
               $_DB_SESSIONS,
               $_DB_SESSIONS_TABLE_AUTH,
               $_LOG_FILE_AUTH;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        setcookie("auth", $id, time()-3600*48, "/", "bitwhisk.io", true, true);

        $connSess = mysqli_connect($_SERVERNAME, $_SESSIONS_USERNAME, $_SESSIONS_PASSWORD, $_DB_SESSIONS);
        if (!$connSess) {
            $message = "{$ip} - {$date} - [error] [0] - totalDestroyAuthSession: No connection to sessions database. Session ID: {$id}.";
            file_put_contents($_LOG_FILE_AUTH, $message.PHP_EOL, FILE_APPEND);
            return false;
        }
        $stmt = mysqli_prepare($connSess, " SELECT login FROM {$_DB_SESSIONS_TABLE_AUTH} 
                                            WHERE BINARY id=?");
        if (!$stmt) {
            $error = mysqli_error($connSess);
            mysqli_close($connSess);
            $message = "{$ip} - {$date} [error] [1] - totalDestroyAuthSession: {$error}. Session ID: {$id}.";
            file_put_contents($_LOG_FILE_AUTH, $message.PHP_EOL, FILE_APPEND);
            return false;
        }
        mysqli_stmt_bind_param($stmt, "s", $id);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connSess);
            mysqli_stmt_close($stmt);
            mysqli_close($connSess);
            $message = "{$ip} - {$date} - [error] [2] - totalDestroyAuthSession: {$error}. Session ID: {$id}.";
            file_put_contents($_LOG_FILE_AUTH, $message.PHP_EOL, FILE_APPEND);
            return false;
        }
        $login = false;
        mysqli_stmt_bind_result($stmt, $login);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if (!$login) {
            mysqli_close($connSess);
            return false;
        }

        $stmt = mysqli_prepare($connSess, " DELETE FROM {$_DB_SESSIONS_TABLE_AUTH} 
                                            WHERE BINARY login=?");
        if (!$stmt) {
            $error = mysqli_error($connSess);
            mysqli_close($connSess);
            $message = "{$ip} - {$date} - [error] [3] - totalDestroyAuthSession: {$error}. Session ID: {$id}; Login: {$login}.";
            file_put_contents($_LOG_FILE_AUTH, $message.PHP_EOL, FILE_APPEND);
            return false;
        }
        mysqli_stmt_bind_param($stmt, "s", $login);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connSess);
            mysqli_stmt_close($stmt);
            mysqli_close($connSess);
            $message = "{$ip} - {$date} - [error] [4] - totalDestroyAuthSession: {$error}. Session ID: {$id}; Login: {$login}.";
            file_put_contents($_LOG_FILE_AUTH, $message.PHP_EOL, FILE_APPEND);
            return false;
        }
        mysqli_stmt_close($stmt);
        mysqli_close($connSess);
        $message = "{$ip} - {$date} - [notice] - totalDestroyAuthSession: Successfully destroyed all sessions for login {$login}.";
        file_put_contents($_LOG_FILE_AUTH, $message.PHP_EOL, FILE_APPEND);
        return true;
    }

    function startCaptchaSession($uri) {
        global $_SERVERNAME,
               $_SESSIONS_USERNAME,
               $_SESSIONS_PASSWORD,
               $_DB_SESSIONS,
               $_DB_SESSIONS_TABLE_CAPTCHA;

        $conn = mysqli_connect($_SERVERNAME, $_SESSIONS_USERNAME, $_SESSIONS_PASSWORD, $_DB_SESSIONS);
        $captcha = generateCaptcha();
        $time = time();
        if (!isset($_COOKIE["captcha"])) {
            $id = generateSessionID($conn, $_DB_SESSIONS_TABLE_CAPTCHA);            
            mysqli_query($conn, "INSERT INTO {$_DB_SESSIONS_TABLE_CAPTCHA} (id, 
                                                                            start_time, 
                                                                            captcha_{$uri}) VALUES 
                                                                           ('{$id}', 
                                                                            '{$time}', 
                                                                            '{$captcha}')");
            mysqli_close($conn);
            setcookie("captcha", $id, 0, "/auth", "bitwhisk.io", true, true);
        } else {
            $id = preg_replace('/[^a-zA-Z0-9]/', '', $_COOKIE["captcha"]);      
            $stmt = mysqli_prepare($conn, "INSERT INTO {$_DB_SESSIONS_TABLE_CAPTCHA} (id, 
                                                                                      start_time,
                                                                                      captcha_{$uri}) VALUES 
                                                                                      (?, ?, ?) 
                                                                                      ON DUPLICATE KEY 
                                                                                      UPDATE captcha_{$uri}='{$captcha}'");

            mysqli_stmt_bind_param($stmt, "sis", $id, $time, $captcha);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);            
        }
        return $captcha;
    }

    function generateSessionID($conn, $table) {
        global  $_MIN_LENGTH_SESS_ID,
                $_MAX_LENGTH_SESS_ID;

        $alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $length = random_int($_MIN_LENGTH_SESS_ID, $_MAX_LENGTH_SESS_ID);
        $isUsed = true;
        while ($isUsed) {
            $id = "";
            for ($i = 0; $i < $length-1; $i ++) {
                $id .= $alphabet[random_int(0, strlen($alphabet)-1)];
            }
            $isUsed = checkUniqueness($conn, $table, "id", $id);
        }
        return $id;
    }

    function generateCaptcha() {
        $alphabet = "123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $captcha = "";
        for ($i = 0; $i < 6; $i ++) {
            $captcha .= $alphabet[random_int(0, strlen($alphabet)-1)];
        }
        return $captcha;
    }

    function cleanSessions() {
        global $_SERVERNAME, 
               $_SESSIONS_USERNAME, 
               $_SESSIONS_PASSWORD, 
               $_DB_SESSIONS,
               $_DB_SESSIONS_TABLE_AUTH,
               $_DB_SESSIONS_TABLE_CAPTCHA;

        $date = date("j F Y, H:i:s", time()+10800);

        $connSess = mysqli_connect($_SERVERNAME, $_SESSIONS_USERNAME, $_SESSIONS_PASSWORD, $_DB_SESSIONS);
        if (!$connSess) {
            $error = mysqli_connect_error();
            echo "{$date} - [error] [0] - cleanSessions:  {$error}.";
            return;
        }

        $hourAgo = time() - 3600;
        $query = "DELETE FROM {$_DB_SESSIONS_TABLE_CAPTCHA}
                  WHERE start_time<'{$hourAgo}'";
        $check = mysqli_query($connSess, $query);
        if (!$connSess) {
            $error = mysqli_error($connSess);
            mysqli_close($connSess);
            echo "{$date} - [error] [1] - cleanSessions:  {$error}.";
            return;
        }

        $diemAgo = time() - 24*60*60;
        $monthAgo = time() - 31*24*60*60;
        $query = "DELETE FROM {$_DB_SESSIONS_TABLE_AUTH}
                  WHERE (eternal='no' AND last_visit<'{$diemAgo}') 
                  OR (eternal='yes' AND start_time<'{$monthAgo}' AND last_visit<'{$diemAgo}')";

        $check = mysqli_query($connSess, $query);
        if (!$connSess) {
            $error = mysqli_error($connSess);
            mysqli_close($connSess);
            echo "{$date} - [error] [2] - cleanSessions:  {$error}.";
            return;
        }
    }

    //=============================================================================================================\\
    //----------------------------------------- Authorization work ------------------------------------------------\\

    function createUser($login, $email, $password) {
        global $_SERVERNAME,
               $_SESSIONS_USERNAME,
               $_SESSIONS_PASSWORD,
               $_DB_SESSIONS,
               $_DB_SESSIONS_TABLE_AUTH,
               $_USERS_USERNAME,
               $_USERS_PASSWORD,
               $_DB_USERS,
               $_DB_USERS_TABLE_ACCOUNTS,
               $_DB_USERS_TABLE_VERIF,
               $_TESTNET;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        $connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
        $connSess  = mysqli_connect($_SERVERNAME, $_SESSIONS_USERNAME, $_SESSIONS_PASSWORD, $_DB_SESSIONS);

        if (!$connUsers or !$connSess) {
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [0] - createUser: No connection to sessions or users database.");
        }        

        // start user transaction
        mysqli_autocommit($connUsers, false);
        $query = "INSERT INTO {$_DB_USERS_TABLE_ACCOUNTS} (login, 
                                                           password, 
                                                           email, 
                                                           dep_balance,
                                                           inv_balance,
                                                           reg_time, 
                                                           last_login, 
                                                           verified,
                                                           two_factor,
                                                           dummy_orders,
                                                           ok_orders) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";        
        $stmt  = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            mysqli_rollback($connUsers);
            mysqli_close($connUsers);
            mysqli_close($connSess);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [1] - createUser: {$error}.");
        }
        $stamp = time();
        $hash  = password_hash($password, PASSWORD_BCRYPT);
        $no    = "no";
        $zero  = 0;
        
        mysqli_stmt_bind_param($stmt, "sssiiiissii", $login, $hash, $email, $zero, $zero, $stamp, $stamp, $no, $no, $zero, $zero);

        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_rollback($connUsers);
            mysqli_close($connUsers);
            mysqli_close($connSess);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [2] - createUser: {$error}.");
        }
        mysqli_stmt_close($stmt);

        $query = "INSERT INTO {$_DB_USERS_TABLE_VERIF} (login, verification_code) 
                  VALUES (?, ?)";
        $stmt  = mysqli_prepare($connUsers, $query);
        $vcode = generateVerificationCode();        
        mysqli_stmt_bind_param($stmt, "ss", $login, $vcode);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_rollback($connUsers);            
            mysqli_close($connUsers);
            mysqli_close($connSess);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [3] - createUser: {$error}.");
        }
        mysqli_stmt_close($stmt);
        
        // start session transaction
        mysqli_autocommit($connSess, false);
        $query = "INSERT INTO {$_DB_SESSIONS_TABLE_AUTH} 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connSess, $query);
        $id = generateSessionID($connSess, $_DB_SESSIONS_TABLE_AUTH);
        $missing = "missing";
        mysqli_stmt_bind_param($stmt, "sssiis", $id, $login, $no, $stamp, $stamp, $missing);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_rollback($connUsers);
            mysqli_rollback($connSess);
            mysqli_close($connUsers);         
            mysqli_close($connSess);            
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [4] - createUser: {$error}.");
        }
        mysqli_stmt_close($stmt);
        mysqli_commit($connUsers);
        mysqli_commit($connSess);        
        mysqli_close($connSess);
        mysqli_close($connUsers);

        setcookie("auth", $id, 0, "/", "bitwhisk.io", true, true);

        if (!$_TESTNET) {
            $to        = $email;
            $subject   = "BitWhisk signup";
            $emailBody = "Congratulations,\n\nyou have been successfully signed up for BitWhisk Bitcoin mixer. Your verification code is\n\n{$vcode}\n\nTo complete the registration put this code into the form located by the address:\n\n(clearnet) https://bitwhisk.io/verify\n(Tor-mirror) bitwhiskv7myl5d2.onion/verify\n\nBest regards,\nBitWhisk.io team";
            $headers   = "From: contact@bitwhisk.io";
            $check     = mail($to, $subject, $emailBody, $headers);
        } else {
            $check = true;
        }
        $response = array("echo" => array("success" => true));
        $response["log"] = $check ? "{$ip} - {$date} - [notice] - createUser: Successfully created user '{$login}', session ID: {$id}. Letter passed to MTA." : "{$ip} - {$date} - [warning] - createUser: Successfully created user '{$login}', session ID: {$id}. Letter not passed to MTA!";
        return $response;
    }

    function signinUser($loginOrMail, $password, $remember) {
        global $_SERVERNAME,
               $_SESSIONS_USERNAME,
               $_SESSIONS_PASSWORD,
               $_DB_SESSIONS,
               $_DB_SESSIONS_TABLE_AUTH,
               $_USERS_USERNAME,
               $_USERS_PASSWORD,
               $_DB_USERS,
               $_DB_USERS_TABLE_ACCOUNTS,
               $_DB_USERS_TABLE_TWOFACTOR;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        $connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
        $connSess  = mysqli_connect($_SERVERNAME, $_SESSIONS_USERNAME, $_SESSIONS_PASSWORD, $_DB_SESSIONS);

        if (!$connUsers or !$connSess) {
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [0] - signinUser: No connection to sessions or users database.");
        }

        $query = "SELECT login,
                         password,
                         code,
                         verified,
                         two_factor
                  FROM {$_DB_USERS_TABLE_ACCOUNTS}
                  WHERE login=? or email=?";
        $stmt = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            mysqli_close($connSess);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [1] - signinUser: {$error}.");
        }
        $login       = false;
        $bcode       = false;
        $passHash    = false;
        $verified    = false;
        $twoFactorUI = false;
        mysqli_stmt_bind_param($stmt, "ss", $loginOrMail, $loginOrMail);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            mysqli_close($connSess);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [2] - signinUser: {$error}.");
        }
        mysqli_stmt_bind_result($stmt, $login, $passHash, $bcode, $verified, $twoFactorUI);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if (!$login) {
            mysqli_close($connUsers);
            mysqli_close($connSess);
            return array("echo" => array("success" => false, "reason" => "wrongData"));
        }

        if (!password_verify($password, $passHash)) {
            mysqli_close($connUsers);
            mysqli_close($connSess);
            return array("echo" => array("success" => false, "reason" => "wrongData"));
        }        

        mysqli_autocommit($connUsers, false);
        $stamp = time();
        $query = "UPDATE {$_DB_USERS_TABLE_ACCOUNTS} 
                  SET last_login={$stamp} 
                  WHERE login=?";
        $stmt = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            mysqli_rollback($connUsers);
            mysqli_close($connUsers);
            mysqli_close($connSess);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [3] - signinUser: {$error}.");
        }
        mysqli_stmt_bind_param($stmt, "s", $login);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_rollback($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            mysqli_close($connSess);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [4] - signinUser: {$error}.");
        }
        mysqli_stmt_close($stmt);

        if ($twoFactorUI == "yes") {
            $query = "INSERT INTO {$_DB_USERS_TABLE_TWOFACTOR} 
                      VALUES (?, ?, ?)
                      ON DUPLICATE KEY
                      UPDATE start_time=?, check_text=?";
            $stmt = mysqli_prepare($connUsers, $query);
            if (!$stmt) {
                $error = mysqli_error($connUsers);
                mysqli_rollback($connUsers);
                mysqli_close($connUsers);
                mysqli_close($connSess);
                return array("echo" => array("success" => false, "reason" => "internal"),
                             "log"  => "{$ip} - {$date} - [error] [5] - signinUser: {$error}.");
            }
            $textToSign = generateSignText();
            mysqli_stmt_bind_param($stmt, "sisis", $login, $stamp, $textToSign, $stamp, $textToSign);
            if (!mysqli_stmt_execute($stmt)) {
                $error = mysqli_error($connUsers);
                mysqli_rollback($connUsers);
                mysqli_stmt_close($stmt);
                mysqli_close($connUsers);
                mysqli_close($connSess);
                return array("echo" => array("success" => false, "reason" => "internal"),
                             "log"  => "{$ip} - {$date} - [error] [6] - signinUser: {$error}.");
            }
            mysqli_stmt_close($stmt);
        }

        mysqli_autocommit($connSess, false);
        $query = "INSERT INTO {$_DB_SESSIONS_TABLE_AUTH} 
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connSess, $query);
        $id = generateSessionID($connSess, $_DB_SESSIONS_TABLE_AUTH);
        $eternal = $remember ? "yes" : "no";
        $twoFactorSI = $twoFactorUI === "no" ? "missing" : "required";
        mysqli_stmt_bind_param($stmt, "sssiis", $id, $login, $eternal, $stamp, $stamp, $twoFactorSI);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_rollback($connUsers);
            mysqli_close($connUsers);
            mysqli_rollback($connSess);            
            mysqli_close($connSess);            
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [7] - signinUser: {$error}.");
        }
        mysqli_stmt_close($stmt);
        mysqli_commit($connUsers);
        mysqli_commit($connSess);        
        mysqli_close($connSess);
        mysqli_close($connUsers);

        $expire = $remember ? $stamp + 30*24*60*60 : 0;
        setcookie("auth", $id, $expire, "/", "bitwhisk.io", true, true);
        if ($verified == "no") {
            return array("echo" => array("success" => true, "nextStep" => "/verify", "newStatus" => 1),
                         "log" => "{$ip} - {$date} - [notice] - signinUser: Successfully signed in user '{$login}'.");
        }
        if ($twoFactorUI == "yes") {
            return array("echo" => array("success" => true, "nextStep" => "/signature", "newStatus" => 2, "bcode" => $bcode),
                         "log" => "{$ip} - {$date} - [notice] - signinUser: Successfully signed in user '{$login}'.");
        }
        return array("echo" => array("success" => true, "nextStep" => "/profile", "newStatus" => 3, "bcode" => $bcode),
                     "log" => "{$ip} - {$date} - [notice] - signinUser: Successfully signed in user '{$login}'.");
    }

    function verifyUser($login, $vcodePost, $bcode) {
        global  $_RPC_USER, 
                $_RPC_PASSWORD,
                $_SERVERNAME,
                $_USERS_USERNAME,
                $_USERS_PASSWORD,
                $_DB_USERS,
                $_DB_USERS_TABLE_ACCOUNTS,
                $_DB_USERS_TABLE_VERIF,
                $_MIXER_USERNAME,
                $_MIXER_PASSWORD,
                $_DB_MIXER,
                $_DB_MIXER_TABLE_CODES,
                $_DB_MIXER_TABLE_U_ADDRESSES,
                $_DB_MIXER_TABLE_I_ADDRESSES,
                $_TESTNET;

        $date = date("j F Y, H:i:s", time()+10800);

        $ip   = $_SERVER['REMOTE_ADDR'];

        $connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
        $connMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);

        if (!$connUsers or !$connMixer) {
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [0] - verifyUser: No connection to sessions or mixer database.");
        }

        $query = "SELECT verification_code
                  FROM {$_DB_USERS_TABLE_VERIF}
                  WHERE login=?";
        $stmt = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [1] - verifyUser: {$error}.");
        }
        $vcode = false;
        mysqli_stmt_bind_param($stmt, "s", $login);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [2] - verifyUser: {$error}.");
        }
        mysqli_stmt_bind_result($stmt, $vcode);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        if (!$vcode) {
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [3] - verifyUser: What the hell, where is verification code?");
        }
        if ($vcode !== $vcodePost) {
            mysqli_close($connUsers);
            mysqli_close($connMixer);
             return array("echo" => array("success" => false, "reason" => "wrongVCode"));
        }

        if (!$bcode) {
            require_once(__DIR__."/mainLibrary.php");
            $bcode = generateCode($connMixer);
        }

        mysqli_autocommit($connMixer, false);
        $query = "INSERT INTO {$_DB_MIXER_TABLE_CODES}
                  VALUES (?, ?, ?)
                  ON DUPLICATE KEY 
                  UPDATE accounted='yes'";
        $stmt = mysqli_prepare($connMixer, $query);
        if (!$stmt) {
            $error = mysqli_error($connMixer);
            mysqli_rollback($connMixer);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [4] - verifyUser: {$error}");
        }
        $zero = 0;
        $yes  = "yes";
        mysqli_stmt_bind_param($stmt, "sis", $bcode, $zero, $yes);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connMixer);
            mysqli_rollback($connMixer);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [5] - verifyUser: {$error}");
        }
        mysqli_stmt_close($stmt);

        $bitcoinUsers  = new Bitcoin_users($_RPC_USER, $_RPC_PASSWORD);
        $bitcoinInvest = new Bitcoin_invest($_RPC_USER, $_RPC_PASSWORD);
        if (!$bitcoinUsers or !$bitcoinInvest) {
            mysqli_rollback($connMixer);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [6] - verifyUser: Couldn't connect to bitcoind.");
        }

        $depAddress = $bitcoinUsers  -> getnewaddress();
        $invAddress = $bitcoinInvest -> getnewaddress();

        if (!$depAddress or !$invAddress) {
            $error = $bitcoinUsers -> error;
            $error .= $bitcoinInvest -> error;
            mysqli_rollback($connMixer);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [7] - verifyUser: Couldn't generate bitcoin addresses: {$error}.");
        }

        $bcodeSemicolon = $bcode.";";
        $query = "INSERT INTO {$_DB_MIXER_TABLE_U_ADDRESSES}
                  VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($connMixer, $query);
        if (!$stmt) {
            $error = mysqli_error($connMixer);
            mysqli_rollback($connMixer);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [8] - verifyUser: {$error}");
        }
        mysqli_stmt_bind_param($stmt, "sss", $depAddress, $bcodeSemicolon, $yes);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connMixer);
            mysqli_rollback($connMixer);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [9] - verifyUser: {$error}");
        }
        mysqli_stmt_close($stmt);

        $query = "INSERT INTO {$_DB_MIXER_TABLE_I_ADDRESSES}
                  VALUES (?, ?)";
        $stmt = mysqli_prepare($connMixer, $query);
        if (!$stmt) {
            $error = mysqli_error($connMixer);
            mysqli_rollback($connMixer);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [10] - verifyUser: {$error}");
        }
        mysqli_stmt_bind_param($stmt, "ss", $invAddress, $bcodeSemicolon);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connMixer);
            mysqli_rollback($connMixer);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [11] - verifyUser: {$error}");
        }
        mysqli_stmt_close($stmt);

        $maxInfo = defineUserMaximum($bcode);
        if (!$maxInfo["success"]) {
            $error = $maxInfo["log"];
            mysqli_rollback($connMixer);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [12] - verifyUser: {$error}");
        }
        $maxAmount = round($maxInfo["result"], 8);

        $stamp = time();
        mysqli_autocommit($connUsers, false);
        $query = "UPDATE {$_DB_USERS_TABLE_ACCOUNTS} 
                  SET   verified='yes', 
                        code='{$bcode}',
                        max_amount='{$maxAmount}',
                        dep_address = '{$depAddress}', 
                        dep_stamp = '{$stamp}',
                        inv_address = '{$invAddress}',
                        inv_stamp='{$stamp}'
                  WHERE login=?";
        $stmt = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            mysqli_rollback($connUsers);
            mysqli_rollback($connMixer);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [13] - verifyUser: {$error}");
        }
        mysqli_stmt_bind_param($stmt, "s", $login);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_rollback($connUsers);
            mysqli_rollback($connMixer);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [14] - verifyUser: {$error}");
        }
        mysqli_stmt_close($stmt);

        $query = "DELETE FROM {$_DB_USERS_TABLE_VERIF} 
                  WHERE login=?";
        $stmt = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            mysqli_rollback($connUsers);
            mysqli_rollback($connMixer);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [15] - verifyUser: {$error}");
        }
        mysqli_stmt_bind_param($stmt, "s", $login);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_rollback($connUsers);
            mysqli_rollback($connMixer);
            mysqli_stmt_close($stmt);     
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [16] - verifyUser: {$error}");
        }
        mysqli_stmt_close($stmt);
        mysqli_commit($connMixer);
        mysqli_commit($connUsers);
        mysqli_close($connMixer);
        mysqli_close($connUsers);
        return array("echo" => array("success" => true, "bcode" => $bcode),
                     "log" => "{$ip} - {$date} - [notice] - verifyUser: Successfully verified user '{$login}'.");
    }

    function setRestoreCode($loginOrMail) {
        global $_SERVERNAME,
               $_USERS_USERNAME,
               $_USERS_PASSWORD,
               $_DB_USERS,
               $_DB_USERS_TABLE_ACCOUNTS,
               $_DB_USERS_TABLE_RESTORE,
               $_TESTNET,
               $_RCODE_ACTIVE_PERIOD;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        $connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);

        if (!$connUsers) {
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [0] - setRestoreCode: No connection to users database.");
        }

        $query = "SELECT login, email 
                  FROM {$_DB_USERS_TABLE_ACCOUNTS} 
                  WHERE login=? or email=?";
        $stmt = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [1] - setRestoreCode: {$error}.");
        }
        mysqli_stmt_bind_param($stmt, "ss", $loginOrMail, $loginOrMail);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [2] - setRestoreCode: {$error}.");
        }
        $login = false;
        mysqli_stmt_bind_result($stmt, $login, $email);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if (!$login) {
            // в эту ветку по идее никогда не попадаем,
            // так как предварительно проверяем что логин
            // корректный и существует, но тем не менее
            return array("echo" => array("success" => false, "reason" => "invalidCredentials"));
        }

        $query = "INSERT INTO {$_DB_USERS_TABLE_RESTORE} 
                  VALUES (?, ?, ?)
                  ON DUPLICATE KEY 
                  UPDATE start_time=?,  
                         rcode=?";
        $stmt = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [3] - setRestoreCode: {$error}.");
        }
        $time = time();
        $rcode = generateRestoreCode($connUsers, $_DB_USERS_TABLE_RESTORE);
        mysqli_stmt_bind_param($stmt, "sisis", $login, $time, $rcode, $time, $rcode);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [4] - setRestoreCode: {$error}.");
        }
        mysqli_stmt_close($stmt);
        mysqli_close($connUsers);

        if (!$_TESTNET) {
            $to        = $email;
            $subject   = "Password change for BitWhisk account";
            $active    = date('d-m-Y H:i:s', $time + $_RCODE_ACTIVE_PERIOD);
            $emailBody = "Dear {$login}, your restore code is\n\n{$rcode}\n\nIt lets you to change the password for your account until {$active} (UTC).\n\nIf you have not requested this action, please ignore this message.\n\nBest regards,\nBitWhisk.io team";
            $headers   = "From: contact@bitwhisk.io";
            $check     = mail($to, $subject, $emailBody, $headers);
        }
        return array("echo" => array("success" => true),
                     "log"  => "{$ip} - {$date} - [notice] - setRestoreCode: Successfully set rCode for user '{$login}'.");
    }

    function restoreAccess($rcode, $password) {
        global $_SERVERNAME,
               $_USERS_USERNAME,
               $_USERS_PASSWORD,
               $_DB_USERS,
               $_DB_USERS_TABLE_ACCOUNTS,
               $_DB_USERS_TABLE_RESTORE,
               $_TESTNET,
               $_RCODE_ACTIVE_PERIOD;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        $connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);

        if (!$connUsers) {
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [0] - restoreAccess: No connection to users database.");
        }

        $query = "SELECT login 
                  FROM {$_DB_USERS_TABLE_RESTORE} 
                  WHERE BINARY rcode=?";
        $stmt = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [1] - restoreAccess: {$error}.");
        }
        mysqli_stmt_bind_param($stmt, "s", $rcode);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [2] - restoreAccess: {$error}.");
        }
        $login = false;
        mysqli_stmt_bind_result($stmt, $login);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if (!$login) {
            return array("echo" => array("success" => false, "reason" => "invalidRestoreCode"));
        }

        mysqli_autocommit($connUsers, false);
        $query = "UPDATE {$_DB_USERS_TABLE_ACCOUNTS} 
                  SET password=? 
                  WHERE login=?";
        $stmt = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            mysqli_rollback($connUsers);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [3] - restoreAccess: {$error}.");
        }
        $passHash = password_hash($password, PASSWORD_BCRYPT);
        mysqli_stmt_bind_param($stmt, "ss", $passHash, $login);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_rollback($connUsers);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [4] - restoreAccess: {$error}.");
        }
        mysqli_stmt_close($stmt);

        $query = "DELETE FROM {$_DB_USERS_TABLE_RESTORE} 
                  WHERE login=?";
        $stmt = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            mysqli_rollback($connUsers);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [5] - restoreAccess: {$error}.");
        }
        mysqli_stmt_bind_param($stmt, "s", $login);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_rollback($connUsers);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [6] - restoreAccess: {$error}.");
        }
        mysqli_stmt_close($stmt);

        mysqli_commit($connUsers);
        mysqli_close($connUsers);
        return array("echo" => array("success" => true),
                     "log"  => "{$ip} - {$date} - [notice] - restoreAccess: Successfuly restored access for user {$login}.");
    }

    function generateRestoreCode($conn, $table) {
        global  $_MIN_LENGTH_RES_CODE,
                $_MAX_LENGTH_RES_CODE;

        $alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $length = random_int($_MIN_LENGTH_RES_CODE, $_MAX_LENGTH_RES_CODE);
        $isUsed = true;
        while ($isUsed) {
            $rcode = "";
            for ($i = 0; $i < $length-1; $i ++) {
                $rcode .= $alphabet[random_int(0, strlen($alphabet)-1)];
            }
            $isUsed = checkUniqueness($conn, $table, "rcode", $rcode);
        }
        return $rcode;
    }

    function generateVerificationCode() {
        global  $_MIN_LENGTH_VER_CODE,
                $_MAX_LENGTH_VER_CODE;

        $alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $length = random_int($_MIN_LENGTH_VER_CODE, $_MAX_LENGTH_VER_CODE);
        $code = "";
        for ($i = 0; $i < $length; $i ++) {
            $code .= $alphabet[random_int(0, strlen($alphabet)-1)];
        }
        return $code;
    }

    function generateSignText() {
        global  $_MIN_LENGTH_SIGN_CODE,
                $_MAX_LENGTH_SIGN_CODE;

        $alphabet = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $length = random_int($_MIN_LENGTH_SIGN_CODE, $_MAX_LENGTH_SIGN_CODE);
        $code = "";
        for ($i = 0; $i < $length; $i ++) {
            $code .= $alphabet[random_int(0, strlen($alphabet)-1)];
        }
        return $code;
    }

    function changePassword($login, $oldPasswd, $newPasswd) {
        global $_SERVERNAME,
               $_USERS_USERNAME,
               $_USERS_PASSWORD,
               $_DB_USERS,
               $_DB_USERS_TABLE_ACCOUNTS;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        $connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
        if (!$connUsers) {
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [0] - changePassword: No connection to users database.");
        }

        $query = "SELECT password 
                  FROM {$_DB_USERS_TABLE_ACCOUNTS}
                  WHERE login=?";
        $stmt = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [1] - changePassword: {$error}.");
        }
        $oldHash = false;
        mysqli_stmt_bind_param($stmt, "s", $login);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [2] - changePassword: {$error}.");
        }
        mysqli_stmt_bind_result($stmt, $oldHash);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if (!$oldHash) {
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [3] - changePassword: Somehow we could not find a password hash for user '{$login}'. Strange...");
        }

        if (!password_verify($oldPasswd, $oldHash)) {
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "wrongOldPassword"));
        }

        $query = "UPDATE {$_DB_USERS_TABLE_ACCOUNTS} 
                  SET password=? 
                  WHERE login=?";
        $stmt = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [4] - changePassword: {$error}.");
        }
        $newHash = password_hash($newPasswd, PASSWORD_BCRYPT);
        mysqli_stmt_bind_param($stmt, "ss", $newHash, $login);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [5] - changePassword: {$error}.");
        }
        mysqli_stmt_close($stmt);
        mysqli_close($connUsers);
        return array("echo" => array("success" => true),
                     "log"  => "{$ip} - {$date} - [notice] - changePassword: Successfully changed the password for user '{$login}'.");
    }

    function protectAccount($login, $signAddress) {
        global $_SERVERNAME,
               $_USERS_USERNAME,
               $_USERS_PASSWORD,
               $_DB_USERS,
               $_DB_USERS_TABLE_ACCOUNTS;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        $connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
        if (!$connUsers) {
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [0] - protectAccount: No connection to users database.");
        }

        $query = "UPDATE {$_DB_USERS_TABLE_ACCOUNTS} 
                  SET two_factor=?, sign_address=? 
                  WHERE login=?";
        $stmt = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [1] - protectAccount: {$error}.");
        }
        $yes = "yes";
        mysqli_stmt_bind_param($stmt, "sss", $yes, $signAddress, $login);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [2] - protectAccount: {$error}.");
        }
        mysqli_stmt_close($stmt);
        mysqli_close($connUsers);
        return array("echo" => array("success" => true),
                     "log"  => "{$ip} - {$date} - [notice] - protectAccount: Two-factor authorization is set for user '{$login}'.");
    }

    function checkSignature($login, $signAddress, $signature, $checkString) {
        global  $_RPC_USER,
                $_RPC_PASSWORD,
                $_SERVERNAME,
                $_SESSIONS_USERNAME,
                $_SESSIONS_PASSWORD,
                $_DB_SESSIONS,
                $_DB_SESSIONS_TABLE_AUTH,
                $_USERS_USERNAME,
                $_USERS_PASSWORD,
                $_DB_USERS,
                $_DB_USERS_TABLE_TWOFACTOR;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        $bitcoin = new Bitcoin_users($_RPC_USER, $_RPC_PASSWORD);
        if (!$bitcoin) {
            $error = $bitcoin -> error;
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [0] - checkSignature: No connection bitcoind. Daemon thrown: {$error}.");
        }
        $check = $bitcoin -> verifymessage($signAddress, $signature, $checkString);

        if (!$check) {
            return array("echo" => array("success" => false, "reason" => "wrongSignature"));
        }

        $connSess = mysqli_connect($_SERVERNAME, $_SESSIONS_USERNAME, $_SESSIONS_PASSWORD, $_DB_SESSIONS);

        if (!$connSess) {
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [1] - checkSignature: No connection to session database.");
        }
        
        $updateSession = "UPDATE {$_DB_SESSIONS_TABLE_AUTH} SET two_factor='passed' WHERE login = '{$login}'";
        if (!mysqli_query($connSess, $updateSession)) {
            $error = mysqli_error($connSess);
            $response = array("echo" => array("success" => false, "reason" => "internal"),
                              "log"  => "{$ip} - {$date} - [error] [2] - checkSignature: {$error}.");
        } else {
            $response = array("echo" => array("success" => true),
                              "log"  => "{$ip} - {$date} - [notice] - checkSignature: The user '{$login}' verified the signature.");
        }

        $connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
        if (!$connUsers) {
            return $response;
        }
        mysqli_query($connUsers, "DELETE FROM {$_DB_USERS_TABLE_TWOFACTOR} WHERE login='{$login}'");
        return $response;
    }

    //=============================================================================================================\\
    //---------------------------------------------- Validation ---------------------------------------------------\\

    function validateLogin($login) {
        global $_SERVERNAME, 
               $_USERS_USERNAME, 
               $_USERS_PASSWORD, 
               $_DB_USERS, 
               $_DB_USERS_TABLE_ACCOUNTS;

        $trimmed = preg_replace('/[^a-z0-9]/', '', $login);
        if (!$login or $trimmed != $login or strlen($login) < 5 or strlen($login) > 60) {
            return array("isCorrect" => false, 
                         "isUsed"    => null);
        }
        $conn = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
        $stmt = mysqli_prepare($conn, "SELECT count(1) FROM {$_DB_USERS_TABLE_ACCOUNTS} WHERE login=?");
        $count = 0;
        mysqli_stmt_bind_param($stmt, "s", $login);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return array("isCorrect" => true, 
                     "isUsed"    => ($count === 1));
    }

    function validatePassword($password) {
        $trimmed = preg_replace('/[^A-Za-z0-9!"#$%&\'()*+,-.\/:;<=>?@[\]^_`{|}~]/', '', $password);
        if (!$password or $trimmed != $password or strlen($password) < 8 or strlen($password) > 60) {
            return array("isCorrect" => false);
        }
        if (!preg_match('/[a-z]/', $password) or !preg_match('/[A-Z]/', $password) or !preg_match('/[0-9]/', $password)) {
            return array("isCorrect" => false);
        }
        if (!preg_match('/[!"#$%&\'()*+,-.\/:;<=>?@[\]^_`{|}~]/', $password)) {
            return array("isCorrect" => false);
        }
        return array("isCorrect" => true);
    }

    function validateEmail($email) {
        global $_SERVERNAME, 
               $_USERS_USERNAME, 
               $_USERS_PASSWORD, 
               $_DB_USERS, 
               $_DB_USERS_TABLE_ACCOUNTS;

        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$email) {
            return array("isCorrect" => false, 
                         "isUsed"    => null);
        }
        $conn = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
        $stmt = mysqli_prepare($conn, "SELECT count(1) FROM {$_DB_USERS_TABLE_ACCOUNTS} WHERE email=?");
        $count = 0;
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return array("isCorrect" => true, 
                     "isUsed"    => ($count === 1));
    }

    function validateCaptcha($value, $uri) {
        global $_SERVERNAME, 
               $_SESSIONS_USERNAME, 
               $_SESSIONS_PASSWORD, 
               $_DB_SESSIONS, 
               $_DB_SESSIONS_TABLE_CAPTCHA;

        $trimmed = preg_replace('/[^a-zA-Z0-9]/', '', $value);
        if (!$value or $trimmed != $value or strlen($value) != 6) {
            return array("isCorrect" => false);
        }
        $captcha = null;
        $conn = mysqli_connect($_SERVERNAME, $_SESSIONS_USERNAME, $_SESSIONS_PASSWORD, $_DB_SESSIONS);
        $stmt = mysqli_prepare($conn, "SELECT captcha_{$uri} FROM {$_DB_SESSIONS_TABLE_CAPTCHA} WHERE BINARY id=?");
        $id = preg_replace('/[^a-zA-Z0-9]/', '', $_COOKIE["captcha"]);
        mysqli_stmt_bind_param($stmt, "s", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $captcha);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        if ($captcha) {
            return array("isCorrect" => (strtolower($captcha) === strtolower($value)));
        } else {
            unset($_COOKIE["captcha"]);
            startCaptchaSession($uri);
            return array("isCorrect" => false);
        }        
    }

    function validateVerificationCode($vcode) {
        global  $_MIN_LENGTH_VER_CODE,
                $_MAX_LENGTH_VER_CODE;

        $trimmed = preg_replace('/[^a-zA-Z0-9]/', '', $vcode);
        if (!$vcode or $trimmed != $vcode or strlen($vcode) < $_MIN_LENGTH_VER_CODE or strlen($vcode) > $_MAX_LENGTH_VER_CODE) {
            return false;
        }
        return true;
    }

    function validateRcode($rcode) {
        global  $_MIN_LENGTH_RES_CODE,
                $_MAX_LENGTH_RES_CODE;

        $trimmed = preg_replace('/[^a-zA-Z0-9]/', '', $rcode);
        if (!$rcode or $trimmed != $rcode or strlen($rcode) < $_MIN_LENGTH_RES_CODE or strlen($rcode) > $_MAX_LENGTH_RES_CODE) {
            return false;
        }
        return true;
    }

    function validateDate($dateString) {
        if (!$dateString or strlen($dateString) != 10) {
            return false;
        }
        $trimmed = preg_replace('/[^0-9\/]/', '', $dateString);
        if ($trimmed != $dateString) {
            return false;
        }
        if (substr_count($dateString, "/") != 2) {
            return false;
        }
        $arr = explode("/", $dateString);
        if (strlen($arr[2]) != 4 or strlen($arr[1]) != 2 or strlen($arr[0]) != 2) {
            return false;
        }   
        $arr[0] = intval($arr[0]);
        $arr[1] = intval($arr[1]);
        $arr[2] = intval($arr[2]);
        
        $response = checkdate($arr[1], $arr[0], $arr[2]) ? $arr : false;
        return $response;
    }

    //=============================================================================================================\\
    //-------------------------------------------- Miscellaneous --------------------------------------------------\\

    function checkUniqueness($conn, $table, $fieldName, $fieldValue) {      
        $result = mysqli_query($conn, "SELECT count(1) from {$table} where BINARY {$fieldName} = '{$fieldValue}'");
        $arr = mysqli_fetch_assoc($result);
        return $arr["count(1)"] != 0;
    }

    //=============================================================================================================\\
    //--------------------------------------------- Users care ----------------------------------------------------\\

    function controlDeposits() {
        global  $_RPC_USER,
                $_RPC_PASSWORD,
                $_SERVERNAME,
                $_USERS_USERNAME,
                $_USERS_PASSWORD,
                $_DB_USERS,
                $_DB_USERS_TABLE_ACCOUNTS,
                $_MIXER_USERNAME,
                $_MIXER_PASSWORD,
                $_DB_MIXER,
                $_DB_MIXER_TABLE_U_ADDRESSES,
                $_TRUSTED_CONFIRMS;

        $date = date("j F Y, H:i:s", time()+10800);

        $connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
        if (!$connUsers) {
            echo "{$date} - [error] [0] - controlDeposits: There occurred an error while connecting to users database.".PHP_EOL;
            return;
        }

        $bitcoin = new Bitcoin_users($_RPC_USER, $_RPC_PASSWORD);
        if (!$bitcoin) {
            mysqli_close($connUsers);
            echo "{$date} - [error] [1] - controlDeposits: There occurred an error while connecting to bitcoind.".PHP_EOL;
            return;
        }

        $selectAll = "SELECT login, dep_address, code 
                      FROM {$_DB_USERS_TABLE_ACCOUNTS}
                      WHERE verified='yes'";
        if (!($depInfo = mysqli_query($connUsers, $selectAll))) {
            $error = mysqli_error($connUsers);
            mysqli_close($connUsers);
            echo "{$date} - [error] [2] - controlDeposits: Select error: {$error}".PHP_EOL;
            return;
        }

        $update = array();

        while ($userInfo = mysqli_fetch_assoc($depInfo)) {
            $sum = $bitcoin -> getreceivedbyaddress($userInfo["dep_address"], $_TRUSTED_CONFIRMS);
            $wait = $bitcoin -> listunspent(0, $_TRUSTED_CONFIRMS-1, array($userInfo["dep_address"]));
            if ($sum && $sum > 0 and empty($wait)) {
                $newAddress = $bitcoin -> getnewaddress();
                if (!$newAddress) {
                    $error = $bitcoin -> error;
                    mysqli_close($connUsers);
                    echo "{$date} - [error] [3] - controlDeposits: Bitcoind getnewaddress error: {$error}".PHP_EOL;
                    return;
                }
                $update[$userInfo["login"]] = array("sum"        => $sum, 
                                                    "code"       => $userInfo["code"].";",
                                                    "newAddress" => $newAddress, 
                                                    "oldAddress" => $userInfo["dep_address"]);
            }
        }

        if (!empty($update)) {
            $connMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
            if (!$connMixer) {
                echo "{$date} - [error] [4] - controlDeposits: There occurred an error while connecting to mixer database.".PHP_EOL;
                return;
            }
            mysqli_autocommit($connUsers, false);
            mysqli_autocommit($connMixer, false);

            $queryDeleteAccountLink = "UPDATE {$_DB_MIXER_TABLE_U_ADDRESSES}
                                       SET accounted='no'
                                       WHERE address=?";

            $queryAddUserAddress = "INSERT INTO {$_DB_MIXER_TABLE_U_ADDRESSES}
                                    VALUES (?, ?, ?)";
            $stamp = time();
            $queryUserUpdate = "UPDATE {$_DB_USERS_TABLE_ACCOUNTS} 
                                SET dep_balance=dep_balance+?, dep_address=?, dep_stamp='{$stamp}'
                                WHERE login=?";

            $stmtDeleteAccountLink = mysqli_prepare($connMixer, $queryDeleteAccountLink);
            $stmtAddUserAddress = mysqli_prepare($connMixer, $queryAddUserAddress);
            $stmtUserUpdate = mysqli_prepare($connUsers, $queryUserUpdate);

            if (!$stmtDeleteAccountLink or !$stmtAddUserAddress or !$stmtUserUpdate) {
                $error1 = mysqli_error($connUsers);
                $error2 = mysqli_error($connMixer);
                mysqli_close($connUsers);
                mysqli_close($connMixer);
                echo "{$date} - [error] [5] - controlDeposits: Error creating a prepared statement: {$error1} {$error2}.".PHP_EOL;
                return;
            }
            $yes = "yes";
            foreach ($update as $login => $info) {
                mysqli_stmt_bind_param($stmtDeleteAccountLink, "s", $info["oldAddress"]);
                if (!mysqli_stmt_execute($stmtDeleteAccountLink)) {
                    $error = mysqli_error($connMixer);
                    mysqli_rollback($connUsers);
                    mysqli_rollback($connMixer);
                    mysqli_stmt_close($stmtDeleteAccountLink);
                    mysqli_stmt_close($stmtAddUserAddress);
                    mysqli_stmt_close($stmtUserUpdate);
                    mysqli_close($connUsers);
                    mysqli_close($connMixer);
                    echo "{$date} - [error] [6] - controlDeposits: stmtDeleteAccountLink execution error: {$error}.".PHP_EOL;
                    return;
                }

                mysqli_stmt_bind_param($stmtAddUserAddress, "sss", $info["newAddress"], $info["code"], $yes);
                if (!mysqli_stmt_execute($stmtAddUserAddress)) {
                    $error = mysqli_error($connMixer);
                    mysqli_rollback($connUsers);
                    mysqli_rollback($connMixer);
                    mysqli_stmt_close($stmtDeleteAccountLink);
                    mysqli_stmt_close($stmtAddUserAddress);
                    mysqli_stmt_close($stmtUserUpdate);
                    mysqli_close($connUsers);
                    mysqli_close($connMixer);
                    echo "{$date} - [error] [7] - controlDeposits: stmtAddUserAddress execution error: {$error}.".PHP_EOL;
                    return;
                }

                mysqli_stmt_bind_param($stmtUserUpdate, "dss", $info["sum"], $info["newAddress"], $login);
                if (!mysqli_stmt_execute($stmtUserUpdate)) {
                    $error = mysqli_error($connUsers);
                    mysqli_rollback($connUsers);
                    mysqli_rollback($connMixer);
                    mysqli_stmt_close($stmtDeleteAccountLink);
                    mysqli_stmt_close($stmtAddUserAddress);
                    mysqli_stmt_close($stmtUserUpdate);
                    mysqli_close($connUsers);
                    mysqli_close($connMixer);
                    echo "{$date} - [error] [8] - controlDeposits: stmtUserUpdate execution error: {$error}.".PHP_EOL;
                    return;
                }
            }

            mysqli_commit($connMixer);
            mysqli_commit($connUsers);
            mysqli_stmt_close($stmtDeleteAccountLink);
            mysqli_stmt_close($stmtAddUserAddress);
            mysqli_stmt_close($stmtUserUpdate);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            echo "{$date} - [notice] - controlDeposits: Successfully handled all incoming deposits. Detailed summary:".PHP_EOL;
            $update = var_export($update, true);
            echo "{$update}".PHP_EOL;
            return;
        }
        mysqli_close($connUsers);
    }

    function generateDepLetter($login, $depAddress, $depStamp) {
        global  $_MAIN_ACCOUNT,
                $_RPC_USER,
                $_RPC_PASSWORD,
                $_A_WALLET_PASSPHRASE,
                $_LOG_FILE_AUTH;

        $logDate = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        $date = date("j F Y, H:i:s T", $depStamp);
        $now  = date("j F Y, H:i:s T", time());

        $message = "We hereby confirm that WWW.BITWHISK.IO has generated the Bitcoin address {$depAddress} at {$date} in order to accept deposits from user {$login}. This letter is digitally signed by our main account: {$_MAIN_ACCOUNT} at {$now}. Stay protected and thank you for using our service.";

        $bitcoin = new Bitcoin_anon($_RPC_USER, $_RPC_PASSWORD);
        if (!$bitcoin) {
            $logMessage = "{$ip} - {$logDate} - [error] [0] - generateDepLetter: Could not connect to bitcoind.";
            file_put_contents($_LOG_FILE_AUTH, $logMessage.PHP_EOL, FILE_APPEND);
            return false;
        }

        $bitcoin -> walletpassphrase($_A_WALLET_PASSPHRASE, 3);
        $signature = $bitcoin->signmessage($_MAIN_ACCOUNT, $message);
        if ($signature === false) {
            $error = $bitcoin -> error;
            $logMessage = "{$ip} - {$logDate} - [error] [1] - generateDepLetter: Signing message failed: {$error}.";
            file_put_contents($_LOG_FILE_AUTH, $logMessage.PHP_EOL, FILE_APPEND);
            return false;
        }

        $remark = "The Letter of Guarantee associated with your current deposit address {$depAddress} is available only before our system accepts a deposit from you. Hence, we advice you to save this document in a safe place before sending any coins to our accounts. This remark is placed here for your information, this is not a part of a Letter itself.";

        $letter = "-----START SIGNING BITCOIN ADDRESS-----\r\n{$_MAIN_ACCOUNT}\r\n-----END SIGNING BITCOIN ADDRESS-----\r\n\r\n-----START LETTER OF GUARANTEE-----\r\n{$message}\r\n-----END LETTER OF GUARANTEE-----\r\n\r\n-----START DIGITAL SIGNATURE-----\r\n{$signature}\r\n-----END DIGITAL SIGNATURE-----\r\n\r\n-----START IMPORTANT REMARK-----\r\n{$remark}\r\n-----END IMPORTANT REMARK-----";

        $logMessage = "{$ip} - {$logDate} - [notice] - generateDepLetter: Successfully generated a deposit LoG for user '{$login}'.";
        file_put_contents($_LOG_FILE_AUTH, $logMessage.PHP_EOL, FILE_APPEND);

        return $letter;
    }

    function controlInvestors() {
        global  $_RPC_USER,
                $_RPC_PASSWORD,
                $_SERVERNAME,
                $_USERS_USERNAME,
                $_USERS_PASSWORD,
                $_DB_USERS,
                $_DB_USERS_TABLE_ACCOUNTS,
                $_MIXER_USERNAME,
                $_MIXER_PASSWORD,
                $_DB_MIXER,
                $_DB_MIXER_TABLE_I_ADDRESSES,
                $_TRUSTED_CONFIRMS;

        $date = date("j F Y, H:i:s", time()+10800);

        $connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
        if (!$connUsers) {
            echo "{$date} - [error] [0] - controlInvestors: There occurred an error while connecting to users database.".PHP_EOL;
            return;
        }

        $bitcoin = new Bitcoin_invest($_RPC_USER, $_RPC_PASSWORD);
        if (!$bitcoin) {
            mysqli_close($connUsers);
            echo "{$date} - [error] [1] - controlInvestors: There occurred an error while connecting to bitcoind.".PHP_EOL;
            return;
        }

        $selectAll = "SELECT login, inv_address, code 
                      FROM {$_DB_USERS_TABLE_ACCOUNTS} 
                      WHERE verified='yes'";
        if (!($depInfo = mysqli_query($connUsers, $selectAll))) {
            $error = mysqli_error($connUsers);
            echo "{$date} - [error] [2] - controlInvestors: Select error: {$error}".PHP_EOL;
            return;
        }

        $update = array();

        while ($userInfo = mysqli_fetch_assoc($depInfo)) {
            $sum = $bitcoin -> getreceivedbyaddress($userInfo["inv_address"], $_TRUSTED_CONFIRMS);
            $wait = $bitcoin -> listunspent(0, $_TRUSTED_CONFIRMS-1, array($userInfo["inv_address"]));
            if ($sum && $sum > 0 and empty($wait)) {
                $newAddress = $bitcoin -> getnewaddress();
                if (!$newAddress) {
                    $error = $bitcoin -> error;
                    echo "{$date} - [error] [3] - controlInvestors: Bitcoind getnewaddress error: {$error}".PHP_EOL;
                    return;
                }
                $update[$userInfo["login"]] = array("sum" => $sum, 
                                                    "newAddress" => $newAddress, 
                                                    "code" => $userInfo["code"].";");
            }
        }

        if (!empty($update)) {
            $connMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
            if (!$connMixer) {
                echo "{$date} - [error] [4] - controlInvestors: There occurred an error while connecting to mixer database.".PHP_EOL;
                return;
            }
            mysqli_autocommit($connUsers, false);
            mysqli_autocommit($connMixer, false);

            $queryAddUserAddress = "INSERT INTO {$_DB_MIXER_TABLE_I_ADDRESSES}
                                    VALUES (?, ?)";
            $stamp = time();
            $queryUserUpdate = "UPDATE {$_DB_USERS_TABLE_ACCOUNTS} 
                                SET inv_balance=inv_balance+?, inv_address=?, inv_stamp='{$stamp}'
                                WHERE login=?";

            $stmtAddUserAddress = mysqli_prepare($connMixer, $queryAddUserAddress);
            $stmtUserUpdate = mysqli_prepare($connUsers, $queryUserUpdate);
            if (!$stmtUserUpdate or !$stmtAddUserAddress) {
                $error1 = mysqli_error($connUsers);
                $error2 = mysqli_error($connMixer);
                mysqli_close($connUsers);
                mysqli_close($connMixer);
                echo "{$date} - [error] [5] - controlInvestors: Error creating a prepared statement: {$error1} {$error2}.".PHP_EOL;
                return;
            }

            foreach ($update as $login => $info) {
                mysqli_stmt_bind_param($stmtAddUserAddress, "ss", $info["newAddress"], $info["code"]);
                if (!mysqli_stmt_execute($stmtAddUserAddress)) {
                    $error = mysqli_error($connMixer);
                    mysqli_rollback($connUsers);
                    mysqli_rollback($connMixer);
                    mysqli_stmt_close($stmtAddUserAddress);
                    mysqli_stmt_close($stmtUserUpdate);
                    mysqli_close($connUsers);
                    mysqli_close($connMixer);
                    echo "{$date} - [error] [6] - controlInvestors: stmtAddUserAddress execution error: {$error}".PHP_EOL;
                    return;
                }

                mysqli_stmt_bind_param($stmtUserUpdate, "dss", $info["sum"], $info["newAddress"], $login);
                if (!mysqli_stmt_execute($stmtUserUpdate)) {
                    $error = mysqli_error($connUsers);
                    mysqli_rollback($connUsers);
                    mysqli_rollback($connMixer);
                    mysqli_stmt_close($stmtAddUserAddress);
                    mysqli_stmt_close($stmtUserUpdate);
                    mysqli_close($connUsers);
                    mysqli_close($connMixer);
                    echo "{$date} - [error] [7] - controlInvestors: stmtUserUpdate execution error: {$error}".PHP_EOL;
                    return;
                }
                
            }
            mysqli_commit($connMixer);
            mysqli_commit($connUsers);
            mysqli_stmt_close($stmtAddUserAddress);
            mysqli_stmt_close($stmtUserUpdate);
            mysqli_close($connUsers);
            mysqli_close($connMixer);
            echo "{$date} - [notice] - controlInvestors: Successfully handled all incoming deposits. Detailed summary:".PHP_EOL;
            $update = var_export($update, true);
            echo "{$update}".PHP_EOL;
            return;
        }
        mysqli_close($connUsers);
    }

    function generateInvLetter($login, $invAddress, $invStamp) {
        global  $_MAIN_ACCOUNT,
                $_RPC_USER,
                $_RPC_PASSWORD,
                $_A_WALLET_PASSPHRASE,
                $_LOG_FILE_AUTH;

        $logDate = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        $date = date("j F Y, H:i:s T", $invStamp);
        $now  = date("j F Y, H:i:s T", time());

        $message = "We hereby confirm that WWW.BITWHISK.IO has generated the Bitcoin address {$invAddress} at {$date} in order to accept investments from user {$login}. This letter is digitally signed by our main account: {$_MAIN_ACCOUNT} at {$now}. Stay protected and thank you for using our service.";

        $bitcoin = new Bitcoin_anon($_RPC_USER, $_RPC_PASSWORD);
        if (!$bitcoin) {
            $logMessage = "{$ip} - {$logDate} - [error] [0] - generateInvLetter: Could not connect to bitcoind.";
            file_put_contents($_LOG_FILE_AUTH, $logMessage.PHP_EOL, FILE_APPEND);
            return false;
        }

        $bitcoin -> walletpassphrase($_A_WALLET_PASSPHRASE, 3);
        $signature = $bitcoin->signmessage($_MAIN_ACCOUNT, $message);
        if ($signature === false) {
            $error = $bitcoin -> error;
            $logMessage = "{$ip} - {$logDate} - [error] [1] - generateInvLetter: Signing message failed: {$error}.";
            file_put_contents($_LOG_FILE_AUTH, $logMessage.PHP_EOL, FILE_APPEND);
            return false;
        }

        $remark = "The Letter of Guarantee associated with your current investment address {$invAddress} is available only before our system accepts an investment from you. Hence, we advice you to save this document in a safe place before sending any coins to our accounts. This remark is placed here for your information, this is not a part of a Letter itself.";

        $letter = "-----START SIGNING BITCOIN ADDRESS-----\r\n{$_MAIN_ACCOUNT}\r\n-----END SIGNING BITCOIN ADDRESS-----\r\n\r\n-----START LETTER OF GUARANTEE-----\r\n{$message}\r\n-----END LETTER OF GUARANTEE-----\r\n\r\n-----START DIGITAL SIGNATURE-----\r\n{$signature}\r\n-----END DIGITAL SIGNATURE-----\r\n\r\n-----START IMPORTANT REMARK-----\r\n{$remark}\r\n-----END IMPORTANT REMARK-----";

        $logMessage = "{$ip} - {$logDate} - [notice] - generateInvLetter: Successfully generated a investor LoG for user '{$login}'.";
        file_put_contents($_LOG_FILE_AUTH, $logMessage.PHP_EOL, FILE_APPEND);

        return $letter;
    }

    function registerWithdraw($login, $password, $amount, $address) {
        global  $_SERVERNAME,
                $_USERS_USERNAME,
                $_USERS_PASSWORD,
                $_DB_USERS,
                $_DB_USERS_TABLE_ACCOUNTS,
                $_DB_USERS_TABLE_WITHDRAW,
                $_TESTNET;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        $connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);

        if (!$connUsers) {
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [0] - registerWithdraw: No connection to users database.");
        }

        $query = "SELECT password 
                  FROM {$_DB_USERS_TABLE_ACCOUNTS}
                  WHERE login=?";
        $stmt = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [1] - registerWithdraw: {$error}.");
        }
        $hash = false;
        mysqli_stmt_bind_param($stmt, "s", $login);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connUsers);
            mysqli_stmt_close($stmt);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [2] - registerWithdraw: {$error}.");
        }
        mysqli_stmt_bind_result($stmt, $hash);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if (!$hash) {
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [3] - registerWithdraw: Somehow we could not find a password hash for user '{$login}'. Strange...");
        }

        if (!password_verify($password, $hash)) {
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "password"));
        }

        $stamp = time();
        $query = "INSERT INTO {$_DB_USERS_TABLE_WITHDRAW} VALUES ('{$login}', '{$stamp}', '{$amount}', '{$address}')";

        if (!mysqli_query($connUsers, $query)) {
            $error = mysqli_error($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [4] - registerWithdraw: {$error}.");
        } else {
            if (!$_TESTNET) {
                $to        = "contact@bitwhisk.io";
                $subject   = "Withdraw request";
                $emailBody = "User '{$login}' requests a withdraw of {$amount} BTC.";
                $headers   = "From: contact@bitwhisk.io";
                $check     = mail($to, $subject, $emailBody, $headers);
            }
            return array("echo" => array("success" => true),
                         "log"  => "{$ip} - {$date} - [notice] - registerWithdraw: User '{$login}' requests a withdraw of {$amount} BTC.");
        }
    }

    function selectStatistics($login, $sdate, $edate) {
        global  $_SERVERNAME,
                $_MIXER_USERNAME,
                $_MIXER_PASSWORD,
                $_DB_MIXER,
                $_DB_MIXER_TABLE_STATS;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        $connMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);

        if (!$connMixer) {
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [0] - selectStatistics: No connection to mixer database.");
        }

        $result = mysqli_query($connMixer, "SELECT sum(profit) AS total FROM {$_DB_MIXER_TABLE_STATS} WHERE stamp > '{$sdate}' AND stamp < '{$edate}'");

        if (!$result) {
            $error = mysqli_error($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [1] - selectStatistics: {$error}.");
        }
        $sum = mysqli_fetch_assoc($result)["total"];
        return array("echo" => array("success" => true, "sum" => $sum+0),
                     "log"  => "{$ip} - {$date} - [notice] - selectStatistics: Statistics selected by user '{$login}'. {$sdate}, {$edate}");
    }

    function contorlUsersMaximums() {
        global  $_SERVERNAME,
                $_USERS_USERNAME,
                $_USERS_PASSWORD,
                $_DB_USERS,
                $_DB_USERS_TABLE_ACCOUNTS,
                $_MIXER_USERNAME,
                $_MIXER_PASSWORD,
                $_DB_MIXER,
                $_DB_MIXER_TABLE_U_ADDRESSES,
                $_DB_MIXER_TABLE_U_TAKEAWAY,
                $_RPC_USER,
                $_RPC_PASSWORD,
                $_LOG_FILE_AUTH;

        $date = date("j F Y, H:i:s", time()+10800);

        $connMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connMixer) {
            $error = mysqli_connect_error();
            echo "{$date} - [error] [0] - contorlUsersMaximums: {$error}.".PHP_EOL;
            return;
        }

        $connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
        if (!$connUsers) {
            $error = mysqli_connect_error();
            echo "{$date} - [error] [1] - contorlUsersMaximums: {$error}.".PHP_EOL;
            mysqli_close($connMixer);
            return;
        }

        $query = "SELECT max_amount, login, code
                  FROM {$_DB_USERS_TABLE_ACCOUNTS}
                  WHERE verified='yes'";
        if (!($result = mysqli_query($connUsers, $query))) {
            $error = mysqli_error($connUsers);
            echo "{$date} - [error] [2] - contorlUsersMaximums: {$error}.".PHP_EOL;
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            return;
        }

        $query = "UPDATE {$_DB_USERS_TABLE_ACCOUNTS}
                  SET max_amount=?
                  WHERE login=?";
        $stmt = mysqli_prepare($connUsers, $query);
        if (!$stmt) {
            $error = mysqli_error($connUsers);
            echo "{$date} - [error] [3] - contorlUsersMaximums: {$error}.".PHP_EOL;
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            return;
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $info = defineUserMaximum($row["code"]);
            if (!$info["success"]) {
                $error = $info["log"];
                echo "{$date} - [error] [4] - contorlUsersMaximums: {$error}.".PHP_EOL;
                mysqli_stmt_close($stmt);
                mysqli_close($connMixer);
                mysqli_close($connUsers);
                return;
            }

            $maxAmount = round($info["result"], 8);
            if (abs($maxAmount - $row["max_amount"]) > 0.00000001) {
                mysqli_stmt_bind_param($stmt, "ds", $maxAmount, $row["login"]);
                if (!mysqli_stmt_execute($stmt)) {
                    $error = mysqli_error($connUsers);
                    echo "{$date} - [error] [5] - contorlUsersMaximums: {$error}.".PHP_EOL;
                    mysqli_stmt_close($stmt);
                    mysqli_close($connMixer);
                    mysqli_close($connUsers);
                    return;
                }
            }
        }
    }

    function defineUserMaximum($code) {
        global  $_SERVERNAME,
                $_MIXER_USERNAME,
                $_MIXER_PASSWORD,
                $_DB_MIXER,
                $_DB_MIXER_TABLE_U_ADDRESSES,
                $_DB_MIXER_TABLE_U_TAKEAWAY,
                $_RPC_USER,
                $_RPC_PASSWORD,
                $_MINER_FEE_BUFFER;

        $subtractAddresses = array();

        $connMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connMixer) {
            return array("success" => false,
                         "log"     => mysqli_connect_error());
        }

        $query = "SELECT address
                  FROM {$_DB_MIXER_TABLE_U_ADDRESSES} 
                  WHERE BINARY codes LIKE '%{$code}%'";
        $codeAddresses = mysqli_query($connMixer, $query);
        if (!$codeAddresses) {
            $error = mysqli_error($connMixer);
            return array("success" => false,
                         "log"     => $error);
        }
        while ($row = mysqli_fetch_assoc($codeAddresses)) {
            array_push($subtractAddresses, $row["address"]);
        }

        $query = "SELECT address 
                  FROM {$_DB_MIXER_TABLE_U_TAKEAWAY}";
        $takeawayAddresses = mysqli_query($connMixer, $query);
        if (!$takeawayAddresses) {
            $error = mysqli_error($connMixer);
            return array("success" => false,
                         "log"     => $error);
        }
        while ($row = mysqli_fetch_assoc($takeawayAddresses)) {
            array_push($subtractAddresses, $row["address"]);
        }

        $bitcoin = new Bitcoin_users($_RPC_USER, $_RPC_PASSWORD);
        $balance = $bitcoin -> getbalance("*", 0);
        if ($balance === null or $balance === false) {
            $error = $bitcoin -> error;
            return array("success" => false,
                         "log"     => $error);
        }

        if (!empty($subtractAddresses)) {
            $txids = $bitcoin -> listunspent(0, 9999999, $subtractAddresses);
            if ($txids === false) {
                $error = $bitcoin -> error;
                return array("success" => false,
                             "log"     => $error);
            }
            foreach ($txids as $txid) {
                $balance -= $txid["amount"];
            }
        }

        return array("success" => true,
                     "result"  => max(round($balance - $_MINER_FEE_BUFFER, 8), 0));
    }

    function controlTakeaways() {
        global  $_SERVERNAME,
                $_MIXER_USERNAME,
                $_MIXER_PASSWORD,
                $_DB_MIXER,
                $_DB_MIXER_TABLE_USER_ORDERS,
                $_DB_MIXER_TABLE_CODES,
                $_DB_MIXER_TABLE_STATS,
                $_USERS_USERNAME,
                $_USERS_PASSWORD,
                $_DB_USERS,
                $_DB_USERS_TABLE_ACCOUNTS,
                $_RPC_USER,
                $_RPC_PASSWORD,
                $_TRUSTED_CONFIRMS;

        $date = date("j F Y, H:i:s", time()+10800);

        $connMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connMixer) {
            $error = mysqli_connect_error();
            echo "{$date} - [error] [0] - controlTakeaways: {$error}.".PHP_EOL;
            return;
        }

        $connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
        if (!$connUsers) {
            $error = mysqli_connect_error();
            mysqli_close($connMixer);
            echo "{$date} - [error] [1] - controlTakeaways: {$error}.".PHP_EOL;
            return;
        }

        $bitcoin = new Bitcoin_users($_RPC_USER, $_RPC_PASSWORD);
        if (!$bitcoin) {
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            echo "{$date} - [error] [2] - controlTakeaways: Couldn't connect to bitcoind.".PHP_EOL;
            return;
        }

        $query = "SELECT id,
                         login,
                         code,
                         commission,
                         profit,
                         unlock_amount,
                         incoming_address1,
                         incoming_address2
                  FROM {$_DB_MIXER_TABLE_USER_ORDERS}
                  WHERE status='locked'";
        $result = mysqli_query($connMixer, $query);
        if (!$result) {
            $error = mysqli_error($connMixer);
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            echo "{$date} - [error] [3] - controlTakeaways: {$error}.".PHP_EOL;
            return;
        }

        $toUpdate = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $received1 = $bitcoin -> getreceivedbyaddress($row["incoming_address1"], $_TRUSTED_CONFIRMS);
            $received2 = $bitcoin -> getreceivedbyaddress($row["incoming_address2"], $_TRUSTED_CONFIRMS);

            if ($received1 === false or $received2 === false) {
                $error = $bitcoin -> error;
                mysqli_close($connMixer);
                mysqli_close($connUsers);
                echo "{$date} - [error] [4] - controlTakeaways: {$error}.".PHP_EOL;
                return;
            }

            if ($received1 + $received2 >= $row["unlock_amount"]) {
                $info = array(
                    "login"      => $row["login"],
                    "id"         => $row["id"],
                    "code"       => $row["code"],
                    "commission" => $row["commission"],
                    "profit"     => $row["profit"],
                    "amount"     => number_format(round($received1 + $received2, 8), 8, ".", "")
                );
                if ($received1 + $received2 - $row["unlock_amount"] >= 0.00000001) {
                    $info["surplus"] = number_format($received1 + $received2 - $row["unlock_amount"], 8, ".", "");
                }
                array_push($toUpdate, $info);
            }
        }

        $query = "UPDATE {$_DB_MIXER_TABLE_USER_ORDERS}
                  SET status='open'
                  WHERE id=?";
        $stmtUpdateOrders = mysqli_prepare($connMixer, $query);
        if (!$stmtUpdateOrders) {
            $error = mysqli_error($connMixer);
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            echo "{$date} - [error] [5] - controlTakeaways: {$error}.".PHP_EOL;
            return;
        }

        $query = "UPDATE {$_DB_MIXER_TABLE_CODES}
                  SET sum=sum+?
                  WHERE code=?";
        $stmtUpdateCodes = mysqli_prepare($connMixer, $query);
        if (!$stmtUpdateCodes) {
            $error = mysqli_error($connMixer);
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            echo "{$date} - [error] [6] - controlTakeaways: {$error}.".PHP_EOL;
            return;
        }

        $query = "INSERT INTO {$_DB_MIXER_TABLE_STATS}
                  VALUES (?, '0', ?, ?)";
        $stmtInsertStats = mysqli_prepare($connMixer, $query);
        if (!$stmtInsertStats) {
            $error = mysqli_error($connMixer);
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            echo "{$date} - [error] [7] - controlTakeaways: {$error}.".PHP_EOL;
            return;
        }

        $query = "UPDATE {$_DB_USERS_TABLE_ACCOUNTS}
                  SET ok_orders=ok_orders+'1'
                  WHERE login=?";
        $stmtUpdateCount = mysqli_prepare($connUsers, $query);
        if (!$stmtUpdateCount) {
            $error = mysqli_error($connUsers);
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            echo "{$date} - [error] [8] - controlTakeaways: {$error}.".PHP_EOL;
            return;
        }

        $query = "UPDATE {$_DB_USERS_TABLE_ACCOUNTS}
                  SET dep_balance=dep_balance+?
                  WHERE login=?";
        $stmtUpdateBalance = mysqli_prepare($connUsers, $query);
        if (!$stmtUpdateBalance) {
            $error = mysqli_error($connUsers);
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            echo "{$date} - [error] [9] - controlTakeaways: {$error}.".PHP_EOL;
            return;
        }

        mysqli_autocommit($connMixer, false);
        mysqli_autocommit($connUsers, false);
        $log = "";
        foreach ($toUpdate as $info) {
            $details = array(
                "login" => $info["login"],
                "id"    => $info["id"],
                "profit" => $info["profit"],
                "code"   => $info["code"]
            );

            $time = time();
            mysqli_stmt_bind_param($stmtUpdateOrders, "s", $info["id"]);
            mysqli_stmt_bind_param($stmtUpdateCodes, "ds", $info["amount"], $info["code"]);
            mysqli_stmt_bind_param($stmtInsertStats, "idd", $time, $info["profit"], $info["commission"]);
            mysqli_stmt_bind_param($stmtUpdateCount, "s", $info["login"]);
            if (!mysqli_stmt_execute($stmtUpdateOrders) or 
                !mysqli_stmt_execute($stmtUpdateCodes) or 
                !mysqli_stmt_execute($stmtInsertStats) or 
                !mysqli_stmt_execute($stmtUpdateCount)) 
            {
                $error = mysqli_error($connMixer);
                $error .= mysqli_error($connUsers);
                mysqli_rollback($connMixer);
                mysqli_rollback($connUsers);
                mysqli_stmt_close($stmtUpdateOrders);
                mysqli_stmt_close($stmtUpdateCodes);
                mysqli_stmt_close($stmtInsertStats);
                mysqli_stmt_close($stmtUpdateCount);
                mysqli_stmt_close($stmtUpdateBalance);
                mysqli_close($connMixer);
                mysqli_close($connUsers);
                echo "{$date} - [error] [10] - controlTakeaways: {$error}.".PHP_EOL;
                return;
            }

            if (isset($info["surplus"])) {
                mysqli_stmt_bind_param($stmtUpdateBalance, "ds", $info["surplus"], $info["login"]);
                if (!mysqli_stmt_execute($stmtUpdateBalance)) {
                    $error = mysqli_error($connUsers);
                    mysqli_rollback($connMixer);
                    mysqli_rollback($connUsers);
                    mysqli_stmt_close($stmtUpdateOrders);
                    mysqli_stmt_close($stmtUpdateCodes);
                    mysqli_stmt_close($stmtInsertStats);
                    mysqli_stmt_close($stmtUpdateCount);
                    mysqli_stmt_close($stmtUpdateBalance);
                    mysqli_close($connMixer);
                    mysqli_close($connUsers);
                    echo "{$date} - [error] [11] - controlTakeaways: {$error}.".PHP_EOL;
                    return;
                }
                $details["surplus"] = $info["surplus"];
            }

            $log .= "{$date} - [notice] - controlTakeaways: Successfully unlocked takeaway. Details:".PHP_EOL;
            $log .= var_export($details, true).PHP_EOL;
        }
        mysqli_commit($connMixer);
        mysqli_commit($connUsers);
        mysqli_stmt_close($stmtUpdateOrders);
        mysqli_stmt_close($stmtUpdateCodes);
        mysqli_stmt_close($stmtInsertStats);
        mysqli_stmt_close($stmtUpdateCount);
        mysqli_stmt_close($stmtUpdateBalance);
        mysqli_close($connMixer);
        mysqli_close($connUsers);
        if ($log != "") {
            echo $log;
        }
    }

    function cleanUsersOrders() {
        global  $_SERVERNAME,
                $_MIXER_USERNAME,
                $_MIXER_PASSWORD,
                $_DB_MIXER,
                $_DB_MIXER_TABLE_USER_ORDERS,
                $_DB_MIXER_TABLE_U_TAKEAWAY,
                $_USERS_USERNAME,
                $_USERS_PASSWORD,
                $_DB_USERS,
                $_DB_USERS_TABLE_ACCOUNTS;

        $date = date("j F Y, H:i:s", time()+10800);
        $twelveHoursAgo = time()-12*60*60;

        $connMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connMixer) {
            $error = mysqli_connect_error();
            echo "{$date} - [error] [0] - cleanUsersOrders: {$error}.".PHP_EOL;
            return;
        }

        $connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
        if (!$connUsers) {
            $error = mysqli_connect_error();
            mysqli_close($connMixer);
            echo "{$date} - [error] [1] - cleanUsersOrders: {$error}.".PHP_EOL;
            return;
        }

        $query = "UPDATE {$_DB_USERS_TABLE_ACCOUNTS}
                  SET dummy_orders=dummy_orders+'1'
                  WHERE login=?";
        $stmtUpdateCount = mysqli_prepare($connUsers, $query);
        if (!$stmtUpdateCount) {
            $error = mysqli_error($connUsers);
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            echo "{$date} - [error] [2] - cleanUsersOrders: {$error}.".PHP_EOL;
            return;
        }

        $query = "DELETE FROM {$_DB_MIXER_TABLE_U_TAKEAWAY}
                  WHERE address=?";
        $stmtDeleteTakeaway = mysqli_prepare($connMixer, $query);
        if (!$stmtDeleteTakeaway) {
            $error = mysqli_error($connMixer);
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            echo "{$date} - [error] [3] - cleanUsersOrders: {$error}.".PHP_EOL;
            return;
        }

        $query = "SELECT login, stash_address 
                  FROM {$_DB_MIXER_TABLE_USER_ORDERS}
                  WHERE creation_time<'{$twelveHoursAgo}' AND status='locked'";
        $result = mysqli_query($connMixer, $query);
        if (!$result) {
            $error = mysqli_error($connMixer);
            mysqli_stmt_close($stmtUpdateCount);
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            echo "{$date} - [error] [4] - cleanUsersOrders: {$error}.".PHP_EOL;
            return;
        }

        mysqli_autocommit($connMixer, false);
        mysqli_autocommit($connUsers, false);
        $log = "";
        while ($row = mysqli_fetch_assoc($result)) {
            mysqli_stmt_bind_param($stmtUpdateCount, "s", $row["login"]);
            mysqli_stmt_bind_param($stmtDeleteTakeaway, "s", $row["stash_address"]);

            if (!mysqli_stmt_execute($stmtUpdateCount) or 
                !mysqli_stmt_execute($stmtDeleteTakeaway)) 
            {
                $error = mysqli_error($connUsers);
                $error .= mysqli_error($connMixer);
                mysqli_rollback($connMixer);
                mysqli_rollback($connUsers);
                mysqli_stmt_close($stmtUpdateCount);
                mysqli_stmt_close($stmtDeleteTakeaway);
                mysqli_close($connMixer);
                mysqli_close($connUsers);
                echo "{$date} - [error] [5] - cleanUsersOrders: {$error}.";
                return;
            }

            $log .= "{$date} - [notice] - cleanUsersOrders: Dummy order counted for {$row["login"]}.".PHP_EOL;
            $log .= "{$date} - [notice] - cleanUsersOrders: Address {$row["stash_address"]} is no more stashed.".PHP_EOL;
        }

        $query = "DELETE FROM {$_DB_MIXER_TABLE_USER_ORDERS}
                  WHERE creation_time<'{$twelveHoursAgo}'";
        $check = mysqli_query($connMixer, $query);
        if (!$check) {
            $error = mysqli_error($connMixer);
            mysqli_rollback($connMixer);
            mysqli_rollback($connUsers);
            mysqli_stmt_close($stmtUpdateCount);
            mysqli_stmt_close($stmtDeleteTakeaway);
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            echo "{$date} - [error] [6] - cleanUsersOrders: {$error}.".PHP_EOL;
            return;
        }

        $deletedNumber = mysqli_affected_rows($connMixer);
        if ($deletedNumber == 1) {
            $log .= "{$date} - [notice] - cleanUsersOrders: {$deletedNumber} user order was deleted from DB.".PHP_EOL;
        } elseif ($deletedNumber > 1) {
            $log .= "{$date} - [notice] - cleanUsersOrders: {$deletedNumber} user orders were deleted from DB.".PHP_EOL;
        }

        mysqli_commit($connMixer);
        mysqli_commit($connUsers);
        mysqli_stmt_close($stmtUpdateCount);
        mysqli_stmt_close($stmtDeleteTakeaway);
        mysqli_close($connMixer);
        mysqli_close($connUsers);
        if ($log != "") {
            echo $log;
        }
    }

    function prepareTakeaway($login, $code, $amount, $commission, $balance, $minerRate) {
        global  $_SERVERNAME,
                $_MIXER_USERNAME,
                $_MIXER_PASSWORD,
                $_DB_MIXER,
                $_DB_MIXER_TABLE_U_ADDRESSES,
                $_DB_MIXER_TABLE_U_TAKEAWAY,
                $_DB_MIXER_TABLE_USER_ORDERS,
                $_USERS_USERNAME,
                $_USERS_PASSWORD,
                $_DB_USERS,
                $_DB_USERS_TABLE_ACCOUNTS,
                $_RPC_USER,
                $_RPC_PASSWORD,
                $_TRUSTED_CONFIRMS,
                $_U_WALLET_PASSPHRASE,
                $_MINER_FEE_BUFFER;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        $connMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connMixer) {
            $error = mysqli_connect_error();
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [0] - prepareTakeaway: {$error}.");
        }

        $connUsers = mysqli_connect($_SERVERNAME, $_USERS_USERNAME, $_USERS_PASSWORD, $_DB_USERS);
        if (!$connUsers) {
            $error = mysqli_connect_error();
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [1] - prepareTakeaway: {$error}.");
        }

        $bitcoin = new Bitcoin_users($_RPC_USER, $_RPC_PASSWORD);
        if (!$bitcoin) {
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [2] - prepareTakeaway: Couldn't connect to bitcoind.");
        }

        $amountExtended  = round($amount + $_MINER_FEE_BUFFER, 8);
        $wholeUnspent    = $bitcoin -> listunspent(1, 9999999);
        $possibleUnspent = array();
        $confirmedAmount = 0;

        foreach ($wholeUnspent as $UTXO) {
            $check = isAddressForbidden($UTXO["address"], $code, $connMixer);
            if (!$check["success"]) {
                $error = $check["error"];
                mysqli_close($connMixer);
                mysqli_close($connUsers);
                return array("echo" => array("success" => false, "reason" => "internal"),
                             "log"  => "{$ip} - {$date} - [error] [3] - prepareTakeaway: {$error}");
            }
            if ($check["forbidden"]) continue;

            $check = isAddressStashed($UTXO["address"], $connMixer);
            if (!$check["success"]) {
                $error = $check["error"];
                mysqli_close($connMixer);
                mysqli_close($connUsers);
                return array("echo" => array("success" => false, "reason" => "internal"),
                             "log"  => "{$ip} - {$date} - [error] [4] - prepareTakeaway: {$error}");
            }
            if ($check["stashed"]) continue;

            if ($UTXO["confirmations"] < $_TRUSTED_CONFIRMS) {
                $check = isAddressWaiting($UTXO["address"], $connMixer);
                if (!$check["success"]) {
                    $error = $check["error"];
                    mysqli_close($connMixer);
                    mysqli_close($connUsers);
                    return array("echo" => array("success" => false, "reason" => "internal"),
                                 "log"  => "{$ip} - {$date} - [error] [5] - prepareTakeaway: {$error}");
                }
                if ($check["waits"]) continue;
            }

            $confirmedAmount += $UTXO["amount"];
            array_push($possibleUnspent, $UTXO);
        }

        if ($confirmedAmount < $amountExtended) {
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "unconfirmedOutputs"),
                         "log"  => "{$ip} - {$date} - [warning] - prepareTakeaway: No sufficient balance for preparing a takeaway for {$login}.");
        }

        usort($possibleUnspent, function(array $a, array $b) {
            if     ($a["amount"] > $b["amount"]) return -1; 
            elseif ($a["amount"] < $b["amount"]) return 1; 
            else return 0;
        });

        $tempAmountToSend = $amountExtended;
        $inputAmount = 0;
        $index = 0;

        while ($inputAmount < $tempAmountToSend) {
            $inputAmount += $possibleUnspent[$index]["amount"];
            $index       += 1;
            if ($index == count($possibleUnspent)) {break 1;}
        }

        $txidsAndVouts = array();
        $usedAddresses = array();
        $start         = 1;
        $finalInputAmt = 0;
        while ($index > 0) {
            $inputAmount = 0;
            if ($start < count($possibleUnspent)) {
                for ($j = $start; $j < min($index+$start, count($possibleUnspent)); $j++) {
                    $inputAmount += $possibleUnspent[$j]["amount"];
                }
            }                
            if ($inputAmount >= $tempAmountToSend) {
                $start += 1;
            } else {
                $index -= 1;
                $tempAmountToSend -= $possibleUnspent[$start-1]["amount"];
                array_push($txidsAndVouts, array("txid" => $possibleUnspent[$start-1]["txid"],
                                                 "vout" => $possibleUnspent[$start-1]["vout"]));
                if (!in_array($possibleUnspent[$start-1]["address"], $usedAddresses)) {
                    array_push($usedAddresses, $possibleUnspent[$start-1]["address"]);
                }
                $finalInputAmt += $possibleUnspent[$start-1]["amount"];
                $start += 1;
            }
        }

        $minerFee = min((80*count($txidsAndVouts) + 2*40 + 10)*$minerRate*0.00000001, $_MINER_FEE_BUFFER);
        if ($minerFee > $balance) {
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "insufficientBalance"));
        }

        $stashAddress = $bitcoin -> getnewaddress();
        $incomingAddress1 = $bitcoin -> getnewaddress();
        $incomingAddress2 = $bitcoin -> getnewaddress();
        if (!$stashAddress or !$incomingAddress1 or !$incomingAddress2) {
            $error = $bitcoin -> error;
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [6] - prepareTakeaway: {$error}");
        }

        $addressesAndAmounts = array(
            $stashAddress => round($amount, 8)
        );
        $changeAddress = false;

        if ($finalInputAmt - $amount - $minerFee > 0.0000543) {
            $changeAddress = $bitcoin -> getnewaddress();
            if (!$changeAddress) {
                $error = $bitcoin -> error;
                mysqli_close($connMixer);
                mysqli_close($connUsers);
                return array("echo" => array("success" => false, "reason" => "internal"),
                             "log"  => "{$ip} - {$date} - [error] [7] - prepareTakeaway: {$error}");
            }
            $addressesAndAmounts[$changeAddress] = round($finalInputAmt - $amount - $minerFee, 8);
        }

        shuffle($txidsAndVouts);
        $addressesAndAmounts = shuffle_assoc($addressesAndAmounts);

        $rawHash = $bitcoin -> createrawtransaction($txidsAndVouts, $addressesAndAmounts, 0, true);
        if (gettype($rawHash) != "string") {
            $error = $bitcoin -> error; 
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [8] - prepareTakeaway: {$error}");
        }

        $bitcoin  -> walletpassphrase($_U_WALLET_PASSPHRASE, 3);
        $stashKey = $bitcoin -> dumpprivkey($stashAddress);
        $signedTx = $bitcoin -> signrawtransaction($rawHash);

        if (gettype($signedTx) != "array" or !$stashKey) {
            $error = $bitcoin -> error;
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [9] - prepareTakeaway: {$error}");
        }

        mysqli_autocommit($connUsers, false);
        mysqli_autocommit($connMixer, false);

        if ($changeAddress) {
            $usedAddresses = implode("' OR address='", $usedAddresses);
            $query = "SELECT codes 
                      FROM {$_DB_MIXER_TABLE_U_ADDRESSES} 
                      WHERE address='{$usedAddresses}'";
            $select = mysqli_query($connMixer, $query);
            if (!$select) {
                $error = mysqli_error($connMixer);
                mysqli_rollback($connMixer);
                mysqli_rollback($connUsers);
                mysqli_close($connMixer);
                mysqli_close($connUsers);
                return array("echo" => array("success" => false, "reason" => "internal"),
                             "log"  => "{$ip} - {$date} - [error] [10] - prepareTakeaway: {$error}");
            }

            $codes = array();
            while ($row = mysqli_fetch_assoc($select)) {
                $codes = array_merge($codes, explode(";", $row["codes"]));
            }
            $codes = implode(";", array_unique(array_filter($codes)));
            if ($codes) {
                $query = "INSERT INTO {$_DB_MIXER_TABLE_U_ADDRESSES}
                      VALUES ('{$changeAddress}', '{$codes};', 'no')";

                if (!mysqli_query($connMixer, $query)) {
                    $error = mysqli_error($connMixer);
                    mysqli_rollback($connMixer);
                    mysqli_rollback($connUsers);
                    mysqli_close($connMixer);
                    mysqli_close($connUsers);
                    return array("echo" => array("success" => false, "reason" => "internal"),
                                 "log"  => "{$ip} - {$date} - [error] [11] - prepareTakeaway: {$error}");
                }
            }
        }

        $query1 = "INSERT INTO {$_DB_MIXER_TABLE_U_ADDRESSES}
                   VALUES ('{$incomingAddress1}', '{$code};', 'no')";
        $query2 = "INSERT INTO {$_DB_MIXER_TABLE_U_ADDRESSES}
                   VALUES ('{$incomingAddress2}', '{$code};', 'no')";
        $query3 = "INSERT INTO {$_DB_MIXER_TABLE_U_TAKEAWAY}
                   VALUES ('{$stashAddress}')";

        if (!mysqli_query($connMixer, $query1) or !mysqli_query($connMixer, $query2) or !mysqli_query($connMixer, $query3)) {
            $error = mysqli_error($connMixer);
            mysqli_rollback($connMixer);
            mysqli_rollback($connUsers);
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [12] - prepareTakeaway: {$error}");
        }

        $query = "UPDATE {$_DB_USERS_TABLE_ACCOUNTS}
                  SET dep_balance=dep_balance-{$minerFee}
                  WHERE login='{$login}'";
        if (!mysqli_query($connUsers, $query)) {
            $error = mysqli_error($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [13] - prepareTakeaway: {$error}");
        }

        $txid = $bitcoin -> sendrawtransaction($signedTx["hex"]);
        if (gettype($txid) != "string") {
            $error = $bitcoin -> error;
            mysqli_rollback($connMixer);
            mysqli_rollback($connUsers);
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [14] - prepareTakeaway: {$error}");
        }

        $id = hash("sha256", hash("sha256", $login.$code.$stashAddress.$txid.microtime(true)));
        $profit = round($amount*$commission*0.01, 8);
        $stashAmount = round($amount, 8);
        $unlockAmount = round($amount*(1 + $commission*0.01), 8);
        $creationTime = time();
        $minerFee = round($minerFee, 8);
        $query = "INSERT INTO {$_DB_MIXER_TABLE_USER_ORDERS}
                  VALUES ('{$id}',
                          '{$login}',
                          'locked',
                          '{$creationTime}',
                          '{$code}',
                          '{$commission}',
                          '{$profit}',
                          '{$stashAmount}',
                          '{$unlockAmount}',
                          '{$minerFee}',
                          '{$incomingAddress1}',
                          '{$incomingAddress2}',
                          '{$txid}',
                          '{$stashAddress}',
                          '{$stashKey}')";

        if (!mysqli_query($connMixer, $query)) {
            $error = mysqli_error($connMixer);
            mysqli_rollback($connMixer);
            mysqli_rollback($connUsers);
            mysqli_close($connMixer);
            mysqli_close($connUsers);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [15] - prepareTakeaway: {$error}");
        }

        mysqli_commit($connMixer);
        mysqli_commit($connUsers);
        mysqli_close($connMixer);
        mysqli_close($connUsers);

        $message = "Done for {$login}:".PHP_EOL;
        $orderInfo = array(
            "Stash address" => $stashAddress,
            "TXID" => $txid,
            "Incoming 1" => $incomingAddress1,
            "Incoming 2" => $incomingAddress2,
            "amount" => numberFormat($amount, 8),
            "profit" => numberFormat($profit, 8)
        );
        $message .= var_export($orderInfo, true);
        return array("echo" => array("success" => true, "ID" => "{$id}"),
                     "log"  => "{$ip} - {$date} - [notice] - prepareTakeaway: {$message}");
    }

    function isAddressWaiting($address, $connMixer) {
        global $_DB_MIXER_TABLE_USER_ORDERS;

        $query = "SELECT count(id) AS count
                  FROM {$_DB_MIXER_TABLE_USER_ORDERS}
                  WHERE incoming_address1='{$address}' OR incoming_address2='{$address}'";
        $result = mysqli_query($connMixer, $query);
        if (!$result) {
            return array("success" => false,
                         "error"   => mysqli_error($connMixer));
        }
        $arr = mysqli_fetch_assoc($result);
        return array("success" => true,
                     "waits"   => $arr["count"] > 0);
    }

    function isAddressForbidden($address, $code, $connMixer) {
        global $_DB_MIXER_TABLE_U_ADDRESSES;

        $query = "SELECT count(address) as count
                  FROM {$_DB_MIXER_TABLE_U_ADDRESSES} 
                  WHERE address = '{$address}' AND codes LIKE '%{$code}%'";
        $result = mysqli_query($connMixer, $query);
        if (!$result) {
            return array("success" => false,
                         "error"   => mysqli_error($connMixer));
        }
        $arr = mysqli_fetch_assoc($result);
        return array("success"   => true,
                     "forbidden" => $arr["count"] > 0);
    }

    function isAddressStashed($address, $connMixer) {
        global $_DB_MIXER_TABLE_U_TAKEAWAY;

        $query = "SELECT count(address) as count
                  FROM {$_DB_MIXER_TABLE_U_TAKEAWAY} 
                  WHERE address = '{$address}'";
        $result = mysqli_query($connMixer, $query);
        if (!$result) {
            return array("success" => false,
                         "error"   => mysqli_error($connMixer));
        }
        $arr = mysqli_fetch_assoc($result);
        return array("success" => true,
                     "stashed" => $arr["count"] > 0);
    }

    function listTakeaways($login) {
        global  $_SERVERNAME,
                $_MIXER_USERNAME,
                $_MIXER_PASSWORD,
                $_DB_MIXER,
                $_DB_MIXER_TABLE_USER_ORDERS;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        $connMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connMixer) {
            $error = mysqli_connect_error();
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [0] - listTakeaways: {$error}.");
        }

        $query = "SELECT id, status, stash_amount 
                  FROM {$_DB_MIXER_TABLE_USER_ORDERS}
                  WHERE login='{$login}'";
        $result = mysqli_query($connMixer, $query);
        if (!$result) {
            $error = mysqli_error($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [1] - listTakeaways: {$error}.");
        }
        $orders = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $order = array(
                "id" => $row["id"],
                "stash" => $row["stash_amount"],
                "status" => $row["status"]
            );
            array_push($orders, $order);
        }
        if (empty($orders)) {
            return array("echo" => array("success" => true, "description" => "empty"),
                         "log"  => "{$ip} - {$date} - [notice] - listTakeaways: User {$login} requested orders stats (empty).");
        }
        return array("echo" => array("success" => true, "description" => "full", "orders" => $orders),
                     "log"  => "{$ip} - {$date} - [notice] - listTakeaways: User {$login} requested orders stats (full).");
    }

    function selectOrderInfo($login, $ID) {
        global  $_SERVERNAME,
                $_MIXER_USERNAME,
                $_MIXER_PASSWORD,
                $_DB_MIXER,
                $_DB_MIXER_TABLE_USER_ORDERS;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        $connMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connMixer) {
            $error = mysqli_error($connMixer);
            return array("info" => array("success" => false),
                         "log"  => "{$ip} - {$date} - [error] [0] - selectOrderInfo: {$error}.");
        }

        $query = "SELECT status,
                         creation_time,
                         commission,
                         stash_amount,
                         unlock_amount,
                         miner_fee,
                         incoming_address1,
                         incoming_address2,
                         TXID,
                         stash_address,
                         stash_pkey
                  FROM {$_DB_MIXER_TABLE_USER_ORDERS}
                  WHERE login='{$login}' AND id=?";
        $stmt = mysqli_prepare($connMixer, $query);
        if (!$stmt) {
            $error = mysqli_error($connMixer);
            mysqli_close($connMixer);
            return array("info" => array("success" => false),
                         "log"  => "{$ip} - {$date} - [error] [1] - selectOrderInfo: {$error}.");
        }

        $incomingAddress1 = false;
        $incomingAddress2 = false;
        $unlockAmount = false;
        $creationTime = false;
        $stashAddress = false;
        $stashAmount = false;
        $commission = false;
        $stashKey = false;
        $minerFee = false;
        $status = false;
        $TXID = false;

        mysqli_stmt_bind_param($stmt, "s", $ID);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connMixer);
            mysqli_stmt_close($stmt);
            mysqli_close($connMixer);
            return array("info" => array("success" => false),
                         "log"  => "{$ip} - {$date} - [error] [2] - selectOrderInfo: {$error}.");
        }
        mysqli_stmt_bind_result($stmt, $status, 
                                       $creationTime, 
                                       $commission,
                                       $stashAmount, 
                                       $unlockAmount, 
                                       $minerFee, 
                                       $incomingAddress1, 
                                       $incomingAddress2, 
                                       $TXID,
                                       $stashAddress,
                                       $stashKey);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($connMixer);

        if ($status != "locked" and $status != "open") {
            return array("info" => array("success" => true, "exists" => false));
        }

        $order = array(
            "incomingAddress1" => $incomingAddress1,
            "incomingAddress2" => $incomingAddress2,
            "unlockAmount" => $unlockAmount,
            "creationTime" => $creationTime,
            "stashAddress" => $stashAddress,
            "stashAmount" => $stashAmount,
            "commission" => $commission,
            "stashKey" => $stashKey,
            "minerFee" => $minerFee,
            "status" => $status,
            "TXID" => $TXID
        );
        return array("info" => array("success" => true, "exists" => true, "order" => $order));
    }

    function generateTakeawayLetter($login, $ID) {
        global  $_MAIN_ACCOUNT,
                $_RPC_USER,
                $_RPC_PASSWORD,
                $_A_WALLET_PASSPHRASE,
                $_LOG_FILE_TAKEAWAYS;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];
        $data = selectOrderInfo($login, $ID);

        if (!$data["info"]["success"]) {
            file_put_contents($_LOG_FILE_TAKEAWAYS, $data["log"].PHP_EOL, FILE_APPEND);
            return false;
        }

        if (!$data["info"]["exists"]) {
            exit();
        }

        $orderInfo = $data["info"]["order"];
        $incomingAddress1 = $orderInfo["incomingAddress1"];
        $incomingAddress2 = $orderInfo["incomingAddress2"];
        $unlockAmount = numberFormat($orderInfo["unlockAmount"], 8);
        $creationTime = $orderInfo["creationTime"];
        $fromTime = date("j F Y, H:i:s T", $creationTime);
        $toTime = date("j F Y, H:i:s T", $creationTime + 12*60*60);
        $stashAddress = $orderInfo["stashAddress"];
        $stashAmount = numberFormat($orderInfo["stashAmount"], 8);
        $orderStatus = $orderInfo["status"];
        $commission = numberFormat($orderInfo["commission"]*1, 4);
        $TXID = $orderInfo["TXID"];

        $message = "We hereby confirm that WWW.BITWHISK.IO has created a Bitcoin transaction {$TXID} paying {$stashAmount} BTC to address {$stashAddress}. To unlock the private key of the above address you need to transfer the total of {$unlockAmount} BTC (including service commission {$commission}%) to the following addresses: {$incomingAddress1}, {$incomingAddress2}. This service will be available from {$fromTime} until {$toTime}. This letter is digitally signed by our main account: {$_MAIN_ACCOUNT}. Stay protected and thank you for using our service.";

        $bitcoin = new Bitcoin_anon($_RPC_USER, $_RPC_PASSWORD);
        if (!$bitcoin) {
            $logMessage = "{$ip} - {$date} - [error] [0] - generateTakeawayLetter: Could not connect to bitcoind.";
            file_put_contents($_LOG_FILE_TAKEAWAYS, $logMessage.PHP_EOL, FILE_APPEND);
            return false;
        }

        $bitcoin -> walletpassphrase($_A_WALLET_PASSPHRASE, 3);
        $signature = $bitcoin -> signmessage($_MAIN_ACCOUNT, $message);
        if ($signature === false) {
            $error = $bitcoin -> error;
            $logMessage = "{$ip} - {$date} - [error] [1] - generateTakeawayLetter: Signing message failed: {$error}.";
            file_put_contents($_LOG_FILE_TAKEAWAYS, $logMessage.PHP_EOL, FILE_APPEND);
            return false;
        }

        $letter = "-----START SIGNING BITCOIN ADDRESS-----\r\n{$_MAIN_ACCOUNT}\r\n-----END SIGNING BITCOIN ADDRESS-----\r\n\r\n-----START LETTER OF GUARANTEE-----\r\n{$message}\r\n-----END LETTER OF GUARANTEE-----\r\n\r\n-----START DIGITAL SIGNATURE-----\r\n{$signature}\r\n-----END DIGITAL SIGNATURE-----";

        $logMessage = "{$ip} - {$date} - [notice] - generateTakeawayLetter: Successfully generated an order LoG for user '{$login}'.";
        file_put_contents($_LOG_FILE_TAKEAWAYS, $logMessage.PHP_EOL, FILE_APPEND);

        return $letter;
    }

    function deleteTakeaway($login, $ID) {
        global  $_SERVERNAME,
                $_MIXER_USERNAME,
                $_MIXER_PASSWORD,
                $_DB_MIXER,
                $_DB_MIXER_TABLE_USER_ORDERS;

        $date = date("j F Y, H:i:s", time()+10800);
        $ip   = $_SERVER['REMOTE_ADDR'];

        $connMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connMixer) {
            $error = mysqli_error($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [0] - deleteTakeaway: {$error}.");
        }

        $query = "DELETE FROM {$_DB_MIXER_TABLE_USER_ORDERS}
                  WHERE login='{$login}' AND id=? AND status='open'";
        $stmt = mysqli_prepare($connMixer, $query);
        if (!$stmt) {
            $error = mysqli_error($connMixer);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [1] - deleteTakeaway: {$error}.");
        }

        mysqli_stmt_bind_param($stmt, "s", $ID);
        if (!mysqli_stmt_execute($stmt)) {
            $error = mysqli_error($connMixer);
            mysqli_stmt_close($stmt);
            mysqli_close($connMixer);
            return array("echo" => array("success" => false, "reason" => "internal"),
                         "log"  => "{$ip} - {$date} - [error] [2] - deleteTakeaway: {$error}.");
        }

        $affected = mysqli_affected_rows($connMixer); 
        mysqli_close($connMixer);

        $return = array(
            "echo" => array("success" => true)
        );
        if ($affected > 0) {
            $return["log"] = "{$ip} - {$date} - [notice] - deleteTakeaway: {$login} has successfully deleted order {$ID}.";
        } else {
            $return["log"] = "{$ip} - {$date} - [warning] - deleteTakeaway: Inappropriate try to delete order {$ID} from {$login}.";
        }

        return $return;
    }

    function cleanUserAddresses() {
        global  $_SERVERNAME,
                $_MIXER_USERNAME,
                $_MIXER_PASSWORD,
                $_DB_MIXER,
                $_DB_MIXER_TABLE_U_ADDRESSES,
                $_RPC_USER,
                $_RPC_PASSWORD;

        $date = date("j F Y, H:i:s", time()+10800);

        $connMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connMixer) {
            $error = mysqli_connect_error();
            echo "{$date} - [error] [0] - cleanUserAddresses: {$error}.".PHP_EOL;
            return;
        }

        $bitcoin = new Bitcoin_users($_RPC_USER, $_RPC_PASSWORD);
        if (!$bitcoin) {
            mysqli_close($connMixer);
            echo "{$date} - [error] [1] - cleanUserAddresses: Couldn't connect to bitcoind.".PHP_EOL;
            return;
        }

        $query = "SELECT address
                  FROM {$_DB_MIXER_TABLE_U_ADDRESSES}
                  WHERE accounted='no'";
        $result = mysqli_query($connMixer, $query);
        if (!$result) {
            $error = mysqli_error($connMixer);
            mysqli_close($connMixer);
            echo "{$date} - [error] [2] - cleanUserAddresses: {$error}.".PHP_EOL;
            return;
        }

        $toDelete = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $address = $row["address"];
            $info = isAddressWaiting($address, $connMixer);
            if (!$info["success"]) {
                mysqli_close($connMixer);
                echo "{$date} - [error] [3] - cleanUserAddresses: {$info["error"]}.".PHP_EOL;
                return;
            }
            if (!$info["waits"]) {
                $unspent = $bitcoin -> listunspent(0, 9999999, array($address));
                if ($unspent === false) {
                    $error = $bitcoin -> error;
                    mysqli_close($connMixer);
                    echo "{$date} - [error] [4] - cleanUserAddresses: {$error}.".PHP_EOL;
                    return;
                }
                if (empty($unspent)) {
                    array_push($toDelete, $address);
                }
            }
        }

        if (empty($toDelete)) {
            return;
        }

        $query = "DELETE FROM {$_DB_MIXER_TABLE_U_ADDRESSES}
                  WHERE address='".implode("' OR address='", $toDelete)."'";
        $check = mysqli_query($connMixer, $query);
        if (!$check) {
            $error = mysqli_error($connMixer);
            mysqli_close($connMixer);
            echo "{$date} - [error] [5] - cleanUserAddresses: {$error}.".PHP_EOL;
            return;
        }

        $number = count($toDelete);
        if ($number == 1) {
            echo "{$date} - [notice] - cleanUserAddresses: 1 user address was deleted.".PHP_EOL;
        } else {
            echo "{$date} - [notice] - cleanUserAddresses: {$number} user addresses were deleted.".PHP_EOL;
        }
    }

    function cleanTakeaways() {
        global  $_SERVERNAME,
                $_MIXER_USERNAME,
                $_MIXER_PASSWORD,
                $_DB_MIXER,
                $_DB_MIXER_TABLE_U_TAKEAWAY,
                $_RPC_USER,
                $_RPC_PASSWORD;

        $date = date("j F Y, H:i:s", time()+10800);

        $connMixer = mysqli_connect($_SERVERNAME, $_MIXER_USERNAME, $_MIXER_PASSWORD, $_DB_MIXER);
        if (!$connMixer) {
            $error = mysqli_connect_error();
            echo "{$date} - [error] [0] - cleanTakeaways: {$error}.".PHP_EOL;
            return;
        }

        $bitcoin = new Bitcoin_users($_RPC_USER, $_RPC_PASSWORD);
        if (!$bitcoin) {
            mysqli_close($connMixer);
            echo "{$date} - [error] [1] - cleanTakeaways: Couldn't connect to bitcoind.".PHP_EOL;
            return;
        }

        $query = "SELECT address 
                  FROM {$_DB_MIXER_TABLE_U_TAKEAWAY}";
        $result = mysqli_query($connMixer, $query);
        if (!$result) {
            $error = mysqli_error($connMixer);
            mysqli_close($connMixer);
            echo "{$date} - [error] [2] - cleanTakeaways: {$error}.".PHP_EOL;
            return;
        }

        $toDelete = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $address = $row["address"];
            $unspent = $bitcoin -> listunspent(0, 9999999, array($address));
            if ($unspent === false) {
                $error = $bitcoin -> error;
                mysqli_close($connMixer);
                echo "{$date} - [error] [3] - cleanTakeaways: {$error}.".PHP_EOL;
                return;
            }
            if (empty($unspent)) {
                array_push($toDelete, $address);
            }
        }

        if (empty($toDelete)) {
            return;
        }

        $query = "DELETE FROM {$_DB_MIXER_TABLE_U_TAKEAWAY}
                  WHERE address='".implode("' OR address='", $toDelete)."'";
        $check = mysqli_query($connMixer, $query);
        if (!$check) {
            $error = mysqli_error($connMixer);
            mysqli_close($connMixer);
            echo "{$date} - [error] [4] - cleanTakeaways: {$error}.".PHP_EOL;
            return;
        }

        $number = count($toDelete);
        if ($number == 1) {
            echo "{$date} - [notice] - cleanTakeaways: 1 stash address was deleted.".PHP_EOL;
        } else {
            echo "{$date} - [notice] - cleanTakeaways: {$number} stash addresses were deleted.".PHP_EOL;
        }
    }
?>