<?php

namespace App\Manager;

use App\Entity\Member;
use App\Exception\FormException;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use App\Utils\ErrorFormatter;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class MemberManager
 */
class MemberManager
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var MemberRepository
     */
    private $memberRepository;

    /**
     * MemberManager constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(
        ValidatorInterface $validator,
        FormFactoryInterface $formFactory,
        MemberRepository $memberRepository
    )
    {
        $this->validator = $validator;
        $this->formFactory = $formFactory;
        $this->memberRepository = $memberRepository;
    }

    /**
     * @param array $data
     *
     * @return Member
     *
     * @throws FormException
     */
    public function create(array $data): Member
    {
        $member = new Member();
        $form = $this->formFactory->create(MemberType::class, $member);
        $form->submit($data);
        $this->validateData($member);

        return $member;
    }

    /**
     * @param Member $member
     * @param bool   $flush
     */
    public function save(Member $member, bool $flush = true): void
    {
        $this->memberRepository->persist($member, $flush);
    }

    /**
     * @throws FormException
     */
    private function validateData(Member $member): void
    {
        $errors = $this->validator->validate($member);
        if (0 === $errors->count()) {
            return;
        }

        throw new FormException(
            FormException::DATA_INVALID,
            Response::HTTP_BAD_REQUEST,
            ErrorFormatter::format($errors)
        );
    }
}
