<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
class FilterService
{

    public function __construct(
        #[TaggedIterator('app.filter_class')] private iterable $filters
    )
    {
    }

    public function getAll()
    {
        $results = [];
        foreach ($this->filters as $filter) {
            $className = get_class($filter);
            $shortName = (new \ReflectionClass($className))->getShortName();
            $results[$shortName] = $className::all();
        }

        return $results;
    }
}
