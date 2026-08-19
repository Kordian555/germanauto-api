<?php

namespace App\Service;

use App\Exception\BadRequestException;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
class FilterService
{

    public function __construct(
        #[TaggedIterator('app.filter_class')] private iterable $filters
    )
    {
    }

    public function getAll(): array
    {
        $results = [];
        $classes = [];
        foreach ($this->filters as $filter) {
            $className = get_class($filter);
            $shortName = (new \ReflectionClass($className))->getShortName();
            $results[$shortName] = $className::all();
            $classes[$className] = $shortName;
        }

        return [$results, $classes];
    }

    public function checkFilters(
        array $filters,
        bool $verify = false
    ): array
    {
        [$check, $classes] = $this->getAll();
        $result = [];

        foreach ($filters as $filter => $values) {
            if (isset($check[$filter])) {
                $checkValues = $check[$filter];
                foreach ($values as $value) {
                    if (in_array($value, $checkValues)) {
                        $result[$filter][] = $value;
                    }
                }
            }
        }

        if ($verify) {
            if (!$this->verify($result, $classes)) {
                throw new BadRequestException('Missing important filters');
            }
        }

        return $result;
    }

    public function verify(
        array $filtered,
        array $classes
    )
    {
        foreach ($classes as $class => $shortName) {
            if ($class::isRequired()) {
                if (!isset($filtered[$shortName])) {
                    return false;
                }
            }
        }

        return true;
    }
}
