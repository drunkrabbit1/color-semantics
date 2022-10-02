<?php

namespace Database\Seeders;

use Drabbit\ColorSemantics\Models\Algorithm\Algorithm;
use Drabbit\ColorSemantics\Models\Algorithm\AlgorithmConcept;
use Drabbit\ColorSemantics\Models\Concept;
use Drabbit\ColorSemantics\Enums\AlgorithmType;
use Drabbit\ColorSemantics\Enums\DefaultConcepts;
use Illuminate\Database\Seeder;

class AlgorithmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AlgorithmConcept::query()->delete();
        Algorithm::query()->delete();
        Concept::query()->delete();
        /** IN_GROUP */
//        $this->algorithmDefault();
        $this->algorithm1();
        /** в избегании */
        $this->algorithm4();
        /** в стремлении */
        $this->algorithm5();
        $this->algorithm6();
        $this->algorithm7();
        $this->algorithm8();
        $this->algorithm9();
        /** PASSIVE */
        /** в избегании */
        $this->algorithm2();
        /** в стремлении */
        $this->algorithm3();

    }

    private function algorithmDefault()
    {
        /** @var Concept $concept */
        $concept = Concept::query()->updateOrCreate(['title' => 'Прошлое']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Прошлое',
            'point' => 5,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Прошлое(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Настоящее']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Настоящее',
            'point' => 7,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Настоящее(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Будущее']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Будущее',
            'point' => 6,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Будущее(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Мое увлечение']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Мое увлечение',
            'point' => 7,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Мое увлечение(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Интересное занятие']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Интересное занятие',
            'point' => 6,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Интересное занятие(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Выгода (практическая польза)']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Выгода (практическая польза)',
            'point' => 5,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Выгода (практическая польза)(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Я']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Я',
            'point' => 10,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Я(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Личная независимость']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Личная независимость',
            'point' => 2,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Личная независимость(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Материальное благополучие']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Материальное благополучие',
            'point' => 2,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Материальное благополучие',
            'point' => 2,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Достижение успеха']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Достижение успеха',
            'point' => 2,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Достижение успеха(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Мое саморазвитие']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Мое саморазвитие',
            'point' => 2,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Мое саморазвитие(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Признание окружающими']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Признание окружающими',
            'point' => 2,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Признание окружающими(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Общение с людьми']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Общение с людьми',
            'point' => 2,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Общение с людьми(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Выполнение обязанностей']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Выполнение обязанностей',
            'point' => 2,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Выполнение обязанностей(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Моя семья']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Моя семья',
            'point' => 2,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Моя семья(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Мои друзья']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Мои друзья',
            'point' => 2,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Мои друзья(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Неприятности']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Неприятности',
            'point' => 2,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Неприятности(-)',
            'point' => 1,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Неудача']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Неудача',
                'point' => -10,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
            ])->id
        );
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Неудача(-)',
            'point' => -10,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
            ])->id
        );

        $concept = Concept::query()->updateOrCreate(['title' => 'Болезнь']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Болезнь',
            'point' => -10,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
            ])->id
        );
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Болезнь(-)',
            'point' => -10,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id
        );

        $concept = Concept::query()->updateOrCreate(['title' => 'Угроза']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Угроза',
                'point' => -10,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
            ])->id
        );
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Угроза(-)',
            'point' => -10,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id
        );

        $concept = Concept::query()->updateOrCreate(['title' => 'Мои страхи']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Мои страхи',
            'point' => -10,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
            ])->id
        );
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Мои страхи(-)',
            'point' => -10,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id
        );

        $concept = Concept::query()->updateOrCreate(['title' => 'Конфликты']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Конфликты',
            'point' => -10,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Конфликты(-)',
            'point' => -10,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Мои проблемы']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Мои проблемы',
            'point' => -10,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Мои проблемы(-)',
            'point' => -10,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);

        $concept = Concept::query()->updateOrCreate(['title' => 'Воровство']);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Воровство',
            'point' => -10,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_ASPIRATION_ZONE,
        ])->id);
        $concept->algorithms()->attach(Algorithm::query()->updateOrCreate([
            'description' => 'Воровство(-)',
            'point' => -10,
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
        ])->id);
    }

    private function algorithm1()
    {
        /** @var \App\Models\Algorithm\Algorithm $algorithm */
        $algorithm = $this->refresh(Algorithm::query()->updateOrCreate([
            'description' => 'В группе с любым негативом(неудача, неприятности, угроза, болезнь, страхи, конфликты)',
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IN_GROUP,
            'point' => -10,
            'algorithm_id' => $this->refresh(Algorithm::query()->updateOrCreate([
                //'id' => Str::uuid(),
                'type' => AlgorithmType::MULTIPLIED,
                'point' => 0,
            ]))->id
        ]));
        $algorithm->concepts()->sync(DefaultConcepts::getNegative()->map($this->fnWhereTitle())->pluck('id')->toArray());
    }

    private function algorithm2()
    {
//        /** @var \App\Models\AlgorithmTest\AlgorithmTest $algorithm */
        $algorithm = $this->refresh(Algorithm::query()->updateOrCreate([
            'description' => 'Отсутствуют (одиночное понятие), зона избегания',
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IN_GROUP,
            'point' => -5,
            'algorithm_id' => $this->refresh(Algorithm::query()->updateOrCreate([
                //'id' => Str::uuid(),
                'type' => AlgorithmType::MISS,
                'point' => 0,
                'algorithm_id' => $this->refresh(Algorithm::query()->updateOrCreate([
                    //'id' => Str::uuid(),
                    'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
                    'point' => 0,
                ]))->id
            ]))->id
        ]));

//        $algorithm->concepts()->sync(DefaultConcepts::defaultConcepts()->map($this->fnWhereTitle())->pluck('id')->toArray());
    }

    private function algorithm3()
    {
//        /** @var \App\Models\AlgorithmTest\AlgorithmTest $algorithm */
//        $algorithm = $this->refresh(AlgorithmTest::query()->updateOrCreate([
//            'description' => 'Отсутствуют (одиночное понятие), зона стремления',
//            //'id' => Str::uuid(),
//            'type' => AlgorithmType::MISS,
//            'point' => -1,
//            'algorithm_id' => $this->refresh(AlgorithmTest::query()->updateOrCreate([
//                //'id' => Str::uuid(),
//                'type' => AlgorithmType::IF_ASPIRATION_ZONE,
//                'point' => 0,
//                'algorithm_id' => $this->refresh(AlgorithmTest::query()->updateOrCreate([
//                    //'id' => Str::uuid(),
//                    'type' => AlgorithmType::PASSIVE,
//                    'point' => 0,
//                ]))->id
//            ]))->id
//        ]));
        /** @var \App\Models\Algorithm\Algorithm $algorithm */
        $algorithm = $this->refresh(Algorithm::query()->updateOrCreate([
            'description' => 'Отсутствуют (одиночное понятие), зона стремления',
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IN_GROUP,
            'point' => -1,
            'algorithm_id' => $this->refresh(Algorithm::query()->updateOrCreate([
                //'id' => Str::uuid(),
                'type' => AlgorithmType::MISS,
                'point' => 0,
                'algorithm_id' => $this->refresh(Algorithm::query()->updateOrCreate([
                    //'id' => Str::uuid(),
                    'type' => AlgorithmType::IF_ASPIRATION_ZONE,
                    'point' => 0,
                ]))->id
            ]))->id
        ]));
    }

    private function algorithm4()
    {
        /** @var \App\Models\Algorithm\Algorithm $algorithm */
        $algorithm = $this->refresh(Algorithm::query()->updateOrCreate([
            'description' => 'В группе с реперными понятиями, зона избегания',
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IN_GROUP,
            'point' => 1,
            'algorithm_id' => $this->refresh(Algorithm::query()->updateOrCreate([
                //'id' => Str::uuid(),
                'type' => AlgorithmType::IF_AVOIDANCE_ZONE,
                'point' => 0,
                'algorithm_id' => $this->refresh(Algorithm::query()->updateOrCreate([
                    'description' => 'Каждое реперное понятие в группе дает +1 балл',
                    //'id' => Str::uuid(),
                    'type' => AlgorithmType::MULTIPLIED,
                    'point' => 0
                ]))->id
            ]))->id
        ]));
        $algorithm->concepts()->sync(DefaultConcepts::getNotNegative()->map($this->fnWhereTitle())->pluck('id'));
    }

    private function algorithm5()
    {
        /** @var \App\Models\Algorithm\Algorithm $note */
        $note = $this->refresh(Algorithm::query()->updateOrCreate([
            'description' => 'При наличии нескольких категорий времени в группе – баллы суммируются',
            //'id' => Str::uuid(),
            'type' => AlgorithmType::SUMMATION,
            'point' => 0,
        ]));

        $algorithm = $this->refresh(Algorithm::query()->updateOrCreate([
            'description' => 'В группе с прошлым',
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IN_GROUP,
            'point' => 3,
            'algorithm_id' => Algorithm::query()->updateOrCreate([
                //'id' => Str::uuid(),
                'type' => AlgorithmType::IF_ASPIRATION_ZONE,
                'algorithm_id' => $note->id,
                'point' => 0,
            ])->id
        ]));
        $algorithm->concepts()->sync(DefaultConcepts::all()->where('title', 'Прошлое')
            ->map($this->fnWhereTitle())->pluck('id'));

        $algorithm = $this->refresh(Algorithm::query()->updateOrCreate([
            'description' => 'В группе с настоящим',
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IN_GROUP,
            'point' => 5,
            'algorithm_id' => Algorithm::query()->updateOrCreate([
                //'id' => Str::uuid(),
                'type' => AlgorithmType::IF_ASPIRATION_ZONE,
                'algorithm_id' => $note->id,
                'point' => 0,
            ])->id
        ]));
        $algorithm->concepts()->sync(DefaultConcepts::all()->where('title', 'Настоящее')
            ->map($this->fnWhereTitle())->pluck('id'));

        $algorithm = $this->refresh(Algorithm::query()->updateOrCreate([
            'description' => 'В группе с будущим',
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IN_GROUP,
            'point' => 4,
            'algorithm_id' => Algorithm::query()->updateOrCreate([
                //'id' => Str::uuid(),
                'type' => AlgorithmType::IF_ASPIRATION_ZONE,
                'algorithm_id' => $note->id,
                'point' => 0,
            ])->id
        ]));
        $algorithm->concepts()->sync(DefaultConcepts::all()->where('title', 'Будущее')
            ->map($this->fnWhereTitle())->pluck('id'));
    }

    private function algorithm6()
    {
        /** @var \App\Models\Algorithm\Algorithm $note */
        $note = $this->refresh(Algorithm::query()->updateOrCreate([
            'description' => 'При наличии нескольких категорий мотивов в группе – баллы суммируются',
            //'id' => Str::uuid(),
            'type' => AlgorithmType::SUMMATION,
            'point' => 0,
        ]));

        $algorithm = $this->refresh(Algorithm::query()->updateOrCreate([
            'description' => 'В группе с увлечением',
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IN_GROUP,
            'point' => 5,
            'algorithm_id' => $this->refresh(Algorithm::query()->updateOrCreate([
                //'id' => Str::uuid(),
                'type' => AlgorithmType::IF_ASPIRATION_ZONE,
                'algorithm_id' => $note->id,
                'point' => 0,
            ]))->id
        ]));

        $algorithm->concepts()->sync(DefaultConcepts::all()->where('title', 'Мое увлечение')
            ->map($this->fnWhereTitle())->pluck('id'));

        $algorithm = $this->refresh(Algorithm::query()->updateOrCreate([
            'description' => 'В группе с интересным занятием',
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IN_GROUP,
            'point' => 4,
            'algorithm_id' => $this->refresh(Algorithm::query()->updateOrCreate([
                //'id' => Str::uuid(),
                'type' => AlgorithmType::IF_ASPIRATION_ZONE,
                'algorithm_id' => $note->id,
                'point' => 0,
            ]))->id
        ]));
        $algorithm->concepts()->sync(DefaultConcepts::all()->where('title', 'Интересное занятие')
            ->map($this->fnWhereTitle())->pluck('id'));

        $algorithm = $this->refresh(Algorithm::query()->updateOrCreate([
            'description' => 'В группе с практической пользой',
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IN_GROUP,
            'point' => 3,
            'algorithm_id' => $this->refresh(Algorithm::query()->updateOrCreate([
                //'id' => Str::uuid(),
                'type' => AlgorithmType::IF_ASPIRATION_ZONE,
                'algorithm_id' => $note->id,
                'point' => 0,
            ]))->id
        ]));
        $algorithm->concepts()->sync(DefaultConcepts::all()->where('title', 'Выгода (практическая польза)')
            ->map($this->fnWhereTitle())->pluck('id'));
    }

    private function algorithm7()
    {
        /** @var \App\Models\Algorithm\Algorithm $algorithm */
        $algorithm = $this->refresh(Algorithm::query()->updateOrCreate([
            'description' => 'В группе с «Я»',
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IN_GROUP,
            'point' => 8,
            'algorithm_id' => $this->refresh(Algorithm::query()->updateOrCreate([
                //'id' => Str::uuid(),
                'type' => AlgorithmType::IF_ASPIRATION_ZONE,
                'point' => 0,
            ]))->id
        ]));
        $algorithm->concepts()->sync(DefaultConcepts::all()->where('title', 'Я')
            ->map($this->fnWhereTitle())->pluck('id'));
    }

    private function algorithm8()
    {
        /** @var \App\Models\Algorithm\Algorithm $algorithm */
        $algorithm = $this->refresh(Algorithm::query()->updateOrCreate([
            'description' => 'В группе с другими реперными понятиями',
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IN_GROUP,
            'point' => 0,
            'algorithm_id' => $this->refresh(Algorithm::query()->updateOrCreate([
                'description' => 'За каждое реперное понятие +2 балла, баллы суммируются',
                //'id' => Str::uuid(),
                'type' => AlgorithmType::MULTIPLIED,
                'point' => 2,
                'algorithm_id' => $this->refresh(Algorithm::query()->updateOrCreate([
                    //'id' => Str::uuid(),
                    'type' => AlgorithmType::IF_ASPIRATION_ZONE,
                    'point' => 0,
                ]))->id
            ]))->id
        ]));
        $algorithm->concepts()->sync(
            DefaultConcepts::getNotNegative()->map($this->fnWhereTitle())->pluck('id')
        );
    }

    private function algorithm9()
    {
        /** @var Algorithm $algorithm */
        $algorithm = $this->refresh(Algorithm::query()->updateOrCreate([
            'description' => 'В группе с другими определяемыми понятиями',
            //'id' => Str::uuid(),
            'type' => AlgorithmType::IN_GROUP,
            'point' => 0,
            'algorithm_id' => $this->refresh(Algorithm::query()->updateOrCreate([
                'description' => 'За каждое понятие +1 балл,  баллы суммируются',
//                //'id' => Str::uuid(),
                'type' => AlgorithmType::MULTIPLIED,
                'point' => 1,
                'algorithm_id' => $this->refresh(Algorithm::query()->updateOrCreate([
                    //'id' => Str::uuid(),
                    'type' => AlgorithmType::IF_ASPIRATION_ZONE,
                    'point' => 0,
                ]))->id
            ]))->id
        ]));
//        $algorithm->concepts()->sync(
////            DefaultConcepts::defaultConcepts()->map($this->fnWhereTitle())->pluck('id')
//        );
    }


    public function refresh($model)
    {
        if (!$model->id) {
            if ($model instanceof Algorithm) $model->id = Algorithm::query()
                ->where('description', $model->description)
                ->first('id')->id;
            if ($model instanceof Concept) $model->id = Concept::query()
                ->orWhere('title', $model->title)
                ->first('id')->id;
        }


        return $model;
    }

    public function fnWhereTitle(): \Closure
    {
        return function($item) {
            $concept = $this->refresh(Concept::query()->updateOrCreate($item));

            return $concept;
        };
    }
}
