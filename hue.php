<?php

require( 'pest-master/PestJSON.php' );

class Hue
{
    private $bridge;
    private $key;


    public function __construct( $bridge, $key )
    {
        $this->bridge = $bridge;
        $this->key = $key;
    }


    private function makePest()
    {
        return new Pest( "http://" .$this->bridge. "/api/" .$this->key. "/" );
    }


    private function makeLightArray( $lightid )
    {
        $targets = array();

        if ( $lightid === false )
        {
            $targets = lightIds();
        }
        else
        {
            if ( !is_array( $lightid ) )
            {
                $targets[] = $lightid;
            }
            else
            {
                $targets = $lightid;
            }
        }

        return $targets;
    }


    // Registers with a Hue hub
    public function register()
    {
        $pest = new Pest( "http://" .$this->bridge. "/api" );
        $data = json_encode( array( 'devicetype' => 'phpHue' ) );
        $result = $pest->post( '', $data );

        return $result;
    }


    // Returns a state array of either a single or all your lights
    public function lightState( $lightid = false )
    {
        $result = array();
        $targets = $this->makeLightArray( $lightid );

        foreach ( $targets as $id )
        {
            $pest = $this->makePest();
            $deets = json_decode( $pest->get( "lights/$id" ), true );
            $result[$id] = $deets['state'];
        }

        return $result;
    }


    // Returns a name array of either a single or all your lights
    public function lightName( $lightid = false )
    {
        $result = array();
        $targets = $this->makeLightArray( $lightid );

        foreach ( $targets as $id )
        {
            $pest = $this->makePest();
            $deets = json_decode( $pest->get( "lights/$id" ), true );
            $result[$id] = $deets['name'];
        }

        return $result;
    }


    // Returns a bool indicating whether a particular light is turned on
    public function isLightOn( $lightid )
    {
        return $this->lightState( $lightid )[$lightid]['on'];
    }


    // Returns an array of the light numbers in the system
    public function lightIds()
    {
        $pest = $this->makePest();
        $result = json_decode( $pest->get( 'lights' ), true );
        $targets = array_keys( $result );

        return $targets;
    }


    // Sets the alert state of a single light. 'select' blinks once, 'lselect' blinks repeatedly, 'none' turns off blinking
    public function alertLight( $target, $type = 'select' )
    {
        $pest = $this->makePest();
        $data = json_encode(array( "alert" => $type ) );
        $result = $pest->put( "lights/$target/state", $data );

        return $result;
    }


    // Sets the state property of one or more lights
    public function setLight( $lightid, $input )
    {
        $result = '';
        $pest = $this->makePest();
        $data = json_encode( $input );
        $targets = $this->makeLightArray( $lightid );

        foreach ( $targets as $id )
        {
            $pest = new Pest( "http://" .$this->bridge. "/api/" .$this->key. "/" );
            $result .= $pest->put( "lights/$id/state", $data );
        }

        return $result;
    }


    // Gets the full state of the bridge
    public function state()
    {
        $pest = $this->makePest();
        $result = json_decode( $pest->get( "" ), true );

        return $result;
    }


    // Gets an array of currently configured schedules
    public function schedules()
    {
        $pest = $this->makePest();
        $result = json_decode( $pest->get( "schedules" ), true );

        return $result;
    }


    // Gin up a random color
    public function randomColor()
    {
        $return = array();

        $return['hue'] = rand( 0, 65535 );
        $return['sat'] = rand( 0, 254 );
        $return['bri'] = rand( 0, 254 );

        return $return;
    }


    // Gin up a random temp-based white setting
    public function randomWhite()
    {
        $return = array();
        $return['ct'] = rand( 150, 500 );
        $return['bri'] = rand( 0, 255 );

        return $return;
    }


    // Build a few color commands based on color names
    public function predefinedColors( $colorname )
    {
        $command = array();
        switch ( $colorname )
        {
            case "green":
                $command['hue'] = 182 * 140;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;

            case "red":
                $command['hue'] = 0;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;

            case "blue":
                $command['hue'] = 182 * 250;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;

            case "coolwhite":
                $command['ct']  = 150;
                $command['bri'] = 254;
                break;

            case "warmwhite":
                $command['ct']  = 500;
                $command['bri'] = 254;
                break;

            case "orange":
                $command['hue'] = 182 * 25;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;

            case "yellow":
                $command['hue'] = 182 * 85;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;

            case "pink":
                $command['hue'] = 182 * 300;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;

            case "purple":
                $command['hue'] = 182 * 270;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;
        }

        return $command;
    }
}

?>
