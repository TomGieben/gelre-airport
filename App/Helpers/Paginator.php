<?php

namespace App\Helpers;

class Paginator
{
    private int $perPage;
    private int $page;
    private int $total;
    private int $maxPages = 4; // count from 0

    /**
     * Create a new Paginator instance.
     * 
     * @param int $perPage The amount of items per page.
     * @param int $page The current page.
     * @param int $total The total amount of items.
     */
    public function __construct(int $perPage, int $page, int $total)
    {
        $this->perPage = $perPage;
        $this->page = $page;
        $this->total = $total;
    }

    /**
     * Render the pagination HTML.
     * 
     * @return string
     */
    public function render(): string
    {
        $totalPages = ceil($this->total / $this->perPage);
        $amountOfPages = $totalPages > $this->maxPages ? $this->maxPages : $totalPages;
        $currentPage = $this->page;
        $paginationHtml = '<div class="pagination">';

        // Previous button
        if ($currentPage > 1) {
            $prevPage = $currentPage - 1;
            $paginationHtml .= '<a href="?page=' . $prevPage . '">&laquo; Vorige</a>';
        }

        // Page numbers
        if ($totalPages > 1) {
            for ($i = 0; $i <= $amountOfPages; $i++) {
                $pageNumber = $currentPage + $i;

                if ($pageNumber == $currentPage) {
                    $paginationHtml .= '<span class="current">' . $pageNumber . '</span>';
                } else {
                    $paginationHtml .= '<a href="?page=' . $pageNumber . '">' . $pageNumber . '</a>';
                }
            }
        }

        // Next button
        if ($currentPage < $totalPages) {
            $nextPage = $currentPage + 1;
            $paginationHtml .= '<a href="?page=' . $nextPage . '">Volgende &raquo;</a>';
        }

        $paginationHtml .= '</div>';

        return $paginationHtml;
    }
}
