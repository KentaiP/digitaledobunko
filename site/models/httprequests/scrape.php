<?php
$homepage = 'http://jisho.org/api/v1/search/words?keyword=' . urlencode ($_GET['query']);
$homepage = file_get_contents($homepage);
echo $homepage;
?>