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

    public static function getLinks2($total, $result_per_page, $page_url, $current_page)
    {
        if ($page_url == '') {
            $page_url = self::getParams();
        }

        $pagination_output = '';

        $total_pages = ceil($total / $result_per_page);

        $offset = 5;
        $span = ($offset * 2) + 1;

        if ($total_pages > 1) {

            if ($current_page == 1) {
                $previous_page_active = " class=\"disabled\"";
                $previous_page = 1;
            } else {
                $previous_page = $current_page - 1;
                $previous_page_active = '';
            }

            $pagination_output .= '<ul class="pagination pagination-lg"><li' . $previous_page_active . "><a href='{$page_url}{$previous_page}'>&laquo;</a></li>";

            if ($current_page > $offset) {
                $pagination_output .= "<li><a href='" . $page_url . "1'>1</a></li>";
            }

            if ($total_pages > $span) {

                if ($current_page <= $offset) {
                    $start = 1;
                } else if ($current_page >= ($total_pages - $offset)) {
                    $start = $total_pages - $span;
                } else {
                    $start = $current_page - $offset;
                }
            } else {
                $start = 1;
                $span = $total_pages;
            }

            $limit = $span + (($start != 1) ? $start : 0);

            for ($i = $start; $i <= $limit; $i ++) {
                $this_is_current_page = '';

                if ($i == $current_page) {
                    $this_is_current_page = " class=\"active\" ";
                }

                $pagination_output .= "<li" . $this_is_current_page . "><a href='{$page_url}{$i}'>" . $i. "</a></li>";
            }

            if ($current_page < ($total_pages - $offset)) {
                $pagination_output .= "<li><a href='{$page_url}{$total_pages}'>$total_pages</a></li>";
            }

            if ($current_page == $total_pages) {
                $next_page_active = " class=\"disabled\"";
                $next_page = $current_page;
            } else {
                $next_page = $current_page + 1;
                $next_page_active = "";
            }

            $pagination_output .= '<li' . $next_page_active . '><a href="' . $page_url . $next_page . '">&raquo;</a></li></ul>';
        }

        return $pagination_output;
    }

    public static function getParams()
    {
        $all_get_params = '';

        foreach ($_GET as $item => $value) {
            if ($item == 'page' || $item == 'action' || empty($value)) continue;
            if (empty($all_get_params)) {
                $all_get_params .= '?' . $item . '=' . urlencode($value);
            } else {
                $all_get_params .= '&' . $item . '=' . urlencode($value);
            }
        }

        if (empty($all_get_params)) {
            $all_get_params = $_SERVER['PHP_SELF'] . '?page=';
        } else {
            $all_get_params = $_SERVER['PHP_SELF'] . $all_get_params . '&page=';
        }

        return $all_get_params;
    }

}