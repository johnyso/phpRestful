<?php

/**
 * Request class.
 *
 * @package api-framework
 * @author  Martin Bean <martin@martinbean.co.uk>
 */
class Request
{
    /**
     * URL elements.
     *
     * @var array
     */
    public $url_elements = array();

    /**
     * The HTTP method used.
     *
     * @var string
     */
    public $method;

    /**
     * Any parameters sent with the request.
     *
     * @var array
     */
    public $parameters;

    /**
     * URL Elements with id
     *
     * @var array
     */
    public $elements;

    public $vPosFile = 'data/vposition.txt';

    public $hPosFile = 'data/hposition.txt';

    public $speed = ' 5000000 ';

    //Motor 0
    public $stepperHorizontal = " 42 41 44 43";

    public $horizontalDegree = 0.5;

    //Motor 1
    public $stepperVertical = " 2 19 18 40 ";

    public $verticalDegree = 10;

    public function executeStepper($direction, $degree)
    {
        // make execution
        if (!$_SERVER['REMOTE_ADDR'] = "restful.local") {
            shell_exec("nodeStepper" . $this->speed . $degree . " " . $direction . $this->stepperHorizontal);
        } else {
            $currentPos = $this->getPosition(0);
            //$this->writePosition(0,(int)$currentPos - (int)$degree);
        }
    }

    public function executeStepperDegree($motor, $degree)
    {
        // For Horizontal Motor
        if ($motor == 0 && $degree <= 180 && $degree >= 0) {
            $currentPos = $this->getPosition($motor);
            if ($currentPos > $degree) {
                $steps = $currentPos - (int)$degree;
                $this->writePosition($motor, $degree);
                shell_exec("nodeStepper" . $this->speed . (int)($steps * $this->horizontalDegree) . " " . 0 . $this->stepperHorizontal);

            } else if ($currentPos < $degree) {
                $steps = (int)$degree - $currentPos;
                $this->writePosition($motor, $degree);
                shell_exec("nodeStepper" . $this->speed . (int)($steps * $this->horizontalDegree) . " " . 1 . $this->stepperHorizontal);

            }
        } elseif ($motor == 1 && $degree <=80 && $degree >=0){
            $currentPos = $this->getPosition($motor);
            if ($currentPos > $degree) {
                $steps = $currentPos - (int)$degree;
                $this->writePosition($motor, $degree);
                shell_exec("nodeStepper" . $this->speed . (int)($steps * $this->verticalDegree) . " " . 1 . $this->stepperVertical);

            } else if ($currentPos < $degree) {
                $steps = (int)$degree - $currentPos;
                $this->writePosition($motor, $degree);
                shell_exec("nodeStepper" . $this->speed . (int)($steps * $this->verticalDegree) . " " . 0 . $this->stepperVertical);

            }
        }
    }


    public function getPosition($motor)
    {
        $file = $this->getFile($motor);

        if (file_exists($file) && is_file($file)) {
            $fileX = fopen($file, "r");
            while (($line = fgets($fileX)) !== false) {
                $strings = explode("-", $line);
                $position = $strings[1];
            }
            return $position;
            fclose($fileX);
            fclose($file);
        }
    }

    public function writePosition($motor, $position)
    {
        $file = $this->getFile($motor);
        file_put_contents($file, "position-" . $position);
    }

    public function getFile($motor) {
        if($motor == 0) {
            return $this->hPosFile;
        }
        if($motor == 1){
            return $this->vPosFile;
        }
    }
}
