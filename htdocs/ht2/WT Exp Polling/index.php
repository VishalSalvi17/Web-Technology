<?php
    require 'opinion_poll_model.php';

    $model = new Opinion_poll_model();

    if (count($_POST) >= 1) {
        $ts = date("Y-m-d H:i:s");
        $option = $_POST['vote'][0];
        $sql_stmt = "INSERT INTO fruit_types (`choice`,`ts`) VALUES ($option,'$ts')";
        $model->insert($sql_stmt);
        //$sql_stmt = "SELECT COUNT(choice) choices_count FROM fruit_types;";
        $choices_count = $model->select($sql_stmt);
        $types = array("", "Kiwi", "Mango", "Guava", "Apple", "Watermelon", "Grapes", "Pineapple", "Chiku");
        $table_rows = '';
        for ($i = 1; $i < count($types); $i++) {
            $sql_stmt = "SELECT COUNT(choice) choices_count FROM fruit_types WHERE choice = $i;";
            $result = $model->select($sql_stmt);
            $table_rows .= "<tr><th scope='row'>".$i."</th><td>".$types[$i]."</td><td>".$result[0]."</td>";
            $table_rows .= "<td><div class='progress'>
            <div class='progress-bar' role='progressbar' aria-valuenow='".(int)(($result[0] / $choices_count[0]) * 100)."' aria-valuemin='0' aria-valuemax='100' style='width:".(int)(($result[0] / $choices_count[0]) * 100)."%'>".(int)(($result[0] / $choices_count[0]) * 100)."%</div></div></td></tr>";
        }
        require 'results.html.php';
        exit;
    }

    require 'opinion.html.php';
?>