<?php

namespace App\Validator\Constraints;

use App\Entity\Member;
use App\Repository\MemberRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class AgeConstraintValidator
 */
class AgeConstraintValidator extends ConstraintValidator
{
    /**
     * @var MemberRepository
     */
    private $memberRepository;

    /**
     * CollaboratorTeamValidator constructor.
     *
     * @param MemberRepository $memberRepository
     */
    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * @param $member
     * @param Constraint $constraint
     */
    public function validate($member, Constraint $constraint)
    {
       if (!$member instanceof Member || !$member->getDateOfBirth()) {
           return;
       }

       if ($this->memberRepository->getCountMembers() > 10 && $this->validateAgeByMiddleAges($member)) {
           return;
       }

       if ($this->getAge($member->getDateOfBirth()) > $this->getMinimumAge($member->getCountry())) {
           return;
       }

       $this->context
           ->buildViolation('Age is not valid')
           ->atPath('Age')
           ->addViolation();
    }

    /**
     * @param \DateTimeInterface $dateOfBirth
     *
     * @return int
     */
    private function getAge(\DateTimeInterface $dateOfBirth)
    {
        return date_diff(new \DateTime(), $dateOfBirth)->y;
    }

    /**
     * @param string $country
     *
     * @return int
     */
    private function getMinimumAge(string $country): int
    {
        return $country == 'maroc' ? 16 : 18;
    }

    /**
     * @param Member $member
     *
     * @return bool
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function validateAgeByMiddleAges(Member $member)
    {
        return $this->getAge($member->getDateOfBirth()) < $this->getMiddleAgesByPercentage(10) &&
            $this->getAge($member->getDateOfBirth()) > $this->getMiddleAgesByPercentage(-10);
    }

    /**
     * @param int $percentage
     *
     * @return float
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    private function getMiddleAgesByPercentage(int $percentage): float
    {
        $middleAges = $this->memberRepository->getMiddleAges();

        return $middleAges + ($middleAges * $percentage / 100);

    }

}

