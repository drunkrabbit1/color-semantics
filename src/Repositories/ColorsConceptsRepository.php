<?php

namespace Drabbit\ColorSemantics\Repositories;

use Drabbit\ColorSemantics\Models\Results\Color;
use Drabbit\ColorSemantics\Models\Results\Result;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;

class ColorsConceptsRepository
{
    public function tableQuery(Result|null $result = null): Result|Collection| \Illuminate\Database\Eloquent\Builder
    {
        $resultQuery = Result::query();
        if ($result) {
            $resultQuery->where('id', $result->id);
        }

        return $resultQuery
            ->with(['colors' => function(BelongsToMany $query) use($result) {
                $query
                    ->where('result_id', $result->id)
                    ->with([
                        'concepts' => fn($query) => $query
                            ->where('result_id', $result->id)
                            ->with('algorithms.note.note.note')
                    ]);
            }]);
    }
}
