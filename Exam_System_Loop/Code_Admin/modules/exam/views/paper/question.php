<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>


<?php $this->beginBlock('header');  ?>
<?php $this->endBlock(); ?>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">

                <div class="box-header">
                    <h3 class="box-title">试卷详情</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <!-- row start search-->
                        <div class="box-body">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <!-- row start search-->


                                <!-- row end search -->

                                <!-- row start -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="data_table_info">
                                            <thead>
                                            <tr role="row">

                                                <?php
                                                echo '<th><input id="data_table_check" type="checkbox"></th>';
                                                echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >题号</th>';
                                                echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >题目类型</th>';
                                                echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >题目名字</th>';
                                                echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >题目描述</th>';
                                                echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >题目难度</th>';
                                                echo '<th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >题目阶段</th>';
                                                ?>
                                                <th tabindex="0" aria-controls="data_table" rowspan="1" colspan="1" aria-sort="ascending" >操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            foreach ($question as $model) {
                                                $id = $model['QuestionBh'];
                                                echo '<tr style="height:100px !important; overflow:hidden !important;" id="rowid_' . $model['QuestionBh'] . '">';
                                                echo '  <td><label><input type="checkbox" value="' . $model['QuestionBh'] . '"></label></td>';
                                                echo '  <td>' . $model['CustomBh'] . '</td>';
                                                echo '  <td>' . $model['QuestionType'] . '</td>';
                                                echo '  <td>' . $model['name'] . '</td>';
                                                echo '  <td style="display:block; height:70px !important; overflow:hidden; text-overflow:ellipsis;">' . $model['Description']. '</td>';
                                                echo '  <td>' . $model['Difficulty'] . '</td>';
                                                echo '  <td>' . $model['Stage'] . '</td>';
                                                echo '  <td class="center">';
                                                echo '      <a id="view_btn" onclick="addAction(' . "'$id'" . ')" class="btn btn-primary btn-sm" href="#">添加到试卷</a>';
                                                echo '  </td>';
                                                echo '</tr>';
                                            }
                                            ?>



                                            </tbody>
                                            <!-- <tfoot></tfoot> -->
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
</section>




<?php $this->beginBlock('footer');  ?>

<script>
    var paperid = "<?php echo $idr;?>";
   function addAction(id) {
       var ids = [];
       if (!!id == true) {
           ids[0] = id;
       }
       else {
           var checkbox = $('#data_table :checked');
           if (checkbox.size() != 0) {
               var c = 0;
               for (var i = 0; i < checkboxs.size(); i++) {
                   var id = checkboxs.eq(i).val();
                   if (id != "") {
                       ids[c++] = id;
                   }
               }
           }
       }
                   if (ids.length > 0) {
                       admin_tool.confirm('请确认是否添加', function () {
                           $.ajax({
                               type: "GET",
                               url: "<?=Url::toRoute('paper/addq')?>",
                               data: {"ids": ids,"paperid":paperid},
                               cache: false,
                               dataType: "json",
                               error: function (xmlHttpRequest, textStatus, errorThrown) {
                                   alert("出错了，" + textStatus);
                                   window.location.reload();
                               },
                               success: function (data) {
                                   alert("添加题目成功");
                                   window.location.href = '<?=Url::toRoute("paper/output")?>'+'&id='+paperid;;
                               }

                           });
                       });
                   }
               }
</script>
<?php $this->endBlock(); ?>
