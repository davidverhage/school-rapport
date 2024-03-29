<?php

/**
 * OO cURL Class
 * Object oriented wrapper for the cURL library.
 * @author David Hopkins (semlabs.co.uk)
 * @version 0.3
 */
class CURL
{

    public $sessions = array();
    public $retry = 3;

    /**
     * Adds a cURL session to stack
     * @param $url string, session's URL
     * @param $opts array, optional array of cURL options and values
     */
    public function addSession($url, $opts = false)
    {
        $this->sessions[] = curl_init($url);
        if (!$opts) {
            $opts = $this->defaultOpts();
        }

        $key = count($this->sessions) - 1;
        $this->setOpts($opts, $key);
    }

    public function defaultOpts()
    {
        $header = array(
            "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
            "Accept-Language: en-gb,en;q=0.5",
            //"Accept-Encoding: gzip,deflate",
            "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7",
            "Keep-Alive: 300",
            "Connection: keep-alive"
        );

        return array(
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_USERAGENT => "Mozilla/5.0 (X11; U; Linux i686; en-GB; rv:1.8.1.14) Gecko/20080418 Ubuntu/7.10 (gutsy) Firefox/2.0.0.14",
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_VERBOSE => false
        );
    }

    /**
     * Sets an array of options to a cURL session
     * @param $options array, array of cURL options and values
     * @param $key int, session key to set option for
     */
    public function setOpts($options, $key = 0)
    {
        curl_setopt_array($this->sessions[$key], $options);
    }

    /**
     * Sets an option to a cURL session
     * @param $option constant, cURL option
     * @param $value mixed, value of option
     * @param $key int, session key to set option for
     */
    public function setOpt($option, $value, $key = 0)
    {
        curl_setopt($this->sessions[$key], $option, $value);
    }

    /**
     * Executes as cURL session
     * @param $key int, optional argument if you only want to execute one session
     */
    public function exec($key = false)
    {
        $no = count($this->sessions);

        if ($no == 1)
            $res = $this->execSingle();
        elseif ($no > 1) {
            if ($key === false)
                $res = $this->execMulti();
            else
                $res = $this->execSingle($key);
        }

        if ($res)
            return $res;
    }

    /**
     * Executes a single cURL session
     * @param $key int, id of session to execute
     * @return array of content if CURLOPT_RETURNTRANSFER is set
     */
    public function execSingle($key = 0)
    {
        if ($this->retry > 0) {
            $retry = $this->retry;
            $code = 0;
            while ($retry >= 0 && ($code[0] == 0 || $code[0] >= 400)) {
                $res = curl_exec($this->sessions[$key]);

                $code = $this->info($key, CURLINFO_HTTP_CODE);

                $retry--;
            }
        } else
            $res = curl_exec($this->sessions[$key]);

        return $res;
    }

    /**
     * Returns an array of session information
     * @param $key int, optional session key to return info on
     * @param $opt constant, optional option to return
     */
    public function info($key = false, $opt = false)
    {
        if ($key === false) {
            foreach ($this->sessions as $key => $session) {
                if ($opt)
                    $info[] = curl_getinfo($this->sessions[$key], $opt);
                else
                    $info[] = curl_getinfo($this->sessions[$key]);
            }
        } else {
            if ($opt)
                $info[] = curl_getinfo($this->sessions[$key], $opt);
            else
                $info[] = curl_getinfo($this->sessions[$key]);
        }

        return $info;
    }

    /**
     * Executes a stack of sessions
     * @return array of content if CURLOPT_RETURNTRANSFER is set
     */
    public function execMulti()
    {
        $mh = curl_multi_init();

        #Add all sessions to multi handle
        foreach ($this->sessions as $i => $url)
            curl_multi_add_handle($mh, $this->sessions[$i]);

        do
            $mrc = curl_multi_exec($mh, $active);
        while ($mrc == CURLM_CALL_MULTI_PERFORM);

        while ($active && $mrc == CURLM_OK) {
            if (curl_multi_select($mh) != -1) {
                do
                    $mrc = curl_multi_exec($mh, $active);
                while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }
        if ($mrc != CURLM_OK)
            echo "Curl multi read error $mrc\n";

        #Get content foreach session, retry if applied
        foreach ($this->sessions as $i => $url) {
            $code = $this->info($i, CURLINFO_HTTP_CODE);
            if ($code[0] > 0 && $code[0] < 400)
                $res[] = curl_multi_getcontent($this->sessions[$i]);
            else {
                if ($this->retry > 0) {
                    $retry = $this->retry;
                    $this->retry -= 1;
                    $eRes = $this->execSingle($i);

                    if ($eRes)
                        $res[] = $eRes;
                    else
                        $res[] = false;

                    $this->retry = $retry;
                    //echo '1';
                } else
                    $res[] = false;
            }
            curl_multi_remove_handle($mh, $this->sessions[$i]);
        }
        curl_multi_close($mh);

        return $res;
    }

    /**
     * Closes cURL sessions
     * @param $key int, optional session to close
     */
    public function close($key = false)
    {
        if ($key === false) {
            foreach ($this->sessions as $session)
                curl_close($session);
        } else
            curl_close($this->sessions[$key]);
    }

    /**
     * Remove all cURL sessions
     */
    public function clear()
    {
        foreach ($this->sessions as $session)
            curl_close($session);
        unset($this->sessions);
    }

    /**
     * Returns an array of errors
     * @param $key int, optional session key to retun error on
     * @return array of error messages
     */
    public function error($key = false)
    {
        if ($key === false) {
            foreach ($this->sessions as $session)
                $errors[] = curl_error($session);
        } else
            $errors[] = curl_error($this->sessions[$key]);

        return $errors;
    }

    /**
     * Returns an array of session error numbers
     * @param $key int, optional session key to retun error on
     * @return array of error codes
     */
    public function errorNo($key = false)
    {
        if ($key === false) {
            foreach ($this->sessions as $session)
                $errors[] = curl_errno($session);
        } else
            $errors[] = curl_errno($this->sessions[$key]);

        return $errors;
    }

}