<?php

namespace App\Resource\Pagination;

class Page
{
    /** @var int */
    private $page;
    /** @var int */
    private $limit;
    /** @var int */
    private $offset;

    public function __construct(int $page, int $limit)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->offset = ($page - 1) * $limit;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getPages($totalItems): int
    {
        return ceil($totalItems / $this->limit);
    }
}
