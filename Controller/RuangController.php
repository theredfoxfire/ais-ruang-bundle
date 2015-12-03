<?php

namespace Ais\RuangBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;

use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Ais\RuangBundle\Exception\InvalidFormException;
use Ais\RuangBundle\Form\RuangType;
use Ais\RuangBundle\Model\RuangInterface;


class RuangController extends FOSRestController
{
    /**
     * List all ruangs.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing ruangs.")
     * @Annotations\QueryParam(name="limit", requirements="\d+", default="5", description="How many ruangs to return.")
     *
     * @Annotations\View(
     *  templateVar="ruangs"
     * )
     *
     * @param Request               $request      the request object
     * @param ParamFetcherInterface $paramFetcher param fetcher service
     *
     * @return array
     */
    public function getRuangsAction(Request $request, ParamFetcherInterface $paramFetcher)
    {
        $offset = $paramFetcher->get('offset');
        $offset = null == $offset ? 0 : $offset;
        $limit = $paramFetcher->get('limit');

        return $this->container->get('ais_ruang.ruang.handler')->all($limit, $offset);
    }

    /**
     * Get single Ruang.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Gets a Ruang for a given id",
     *   output = "Ais\RuangBundle\Entity\Ruang",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the ruang is not found"
     *   }
     * )
     *
     * @Annotations\View(templateVar="ruang")
     *
     * @param int     $id      the ruang id
     *
     * @return array
     *
     * @throws NotFoundHttpException when ruang not exist
     */
    public function getRuangAction($id)
    {
        $ruang = $this->getOr404($id);

        return $ruang;
    }

    /**
     * Presents the form to use to create a new ruang.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  templateVar = "form"
     * )
     *
     * @return FormTypeInterface
     */
    public function newRuangAction()
    {
        return $this->createForm(new RuangType());
    }
    
    /**
     * Presents the form to use to edit ruang.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisRuangBundle:Ruang:editRuang.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the ruang id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when ruang not exist
     */
    public function editRuangAction($id)
    {
		$ruang = $this->getRuangAction($id);
		
        return array('form' => $this->createForm(new RuangType(), $ruang), 'ruang' => $ruang);
    }

    /**
     * Create a Ruang from the submitted data.
     *
     * @ApiDoc(
     *   resource = true,
     *   description = "Creates a new ruang from the submitted data.",
     *   input = "Ais\RuangBundle\Form\RuangType",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisRuangBundle:Ruang:newRuang.html.twig",
     *  statusCode = Codes::HTTP_BAD_REQUEST,
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     *
     * @return FormTypeInterface|View
     */
    public function postRuangAction(Request $request)
    {
        try {
            $newRuang = $this->container->get('ais_ruang.ruang.handler')->post(
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $newRuang->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_ruang', $routeOptions, Codes::HTTP_CREATED);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing ruang from the submitted data or create a new ruang at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Ais\RuangBundle\Form\RuangType",
     *   statusCodes = {
     *     201 = "Returned when the Ruang is created",
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisRuangBundle:Ruang:editRuang.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the ruang id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when ruang not exist
     */
    public function putRuangAction(Request $request, $id)
    {
        try {
            if (!($ruang = $this->container->get('ais_ruang.ruang.handler')->get($id))) {
                $statusCode = Codes::HTTP_CREATED;
                $ruang = $this->container->get('ais_ruang.ruang.handler')->post(
                    $request->request->all()
                );
            } else {
                $statusCode = Codes::HTTP_NO_CONTENT;
                $ruang = $this->container->get('ais_ruang.ruang.handler')->put(
                    $ruang,
                    $request->request->all()
                );
            }

            $routeOptions = array(
                'id' => $ruang->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_ruang', $routeOptions, $statusCode);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Update existing ruang from the submitted data or create a new ruang at a specific location.
     *
     * @ApiDoc(
     *   resource = true,
     *   input = "Ais\RuangBundle\Form\RuangType",
     *   statusCodes = {
     *     204 = "Returned when successful",
     *     400 = "Returned when the form has errors"
     *   }
     * )
     *
     * @Annotations\View(
     *  template = "AisRuangBundle:Ruang:editRuang.html.twig",
     *  templateVar = "form"
     * )
     *
     * @param Request $request the request object
     * @param int     $id      the ruang id
     *
     * @return FormTypeInterface|View
     *
     * @throws NotFoundHttpException when ruang not exist
     */
    public function patchRuangAction(Request $request, $id)
    {
        try {
            $ruang = $this->container->get('ais_ruang.ruang.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $ruang->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_ruang', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
    }

    /**
     * Fetch a Ruang or throw an 404 Exception.
     *
     * @param mixed $id
     *
     * @return RuangInterface
     *
     * @throws NotFoundHttpException
     */
    protected function getOr404($id)
    {
        if (!($ruang = $this->container->get('ais_ruang.ruang.handler')->get($id))) {
            throw new NotFoundHttpException(sprintf('The resource \'%s\' was not found.',$id));
        }

        return $ruang;
    }
    
    public function postUpdateRuangAction(Request $request, $id)
    {
		try {
            $ruang = $this->container->get('ais_ruang.ruang.handler')->patch(
                $this->getOr404($id),
                $request->request->all()
            );

            $routeOptions = array(
                'id' => $ruang->getId(),
                '_format' => $request->get('_format')
            );

            return $this->routeRedirectView('api_1_get_ruang', $routeOptions, Codes::HTTP_NO_CONTENT);

        } catch (InvalidFormException $exception) {

            return $exception->getForm();
        }
	}
}
