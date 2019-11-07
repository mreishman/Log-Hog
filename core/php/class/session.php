<?php

/*
    Use the static method getInstance to get the object.
*/

class session extends Core
{
    const SESSION_STARTED = TRUE;
    const SESSION_NOT_STARTED = FALSE;

    // The state of the session
    private $sessionState = self::SESSION_NOT_STARTED;

    // THE only instance of the class
    private static $instance;

    //Here we store the old form key (more info at step 4)
    private $old_formKey;

    /**
    *    Returns THE instance of 'Session'.
    *    The session is automatically initialized if it wasn't.
    *
    *    @return    object
    **/

    public static function getInstance()
    {
        if ( !isset(self::$instance))
        {
            self::$instance = new self;
        }

        self::$instance->startSession();

        return self::$instance;
    }


    /**
    *    (Re)starts the session.
    *
    *    @return    bool    TRUE if the session has been initialized, else FALSE.
    **/

    public function startSession()
    {
        $sessionDir = $this->baseURL()."session/";
        if(!is_dir($sessionDir))
        {
            mkdir($sessionDir);
        }
        ini_set('session.save_path', $sessionDir);
        if ($this->sessionState == self::SESSION_NOT_STARTED )
        {
            $this->sessionState = session_start();
            if(!$this->__isset("form_key"))
            {
                $this->resetFormKey();
            }
        }

        return $this->sessionState;
    }


    /**
    *    Stores datas in the session.
    *    Example: $instance->foo = 'bar';
    *
    *    @param    name    Name of the datas.
    *    @param    value    Your datas.
    *    @return    void
    **/

    public function __set( $name , $value )
    {
        $_SESSION[$name] = $value;
    }


    /**
    *    Gets datas from the session.
    *    Example: echo $instance->foo;
    *
    *    @param    name    Name of the datas to get.
    *    @return    mixed    Datas stored in session.
    **/

    public function __get( $name )
    {
        if ( isset($_SESSION[$name]))
        {
            return $_SESSION[$name];
        }
    }


    public function __isset( $name )
    {
        return isset($_SESSION[$name]);
    }


    public function __unset( $name )
    {
        unset( $_SESSION[$name] );
    }


    /**
    *    Destroys the current session.
    *
    *    @return    bool    TRUE is session has been deleted, else FALSE.
    **/

    public function destroy()
    {
        if ( $this->sessionState == self::SESSION_STARTED )
        {
            $this->sessionState = !session_destroy();
            unset( $_SESSION );

            return !$this->sessionState;
        }

        return FALSE;
    }

    //Function to generate the form key
    private function generateKey()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $uniqid = uniqid(mt_rand(), true);
        return md5($ip . $uniqid);
    }

    public function resetFormKey()
    {
        $this->__set("form_key",$this->generateKey());
    }

    public function outputKey()
    {
        if($this->__isset("form_key"))
        {
            return $this->__get("form_key");
        }
        return null;
    }

    public function outputFormKey()
    {
        return "var formKey = \"".$this->outputKey()."\";";
    }

    //Function that validated the form key POST data
    public function validate()
    {
        //We use the old formKey and not the new generated version
        $formKey = false;
        if(isset($_POST["form_key"]))
        {
            $formKey = $_Post["form_key"];
        }
        elseif(isset($_POST["formKey"]))
        {
            $formKey = $_POST["formKey"];
        }
        if($formKey !== false && $formKey == $this->outputKey())
        {
            //The key is valid, return true.
            return true;
        }
        else
        {
            //The key is invalid, return false.
            return false;
        }
    }

    public function returnCurrentSelectedTheme()
    {
        return $this->returnCurrentSelectedThemeInner(true);
    }

    public function returnCurrentSelectedThemeAjax()
    {
        return $this->returnCurrentSelectedThemeInner(false);
    }

    public function returnCurrentSelectedThemeInner($jsError)
    {
        $baseBaseUrl = $this->baseURL();
        if(file_exists($baseBaseUrl.'local/layout.php') && is_readable($baseBaseUrl.'local/layout.php'))
        {
            include($baseBaseUrl.'local/layout.php');
            if(isset($currentSelectedTheme))
            {
                if(is_dir($baseBaseUrl . 'local/'.$currentSelectedTheme.'/')) {
                    return $currentSelectedTheme;
                } elseif(is_dir($baseBaseUrl . 'local/profiles/'.$currentSelectedTheme.'/')) {
                    return 'profiles/'.$currentSelectedTheme;
                } else {
                    if($jsError)
                    {
                        $this->echoErrorJavaScript("", "Error when getting current selected theme.", 9);
                    }
                    else
                    {
                        echo json_encode(array("error" => 9));
                        exit();
                    }
                }
            }
            else
            {
                if($jsError)
                {
                    $this->echoErrorJavaScript("", "Error when getting current selected theme.", 9);
                }
                else
                {
                    echo json_encode(array("error" => 9));
                    exit();
                }
            }
        }
        else
        {
            if($jsError)
            {
                $this->echoErrorJavaScript("", "Could not find local layout file. Please make sure that local/layout.php is setup correctly.", 7);
            }
            else
            {
                echo json_encode(array("error" => 7));
                exit();
            }
        }
    }
}