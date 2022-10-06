<?php

namespace Drabbit\ColorSemantics\Repositories;

use Drabbit\ColorSemantics\Models\Results\Color;
use Drabbit\ColorSemantics\Models\Results\Result;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;

class ColorsConceptsRepository
{
    public function tableQuery(Result|Model|string|null $result = null): Result|Collection| \Illuminate\Database\Eloquent\Builder
    {
        $resultId = is_string($result) ? $result : $result?->id;
        $resultQuery = Result::query();
        if ($resultId) {
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
