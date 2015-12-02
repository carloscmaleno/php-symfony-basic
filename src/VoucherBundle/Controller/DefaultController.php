<?php

namespace VoucherBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    /**
     * @Route("/code", name="codeIndex")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        return $this->render('VoucherBundle:Default:voucher.html.twig');
    }

    /**
     * @Route("/code", name="codeSubmit")
     * @Method("POST")
     */
    public function saveAction(Request $request)
    {
        $code = $request->get('voucher');

        if (empty($code)) {
            return $this->getAjaxResponse(false, 'Code not send');
        }

        $voucher_manager = $this->getDoctrine()->getEntityManager()->getRepository('VoucherBundle:Voucher');
        $voucher = $voucher_manager->findOneBy(array('code' => $code));

        if (empty($voucher) || $voucher->isUsed()) {
            return $this->getAjaxResponse(false, 'Code is used');
        } else {
            $voucher_service = $this->get('voucher.service');
            $voucher_service->saveVoucher($voucher);
        }


        if ($request->isXmlHttpRequest()) {

            return $this->getAjaxResponse(true);

        } else {
            return $this->redirect($this->generateUrl('codeIndex'));
        }
    }

    private function getAjaxResponse($status = false, $message = '')
    {
        $content = $this->renderView(
            'VoucherBundle:Default:ajax.html.twig',
            array(
                'status' => $status,
                'message' => $message
            )
        );
        $response = new Response($content, ($status ? 201 : 422));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
