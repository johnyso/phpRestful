<?php

class VerticalController extends AbstractController
{
    /**
     * GET method.
     *
     * @param  Request $request
     * @return string
     */
    public function get($request)
    {
        $degree = $request->elements[0][1];
        switch (count($request->elements[0])) {
            case 1:
                return "get horizontal alignment";
                break;
            case 2:
                $request->executeStepperDegree(1,$degree);
                return "go to position ". $degree;
                break;
        }
    }

    /**
     * PUT method.
     *
     * @param  Request $request
     * @return string
     */
    public function put($request)
    {
        return "not implemented";
    }
}