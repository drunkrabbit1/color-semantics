<?php

namespace Drabbit\ColorSemantics\Enums;

enum DefaultConcepts: string
{
    case I                          =  'Я';
    case PAST                       =  'Прошлое';
    case PRESENT                    =  'Настоящее';
    case FUTURE                     =  'Будущее';
    case INTERESTING_ACTIVITY       =  'Интересное занятие';
    case BENEFIT                    =  'Выгода (практическая польза)';
    case PERSONAL_INDEPENDENCE      =  'Личная независимость';
    case MATERIAL_WELL_BEING        =  'Материальное благополучие';
    case ACHIEVING_SUCCESS          =  'Достижение успеха';
    case MY_SELF_DEVELOPMENT        =  'Мое саморазвитие';
    case RECOGNITION_BY_OTHERS      =  'Признание окружающими';
    case COMMUNICATION_WITH_PEOPLE  =  'Общение с людьми';
    case FULFILLMENT_OF_DUTIES      =  'Выполнение обязанностей ';
    case MY_FAMILY                  =  'Моя семья';
    case MY_FRIENDS                 =  'Мои друзья';
    case TROUBLE                    =  'Неприятности';
    case FAILURE                    =  'Неудача';
    case DISEASE                    =  'Болезнь';
    case THREAT                     =  'Угроза';
    case MY_FEARS                   =  'Мои страхи';
    case CONFLICTS                  =  'Конфликты';
    case MY_PROBLEMS                =  'Мои проблемы';
    case THEFT                      =  'Воровство';


    public function isNegative(): bool
    {
        return (bool) self::getNegative()->where('title', $this->value)->count();
    }

    public static function all(): \Illuminate\Support\Collection
    {
        return collect(self::cases())
            ->pluck('value')
            ->map(
                fn($value) => ['title' => $value]
            );
    }

    public static function getNegative(): \Illuminate\Support\Collection
    {
        return self::all()->whereIn('title', [
            self::TROUBLE->value,
            self::TROUBLE->value,
            self::FAILURE->value,
            self::DISEASE->value,
            self::THREAT->value,
            self::MY_FEARS->value,
            self::CONFLICTS->value,
            self::MY_PROBLEMS->value,
            self::THEFT->value,
        ]);
    }

    public static function getNotNegative(): \Illuminate\Support\Collection
    {
        return self::all()->whereNotIn(
            'title', self::getNegative()->pluck('title')->toArray()
        );
    }
}
