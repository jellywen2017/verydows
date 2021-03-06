<?php if(!class_exists("View", false)) exit("no direct access allowed");?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include $_view_obj->compile('backend/lib/meta.html'); ?>
<link rel="stylesheet" type="text/css" href="public/theme/backend/css/verydows.css" />
<link rel="stylesheet" type="text/css" href="public/theme/backend/css/main.css" />
<link rel="stylesheet" type="text/css" href="public/theme/backend/css/stats.css" />
<script type="text/javascript" src="public/script/jquery.js"></script>
<script type="text/javascript" src="public/theme/backend/js/verydows.js"></script>
<script type="text/javascript" src="public/theme/backend/js/flot.js"></script>
<script type="text/javascript">
$(function(){
  selectYear();
});

function setChart(data){
  var dataset = [];
  $.each(data, function(k, v){
    dataset.push([v.month+'月', v.num]);
  });
  $.plot('#column-chart .column', [dataset], {
    series: {
      bars: {show:true, barWidth:0.5, align:'center'}
    },
    xaxis: {mode:'categories', tickLength: 0,}
  });
}

function showChart(year){
  $.ajax({
    type: "post",
    dataType: "json",
    url: "<?php echo url(array('m'=>$MOD, 'c'=>'stats', 'a'=>'order', 'step'=>'search', ));?>",
    data: {'start_year':year},
    beforeSend: function(){
      $('#column-chart .column').off().hide();
      $('#column-chart .loading').show();
    },
    success: function(res){
      $('#column-chart .loading').hide();
      $('#column-chart .hint').hide();
      if(res.status == 'success'){
        $('#column-chart .column').show();
        setChart(res.data);
      } else{
        $('#column-chart .hint').text('暂无相关数据').show();
      }
    },
    error: function(){
      $('#column-chart .loading').hide();
      $('#column-chart .hint').text('查询超时或出错!').show();
    }
  });
}

function selectYear(){
  var year = $('#start_year').val();
  $('#chart-title').html('<b>'+year+'</b> 年度订单数量统计分析');
  showChart(year);
}
</script>
</head>
<body>
<div class="content">
  <div class="loc"><h2><i class="icon"></i>订单统计</h2></div>
  <div class="box">
    <div class="module">
      <table class="datalist">
        <tr>
          <th width="130">日期</th>
          <th>订单总数</th>
          <th width="20%">已付款</th>
          <th width="20%">未付款</th>
          <th width="20%">已取消</th>
        </tr>
        <?php $_foreach_v_counter = 0; $_foreach_v_total = count($latest);?><?php foreach( $latest as $k => $v ) : ?><?php $_foreach_v_index = $_foreach_v_counter;$_foreach_v_iteration = $_foreach_v_counter + 1;$_foreach_v_first = ($_foreach_v_counter == 0);$_foreach_v_last = ($_foreach_v_counter == $_foreach_v_total - 1);$_foreach_v_counter++;?>
        <tr>
          <td><h3 class="c777"><?php echo htmlspecialchars($k, ENT_QUOTES, "UTF-8"); ?></h3></td>
          <td><?php echo htmlspecialchars($v['total'], ENT_QUOTES, "UTF-8"); ?></td>
          <td><?php if (empty($v['paid'])) : ?>0<?php else : ?><?php echo htmlspecialchars($v['paid'], ENT_QUOTES, "UTF-8"); ?><?php endif; ?></td>
          <td><?php if (empty($v['nonpay'])) : ?>0<?php else : ?><?php echo htmlspecialchars($v['nonpay'], ENT_QUOTES, "UTF-8"); ?><?php endif; ?></td>
          <td><?php if (empty($v['canceled'])) : ?>0<?php else : ?><?php echo htmlspecialchars($v['canceled'], ENT_QUOTES, "UTF-8"); ?><?php endif; ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
    </div>
    <div class="bw-row mt5 pad10 ta-c cut">
      <div class="bw-row pad10 cut">
        <label><font class="c888 mr5">选择年份</font><select class="slt" name="start_year" id="start_year"><?php echo html_date_options(array('type'=>"year", 'start_year'=>"-10", 'default'=>$def_year, ));?></select></label>
        <button class="cbtn btn" type="button" onclick="selectYear()">查询</button>
      </div>
      <div class="mt10 c666" id="chart-title"></div>
      <div class="linewrap module mt5 cut" id="column-chart">
        <div class="column"></div>
        <div class="hint caaa hide"></div>
        <div class="loading x-auto hide"></div>
      </div>
    </div>
  </div>
</div>
</body>
</html>