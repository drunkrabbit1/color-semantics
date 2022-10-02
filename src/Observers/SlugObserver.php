<?php

namespace Drabbit\ColorSemantics\Observers;

class SlugObserver
{
    use Slug;

    public function creating($model)
    {
        $this->slug($model);
    }
}
