<?php

if (MON_PROF) {
    $xhprof_data = xhprof_disable('/tmp');
    include_once APP_PATH . "Libs/Xhprof/xhprof_lib/utils/xhprof_lib.php"; 
    include_once APP_PATH . "/Libs/Xhprof/xhprof_lib/utils/xhprof_runs.php";
    $xhprof_runs = new XHProfRuns_Default();
    $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_phalcon");
    echo "<BR /><BR /><center><a target='_BLANK' href=\"http://120.24.5.57/Apps/Libs/Xhprof/xhprof_html/index.php?run=$run_id&source=xhprof_phalcon\">Xhprof性能报告</a></center>";
}
