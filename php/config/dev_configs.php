<?php
    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Bitcoind parameters \\
    $_MAIN_ACCOUNT         = "mhzYJQXFSLbDDcT5qSp8cmqxH6RdxjbVMq";
    $_RPC_USER             = "user1";
    $_RPC_PASSWORD         = "koalasralanadereve";
    $_A_WALLET_PASSPHRASE  = "Koalasralanadereve";
    $_U_WALLET_PASSPHRASE  = "Mounik";

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Logs \\
    $_LOG_FILE_OPERATIONS  = __DIR__."/../../logs/operations.log";
    $_LOG_FILE_TAKEAWAYS   = __DIR__."/../../logs/takeaways.log";
    $_LOG_FILE_AUTH        = __DIR__."/../../logs/auth.log";

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Server information \\
    $_SERVERNAME        = "127.0.0.1";
    $_MIXER_USERNAME    = "mixer_master";
    $_MIXER_PASSWORD    = "ebtvoumat";
    $_SESSIONS_USERNAME = "session_master";
    $_SESSIONS_PASSWORD = "huivrot";
    $_USERS_USERNAME    = "users_master";
    $_USERS_PASSWORD    = "pizda";

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Mixer DB \\
    $_DB_MIXER                   = "mixer";
    $_DB_MIXER_TABLE_OPEN_ORDERS = "anon_open_orders";
    $_DB_MIXER_TABLE_PROC_ORDERS = "anon_proc_orders";
    $_DB_MIXER_TABLE_USER_ORDERS = "users_orders";
    $_DB_MIXER_TABLE_A_ADDRESSES = "anon_addresses";
    $_DB_MIXER_TABLE_U_ADDRESSES = "users_addresses";
    $_DB_MIXER_TABLE_U_TAKEAWAY  = "users_takeaway";
    $_DB_MIXER_TABLE_I_ADDRESSES = "invest_addresses";
    $_DB_MIXER_TABLE_CODES       = "codes";
    $_DB_MIXER_TABLE_INFO        = "info";
    $_DB_MIXER_TABLE_STATS       = "statistics";

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Sessions DB \\
    $_DB_SESSIONS               = "sessions";
    $_DB_SESSIONS_TABLE_AUTH    = "authorization";
    $_DB_SESSIONS_TABLE_CAPTCHA = "captcha";

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Users DB \\
    $_DB_USERS                  = "users";
    $_DB_USERS_TABLE_ACCOUNTS   = "accounts";
    $_DB_USERS_TABLE_VERIF      = "verification";
    $_DB_USERS_TABLE_TWOFACTOR  = "two_factor";
    $_DB_USERS_TABLE_RESTORE    = "restore_codes";
    $_DB_USERS_TABLE_WITHDRAW   = "withdraws";

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Rules of service \\
    $_OUR_CAPITAL          = 20;
    $_TRUSTED_CONFIRMS     = 2;
    $_MAX_UNCONF_BLOCKS    = 5;
    $_TESTNET              = true;
    $_MIN_LENGTH_SESS_ID   = 50;
    $_MAX_LENGTH_SESS_ID   = 60;
    $_MIN_LENGTH_VER_CODE  = 10;
    $_MAX_LENGTH_VER_CODE  = 15;
    $_MIN_LENGTH_RES_CODE  = 18;
    $_MAX_LENGTH_RES_CODE  = 20;
    $_MIN_LENGTH_SIGN_CODE = 25;
    $_MAX_LENGTH_SIGN_CODE = 30;
    $_RCODE_ACTIVE_PERIOD  = 3600;
    $_MINER_FEE_BUFFER     = 0.001;

    //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Bitcoin class \\
    class Bitcoin_anon {
        // Configuration options
        private $username;
        private $password;
        private $proto;
        private $host;
        private $port;
        private $url;
        private $CACertificate;
        // Information and debugging
        public $status;
        public $error;
        public $raw_response;
        public $response;
        private $id = 0;
        /**
         * @param string $username
         * @param string $password
         * @param string $host
         * @param int $port
         * @param string $proto
         * @param string $url
         */
        public function __construct($username, $password, $host = 'localhost', $port = 18332, $url = 'wallet/wallet_anon.dat')
        {
            $this->username      = $username;
            $this->password      = $password;
            $this->host          = $host;
            $this->port          = $port;
            $this->url           = $url;
            // Set some defaults
            $this->proto         = 'http';
            $this->CACertificate = null;
        }
        /**
         * @param string|null $certificate
         */
        public function setSSL($certificate = null)
        {
            $this->proto         = 'https'; // force HTTPS
            $this->CACertificate = $certificate;
        }
        public function __call($method, $params)
        {
            $this->status       = null;
            $this->error        = null;
            $this->raw_response = null;
            $this->response     = null;
            // If no parameters are passed, this will be an empty array
            $params = array_values($params);
            // The ID should be unique for each call
            $this->id++;
            // Build the request, it's ok that params might have any empty array
            $request = json_encode(array(
                'method' => $method,
                'params' => $params,
                'id'     => $this->id
            ));
            // Build the cURL session
            $curl    = curl_init("{$this->proto}://{$this->host}:{$this->port}/{$this->url}");
            $options = array(
                CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
                CURLOPT_USERPWD        => $this->username . ':' . $this->password,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_HTTPHEADER     => array('Content-type: application/json'),
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $request
            );
            // This prevents users from getting the following warning when open_basedir is set:
            // Warning: curl_setopt() [function.curl-setopt]:
            //   CURLOPT_FOLLOWLOCATION cannot be activated when in safe_mode or an open_basedir is set
            if (ini_get('open_basedir')) {
                unset($options[CURLOPT_FOLLOWLOCATION]);
            }
            if ($this->proto == 'https') {
                // If the CA Certificate was specified we change CURL to look for it
                if (!empty($this->CACertificate)) {
                    $options[CURLOPT_CAINFO] = $this->CACertificate;
                    $options[CURLOPT_CAPATH] = DIRNAME($this->CACertificate);
                } else {
                    // If not we need to assume the SSL cannot be verified
                    // so we set this flag to FALSE to allow the connection
                    $options[CURLOPT_SSL_VERIFYPEER] = false;
                }
            }
            curl_setopt_array($curl, $options);
            // Execute the request and decode to an array
            $this->raw_response = curl_exec($curl);
            $this->response     = json_decode($this->raw_response, true);
            // If the status is not 200, something is wrong
            $this->status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            // If there was no error, this will be an empty string
            $curl_error = curl_error($curl);
            curl_close($curl);
            if (!empty($curl_error)) {
                $this->error = $curl_error;
            }
            if ($this->response['error']) {
                // If bitcoind returned an error, put that in $this->error
                $this->error = $this->response['error']['message'];
            } elseif ($this->status != 200) {
                // If bitcoind didn't return a nice error message, we need to make our own
                switch ($this->status) {
                    case 400:
                        $this->error = 'HTTP_BAD_REQUEST';
                        break;
                    case 401:
                        $this->error = 'HTTP_UNAUTHORIZED';
                        break;
                    case 403:
                        $this->error = 'HTTP_FORBIDDEN';
                        break;
                    case 404:
                        $this->error = 'HTTP_NOT_FOUND';
                        break;
                }
            }
            if ($this->error) {
                return false;
            }
            return $this->response['result'];
        }
    }

    class Bitcoin_users {
        // Configuration options
        private $username;
        private $password;
        private $proto;
        private $host;
        private $port;
        private $url;
        private $CACertificate;
        // Information and debugging
        public $status;
        public $error;
        public $raw_response;
        public $response;
        private $id = 0;
        /**
         * @param string $username
         * @param string $password
         * @param string $host
         * @param int $port
         * @param string $proto
         * @param string $url
         */
        public function __construct($username, $password, $host = 'localhost', $port = 18332, $url = 'wallet/wallet_users.dat')
        {
            $this->username      = $username;
            $this->password      = $password;
            $this->host          = $host;
            $this->port          = $port;
            $this->url           = $url;
            // Set some defaults
            $this->proto         = 'http';
            $this->CACertificate = null;
        }
        /**
         * @param string|null $certificate
         */
        public function setSSL($certificate = null)
        {
            $this->proto         = 'https'; // force HTTPS
            $this->CACertificate = $certificate;
        }
        public function __call($method, $params)
        {
            $this->status       = null;
            $this->error        = null;
            $this->raw_response = null;
            $this->response     = null;
            // If no parameters are passed, this will be an empty array
            $params = array_values($params);
            // The ID should be unique for each call
            $this->id++;
            // Build the request, it's ok that params might have any empty array
            $request = json_encode(array(
                'method' => $method,
                'params' => $params,
                'id'     => $this->id
            ));
            // Build the cURL session
            $curl    = curl_init("{$this->proto}://{$this->host}:{$this->port}/{$this->url}");
            $options = array(
                CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
                CURLOPT_USERPWD        => $this->username . ':' . $this->password,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_HTTPHEADER     => array('Content-type: application/json'),
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $request
            );
            // This prevents users from getting the following warning when open_basedir is set:
            // Warning: curl_setopt() [function.curl-setopt]:
            //   CURLOPT_FOLLOWLOCATION cannot be activated when in safe_mode or an open_basedir is set
            if (ini_get('open_basedir')) {
                unset($options[CURLOPT_FOLLOWLOCATION]);
            }
            if ($this->proto == 'https') {
                // If the CA Certificate was specified we change CURL to look for it
                if (!empty($this->CACertificate)) {
                    $options[CURLOPT_CAINFO] = $this->CACertificate;
                    $options[CURLOPT_CAPATH] = DIRNAME($this->CACertificate);
                } else {
                    // If not we need to assume the SSL cannot be verified
                    // so we set this flag to FALSE to allow the connection
                    $options[CURLOPT_SSL_VERIFYPEER] = false;
                }
            }
            curl_setopt_array($curl, $options);
            // Execute the request and decode to an array
            $this->raw_response = curl_exec($curl);
            $this->response     = json_decode($this->raw_response, true);
            // If the status is not 200, something is wrong
            $this->status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            // If there was no error, this will be an empty string
            $curl_error = curl_error($curl);
            curl_close($curl);
            if (!empty($curl_error)) {
                $this->error = $curl_error;
            }
            if ($this->response['error']) {
                // If bitcoind returned an error, put that in $this->error
                $this->error = $this->response['error']['message'];
            } elseif ($this->status != 200) {
                // If bitcoind didn't return a nice error message, we need to make our own
                switch ($this->status) {
                    case 400:
                        $this->error = 'HTTP_BAD_REQUEST';
                        break;
                    case 401:
                        $this->error = 'HTTP_UNAUTHORIZED';
                        break;
                    case 403:
                        $this->error = 'HTTP_FORBIDDEN';
                        break;
                    case 404:
                        $this->error = 'HTTP_NOT_FOUND';
                        break;
                }
            }
            if ($this->error) {
                return false;
            }
            return $this->response['result'];
        }
    }

    class Bitcoin_invest {
        // Configuration options
        private $username;
        private $password;
        private $proto;
        private $host;
        private $port;
        private $url;
        private $CACertificate;
        // Information and debugging
        public $status;
        public $error;
        public $raw_response;
        public $response;
        private $id = 0;
        /**
         * @param string $username
         * @param string $password
         * @param string $host
         * @param int $port
         * @param string $proto
         * @param string $url
         */
        public function __construct($username, $password, $host = 'localhost', $port = 18332, $url = 'wallet/wallet_investors.dat')
        {
            $this->username      = $username;
            $this->password      = $password;
            $this->host          = $host;
            $this->port          = $port;
            $this->url           = $url;
            // Set some defaults
            $this->proto         = 'http';
            $this->CACertificate = null;
        }
        /**
         * @param string|null $certificate
         */
        public function setSSL($certificate = null)
        {
            $this->proto         = 'https'; // force HTTPS
            $this->CACertificate = $certificate;
        }
        public function __call($method, $params)
        {
            $this->status       = null;
            $this->error        = null;
            $this->raw_response = null;
            $this->response     = null;
            // If no parameters are passed, this will be an empty array
            $params = array_values($params);
            // The ID should be unique for each call
            $this->id++;
            // Build the request, it's ok that params might have any empty array
            $request = json_encode(array(
                'method' => $method,
                'params' => $params,
                'id'     => $this->id
            ));
            // Build the cURL session
            $curl    = curl_init("{$this->proto}://{$this->host}:{$this->port}/{$this->url}");
            $options = array(
                CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
                CURLOPT_USERPWD        => $this->username . ':' . $this->password,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_HTTPHEADER     => array('Content-type: application/json'),
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $request
            );
            // This prevents users from getting the following warning when open_basedir is set:
            // Warning: curl_setopt() [function.curl-setopt]:
            //   CURLOPT_FOLLOWLOCATION cannot be activated when in safe_mode or an open_basedir is set
            if (ini_get('open_basedir')) {
                unset($options[CURLOPT_FOLLOWLOCATION]);
            }
            if ($this->proto == 'https') {
                // If the CA Certificate was specified we change CURL to look for it
                if (!empty($this->CACertificate)) {
                    $options[CURLOPT_CAINFO] = $this->CACertificate;
                    $options[CURLOPT_CAPATH] = DIRNAME($this->CACertificate);
                } else {
                    // If not we need to assume the SSL cannot be verified
                    // so we set this flag to FALSE to allow the connection
                    $options[CURLOPT_SSL_VERIFYPEER] = false;
                }
            }
            curl_setopt_array($curl, $options);
            // Execute the request and decode to an array
            $this->raw_response = curl_exec($curl);
            $this->response     = json_decode($this->raw_response, true);
            // If the status is not 200, something is wrong
            $this->status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            // If there was no error, this will be an empty string
            $curl_error = curl_error($curl);
            curl_close($curl);
            if (!empty($curl_error)) {
                $this->error = $curl_error;
            }
            if ($this->response['error']) {
                // If bitcoind returned an error, put that in $this->error
                $this->error = $this->response['error']['message'];
            } elseif ($this->status != 200) {
                // If bitcoind didn't return a nice error message, we need to make our own
                switch ($this->status) {
                    case 400:
                        $this->error = 'HTTP_BAD_REQUEST';
                        break;
                    case 401:
                        $this->error = 'HTTP_UNAUTHORIZED';
                        break;
                    case 403:
                        $this->error = 'HTTP_FORBIDDEN';
                        break;
                    case 404:
                        $this->error = 'HTTP_NOT_FOUND';
                        break;
                }
            }
            if ($this->error) {
                return false;
            }
            return $this->response['result'];
        }
    }
?>