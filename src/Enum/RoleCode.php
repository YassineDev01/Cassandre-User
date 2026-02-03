<?php

namespace App\Enum;

enum RoleCode: string
{
    case USER     = 'USER';
    case ADMIN    = 'ADMIN';
    case AUDITOR  = 'AUDITOR';
    case EXAMINER = 'EXAMINER';
    case STAFF    = 'STAFF';

    public function label(): string
    {
        return match ($this) {
            self::USER     => 'Utilisateur',
            self::ADMIN    => 'Administrateur',
            self::AUDITOR  => 'Auditeur',
            self::EXAMINER => 'Examinateur',
            self::STAFF    => 'Personnel',
        };
    }
}
