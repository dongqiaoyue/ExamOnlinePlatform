<?php
use app\models\system\TbcuitmoonDictionary;
$m_Dic = new TbcuitmoonDictionary();

?>
<h2 style="font-style: italic; margin-left: 10px; padding-top: 10px;">欢迎进入<?php echo $m_Dic->getDictionaryListByType(['2020301'])['name']['0']?>系统教务管理中心</h2>

<!-- Main content -->
<section class="content">
	<!-- Small boxes (Stat box) -->
	<div class="row">
		<div class="col-md-12">
		<div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">系统信息</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px"> </th>
                  <th style="width: 200px">名称</th>
                  <th>信息</th>
                  <th style="width: 200px">说明</th>
                </tr>
                <?php 
                    $count = 1;
                    foreach($sysInfo as $info){
    			       echo '<tr>';
    			       echo '  <td>'. $count .'</td>';
    			       echo '  <td>'.$info['name'].'</td>';
    			       echo '  <td>'.$info['value'].'</td>';
    			       echo '  <td></td>';
    			       echo '</tr>';
    			       $count++;
    			   }
    			   ?>
              </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              
            </div>
          </div>
          <!-- /.box -->
		</div>
		
	</div>
	<!-- /.row -->
	<!-- Main row -->
	<div class="row">
		
	</div>
	<!-- /.row (main row) -->

</section>
<!-- /.content -->