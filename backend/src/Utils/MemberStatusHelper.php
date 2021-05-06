<?php

namespace App\Utils;

/**
 * Class MemberStatusHelper
 */
class MemberStatusHelper
{
    const PENDING_ID = 1;
    const VALID_ID = 2;

    const STATUS_PENDING = 'pending';
    const STATUS_VALID = 'valid';

    const MEMBER_STATUS = [
        self::PENDING_ID => self::STATUS_PENDING,
        self::VALID_ID => self::STATUS_VALID
    ];

    /**
     * @param int $statusId
     *
     * @return string
     */
    public static function getMemberStatusValues(int $statusId): string
    {
        if (!in_array($statusId, array_keys(self::MEMBER_STATUS))){
            throw new \InvalidArgumentException(
                'Invalid id given (%s)!',
                $statusId
            );
        }

        return self::MEMBER_STATUS[$statusId];
    }

    /**
     * @param string $status
     *
     * @return int
     */
    public static function getMemberStatusId(string $status): int
    {
        $memberStatus = array_flip(self::MEMBER_STATUS);
        if (!in_array($status, array_keys($memberStatus))){
            throw new \InvalidArgumentException(
                'Invalid status given (%s)!',
                $status
            );
        }

        return $memberStatus[$status];
    }
}
