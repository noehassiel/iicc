<?php

namespace App\Enums;

enum EventCategory: string
{
    case Cultural = 'cultural';
    case Campus = 'campus';
    case Huella = 'huella';

    /**
     * Section name shown on the public site and in the admin panel.
     */
    public function label(): string
    {
        return match ($this) {
            self::Cultural => __('Actividades Culturales'),
            self::Campus => __('Eventos en Campus'),
            self::Huella => __('Nuestra Huella en México'),
        };
    }
}
