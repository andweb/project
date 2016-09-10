<?php

namespace ProjectBundle\Controller;

use ProjectBundle\Entity\Address;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class AddressesController extends Controller
{
    /**
     * @return array
     * @View
     */
    public function getAddressesAction(Request $request)
    {
        return $this->getDoctrine()->getRepository('ProjectBundle:Address')->find($request);
    }
}
