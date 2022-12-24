<?php
    function isdotdir(string $dir)
    {
        if ($dir == "." || $dir == "..") {
            return true;
        }
        return false;
    }

    function gen_page_index() {
        $dirs = scandir('.');
        echo "<ul>";
        foreach ($dirs as &$dir) {
            if (isdotdir($dir)) {
                continue;
            } else if (!(str_ends_with($dir, ".php") or str_ends_with($dir, ".html"))) {
                continue;
            }
            echo "<li><a href='$dir'>$dir</a></li>";
        }
        echo "</ul>";
    }

?>