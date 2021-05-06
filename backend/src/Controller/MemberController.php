<?php

namespace App\Controller;

use App\{
    Exception\FormException,
    Manager\MemberManager,
    Utils\ErrorFormatter
};
use FOS\RestBundle\{Controller\AbstractFOSRestController,
    Controller\Annotations as Rest,
    Request\ParamFetcher,
    Request\ParamFetcherInterface,
    View\View
};
use Psr\Log\LoggerInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MemberController
 *
 * @Rest\Route("2wls/api/member")
 */
class MemberController extends AbstractFOSRestController
{
    /**
     * @var MemberManager
     */
    private $memberManager;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * MemberController constructor.
     *
     * @param MemberManager   $memberManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        MemberManager $memberManager,
        LoggerInterface $logger
    )
    {
        $this->memberManager = $memberManager;
        $this->logger = $logger;
    }

    /**
     * @param ParamFetcherInterface $paramFetcher
     *
     * Create new member
     *
     * @SWG\Tag(name="member")
     * @SWG\Response(
     *     response=201,
     *     description="Create new member")
     *
     * @Rest\Post(name="api_member_post")
     *
     * @Rest\RequestParam(name="name", description="member name", nullable=true)
     * @Rest\RequestParam(name="lastName", description="member last name", strict=true, nullable=true)
     * @Rest\RequestParam(name="dateOfBirth", description="member date of birth", strict=true, nullable=false)
     * @Rest\RequestParam(name="phone", description="member phone", strict=true, nullable=true)
     * @Rest\RequestParam(name="country", description="member phone", strict=true, nullable=true)
     * @Rest\RequestParam(name="sex", description="member sex", strict=true, nullable=true)
     *
     * @return View
     */
    public function createMember(ParamFetcherInterface $paramFetcher): View
    {
        try {
            $member = $this->memberManager->create($paramFetcher->all());
            $this->memberManager->save($member);

            return $this->view($member, Response::HTTP_CREATED);
        } catch (FormException $exception) {
            $view = [
                'message' => $exception->getMessage(),
                'data' => $exception->getData()
            ];

            return $this->view($view, $exception->getCode());
        }
    }
}
