<?php

class Paginate
{
    public static function getLinks($total, $result_per_page, $page_url, $page_id, $current_page)
    {
        $pagination_output = '';
        $numPages = ceil($total / $result_per_page);

        $offset = 4;
        $span = ($offset * 2) + 1;

        if ($numPages > 1) {
            if ($current_page > 1) {
                $prevPage = $current_page - 1;
                $pagination_output .= "<a class='pagination_prev' href='$page_url/$prevPage'>&lt;</a> &nbsp; ";
            }

            if ($current_page > $offset) {
                $pagination_output .= "<a class='pagination' href='$page_url/1'>1</A> ... ";
            }

            if ($numPages > $span) {
                if ($current_page <= $offset) {
                    $start = 1;
                } else if ($current_page >= ($numPages - $offset)) {
                    $start = $numPages - $span;
                } else {
                    $start = $current_page - $offset;
                }
            } else {
                $start = 1;
                $span = $numPages;
            }

            $limit = $span + (($start != 1) ? $start : 0);

            for ($i = $start; $i <= $limit; $i ++) {
                if ($i != $current_page) {
                    $pagination_output .= "<a class='pagination' href='$page_url/$i'>";
                } else {
                    $pagination_output .= "<span class='pagination_active'>";
                }

                $pagination_output .= $i;

                if ($i != $current_page) {
                    $pagination_output .= "</a>";
                } else {
                    $pagination_output .= "</span>";
                }
            }

            if ($current_page < ($numPages - $offset)) {
                $pagination_output .= " ... <a class='pagination' href='$page_url/$numPages'>$numPages</a>";
            }

            if ($current_page != $numPages) {
                $nextPage = $current_page + 1;
                $pagination_output .= " &nbsp; <a class='pagination_next' href='$page_url/$nextPage'>&gt;</a>";
            }
        }
        return $pagination_output;
    }
}