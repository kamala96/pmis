   <style>
table {
   
}

td {

}


</style>
<body style="text-align: center;font-family: monospace; background-size: 100%;">

    <table class="table" style="width: 100%;">
     <tr>
        <th style="text-align: center;"><img src="assets/images/tcp.png" width="130" height="80"></th>
    </tr>
  </table>
             <table class="table" style="width: 100%;text-align: center;">
       <th><b style="font-size: 20px;">TANZANIA POSTS CORPORATION</b></th>
    </tr>
  </table>
  <table class="table" style="width: 100%; text-align: center;">
    <tr><th>KPI REPORT</th>
    </tr>
  </table>
  <br><br>
                    <table class="table" style="border: 1px solid;" cellpadding="0" cellspacing="0"> 
                        <thead>
                        <tr style="text-transform: uppercase;">
                            <th>S/No</th>
                            <th width="">Objective</th>
                            <th>Goals | Targets</th>
                            <th>Kpi</th>
                            <th style="text-align: right;">Marks</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $d=1; foreach ($kpilist as $value) {?>
                                <tr>
                                    <td style="border: 1px solid; padding-left: 8px;"><?php echo $d;$d++; ?></td>
                                 <td style="border: 1px solid;padding-left: 8px;">
                                  <?php echo $value->objective_name; ?>
                                 </td>
                                 <td style="border: 1px solid;padding-left: 8px;">
                                     <?php $kpi_id = $value->objective_id; $goals = $this->kpi_model->get_goals($kpi_id) ?>
                                     <?php if(!empty($goals)){ ?>
                                        <?php $i=1; foreach ($goals as $report) { ?>
                                        <?php echo $i;$i++; echo '.              '; echo $report->target_name. '   '.'<br>'; ?>
                                     <?php } ?>
                                     <?php }?>
                                 </td>
                                 <td style="border: 1px solid;padding-left: 8px;">
                                     <?php $kpi_id = $value->objective_id; $goals = $this->kpi_model->get_goals($kpi_id) ?>
                                     <?php if(!empty($goals)){ ?>

                                        <?php $i=1; foreach ($goals as $report) { ?>
                                        <?php echo $i;$i++; echo '.              '; echo $report->target_name. '   '.'<br>';

                                            $goalsid = $report->goals_id;
                                            
                                            $kpi = $this->kpi_model->get_goals_kpi($goalsid);

                                            $s=1;
                                            foreach ($kpi as $key) {
                                                ?>
                                             &nbsp;&nbsp;&nbsp;&nbsp; <?php  echo '              '. $s;$s++; echo '.              '; echo $key->kpi_values; ?>  &nbsp;&nbsp;&nbsp;            <b>Marks(<?php echo $key->marks ?>)</b><br>
                                          <?php  }
                                            
                                         ?>
                                     <?php } ?>
                                     <?php }?>
                                 </td>
                                 <td style="text-align: center;border: 1px solid;padding-left: 8px;">
                                    <?php $kpi_id = $value->objective_id; $goals = $this->kpi_model->get_goals($kpi_id) ?>
                                     <?php if(!empty($goals)){ ?>

                                        <?php $sum1=0;  $i=1; foreach ($goals as $report) { ?>
                                        <?php

                                            $goalsid = $report->goals_id;
                                            
                                            $kpi = $this->kpi_model->get_goals_kpi($goalsid);

                                            foreach ($kpi as $key) {
                                                ?>
                                                <?php  $sum1+=$key->marks ?>
                                          <?php  }
                                            
                                         ?>
                                     <?php } echo $sum1; ?>
                                     <?php }?>
                                 </td>
                                 </tr>
                            <?php } ?>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                             <td style="border: 1px solid;"></td>
                             <td style="border: 1px solid;"></td>
                              <td style="border: 1px solid;"></td>
                              <td style="text-align: right;border: 1px solid;"><b>Total Marks::</b></td>
                               <td style="text-align: center;border: 1px solid;"><b><?php $sum1=0; foreach ($kpilist as $value) {?>
                                   <?php $kpi_id = $value->objective_id; $goals = $this->kpi_model->get_goals($kpi_id) ?>
                                     <?php if(!empty($goals)){ ?>

                                        <?php   $i=1; foreach ($goals as $report) { ?>
                                        <?php

                                            $goalsid = $report->goals_id;
                                            
                                            $kpi = $this->kpi_model->get_goals_kpi($goalsid);

                                            foreach ($kpi as $key) {
                                                ?>
                                                <?php  $sum1+=$key->marks ?>
                                          <?php  }
                                            
                                         ?>
                                     <?php }  ?>
                                     <?php }?>
                                   <?php } echo $sum1;?>
                               </b></td>
                        </tr>
                        </tfoot>
                        </table>  
                    </body>
