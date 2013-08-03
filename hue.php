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


    // Registers with a Hue hub
    function register()
    {
        $pest = new Pest( "http://" .$this->bridge. "/api" );
        $data = json_encode( array( 'devicetype' => 'phpHue' ) );
        $result = $pest->post( '', $data );

        return $result;
    }


    // Returns a state array of either a single bulb or all your lights
    function getLightState( $lightid = false )
    {
        $targets = array();
        $result = array();

        if ( $lightid === false )
        {
            $targets = getLightIds();
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

        foreach ( $targets as $id )
        {
            $pest = new Pest( "http://" .$this->bridge. "/api/" .$this->key. "/" );
            $deets = json_decode( $pest->get( "lights/$id" ), true );
            $state = $deets['state'];

            $result[$id] = $state;
        }

        return $result;
    }


    // Returns an array of the light numbers in the system
    function getLightIds()
    {
        $pest = new Pest( "http://" .$this->bridge. "/api/" .$this->key. "/" );
        $result = json_decode( $pest->get( 'lights' ), true );
        $targets = array_keys( $result );

        return $targets;
    }


    // Sets the alert state of a single light. 'select' blinks once, 'lselect' blinks repeatedly, 'none' turns off blinking
    function alertLight( $target, $type = 'select' )
    {
        $pest = new Pest( "http://" .$this->bridge. "/api/" .$this->key. "/" );
        $data = json_encode(array( "alert" => $type ) );
        $result = $pest->put( "lights/$target/state", $data );

        return $result;
    }


    // Sets the state property of one or more lights
    function setLight( $lightid, $input )
    {
        $pest = new Pest( "http://" .$this->bridge. "/api/" .$this->key. "/" );
        $data = json_encode( $input );
        $result = '';

        if ( is_array( $lightid ) )
        {
            foreach ( $lightid as $id )
            {
                $pest = new Pest( "http://" .$this->bridge. "/api/" .$this->key. "/" );
                $result .= $pest->put( "lights/$id/state", $data );
            }
        }
        else
        {
            $result = $pest->put( "lights/$lightid/state", $data );
        }

        return $result;
    }


    // Gin up a random color
    function getRandomColor()
    {
        $return = array();

        $return['hue'] = rand( 0, 65535 );
        $return['sat'] = rand( 0, 254 );
        $return['bri'] = rand( 0, 254 );

        return $return;
    }


    // Gin up a random temp-based white setting
    function getRandomWhite()
    {
        $return = array();
        $return['ct'] = rand( 150, 500 );
        $return['bri'] = rand( 0, 255 );

        return $return;
    }


    // Build a few color commands based on color names
    function predefinedColors( $colorname )
    {
        $command = array();
        switch ( $colorname )
        {
            case "green":
                $command['hue'] =  182 * 140;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;

            case "red":
                $command['hue'] =  0;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;

            case "blue":
                $command['hue'] =  182 * 250;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;

            case "coolwhite":
                $command['ct'] =  150;
                $command['bri'] = 254;
                break;

            case "warmwhite":
                $command['ct'] =  500;
                $command['bri'] = 254;
                break;

            case "purple":
                $command['hue'] =  182 * 270;
                $command['sat'] = 254;
                $command['bri'] = 254;
                break;
        }

        return $command;
    }
}

?>
