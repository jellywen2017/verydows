<?php if(!class_exists("View", false)) exit("no direct access allowed");?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include $_view_obj->compile('backend/lib/meta.html'); ?>
<link rel="stylesheet" type="text/css" href="public/theme/backend/css/verydows.css" />
<link rel="stylesheet" type="text/css" href="public/theme/backend/css/main.css" />
<link rel="stylesheet" type="text/css" href="public/theme/backend/css/datetimepicker.css"/>
<script type="text/javascript" src="public/script/jquery.js"></script>
<script type="text/javascript" src="public/theme/backend/js/verydows.js"></script>
<script type="text/javascript" src="public/theme/backend/js/list.js"></script>
<script type="text/javascript">
$(function(){
  searchRes(1);
  
  $('#start_date').datetimepicker ({
    format:'Y-m-d',
    formatDate: 'Y-m-d',
    allowBlank:true,
    onShow:function(ct){
      this.setOptions({maxDate:$('#end_date').val()? $('#end_date').val():false})
    }, timepicker:false
  });
  $('#end_date').datetimepicker ({
    format:'Y-m-d',
    formatDate: 'Y-m-d',
    allowBlank:true,
    onShow:function(ct){
      this.setOptions({minDate:$('#start_date').val()? $('#start_date').val():false})
    }, timepicker:false
  });

});

function searchRes(page_id){
  var dataset = {
    order_status:$('#order_status').val(),
    order_id:$('#order_id').val(),
    start_date: $('#start_date').val(),
    end_date: $('#end_date').val(),
    page:page_id,
    pernum: 10,
  };
  
  $.asynList("<?php echo url(array('m'=>$MOD, 'c'=>'order', 'a'=>'index', 'step'=>'search', ));?>", dataset, function(data){
    if(data.status == 'success'){
      $('#rows').append(juicer($('#table-tpl').html(), data));
      $('#rows tr').vdsRowHover();
      $('#rows tr:even').addClass('even');
      if(data.paging != null) $('#rows').append(juicer($('#paging-tpl').html(), data));
    }else{
      $('#rows').append("<div class='nors mt5'>未找到相关数据记录...</div>");	
    }     
  });
}

function pageturn(page_id){searchRes(page_id);}
</script>
</head>
<body>
<div class="content">
  <div class="loc"><h2><i class="icon"></i>订单列表</h2></div>
  <div class="box">
    <div class="doacts">
      <a class="ae btn" onclick="doslvent('<?php echo url(array('m'=>$MOD, 'c'=>'order', 'a'=>'view', ));?>')"><i class="view"></i><font>查看详细</font></a>
      <a class="ae btn" onclick="doslvent('<?php echo url(array('m'=>$MOD, 'c'=>'order', 'a'=>'delete', ));?>')"><i class="remove"></i><font>删除</font></a>
    </div>
    <div class="stools mt5">
      <select id="order_status" class="slt">
        <option value="" selected="selected">订单状态</option>
        <option disabled="disabled">-------------------</option>
        <?php $_foreach_v_counter = 0; $_foreach_v_total = count($status_map);?><?php foreach( $status_map as $k => $v ) : ?><?php $_foreach_v_index = $_foreach_v_counter;$_foreach_v_iteration = $_foreach_v_counter + 1;$_foreach_v_first = ($_foreach_v_counter == 0);$_foreach_v_last = ($_foreach_v_counter == $_foreach_v_total - 1);$_foreach_v_counter++;?>
        <option value="<?php echo htmlspecialchars($k, ENT_QUOTES, "UTF-8"); ?>"><?php echo htmlspecialchars($v, ENT_QUOTES, "UTF-8"); ?></option>
        <?php endforeach; ?>
      </select>
      <input value="" class="date w100 txt" id="start_date" type="text" placeholder="开始日期" />
      <input value="" class="date w100 txt" id="end_date" type="text" placeholder="截止日期" />
      <input type="text" class="w300 txt" id="order_id" placeholder="输入订单号" />
      <button type="button" class="sbtn btn" onclick="searchRes(1)">搜 索</button>
    </div>
    <div class="module mt5" id="rows"></div>
  </div>
</div>
<script type="text/template" id="table-tpl">
<form method="post" id="mulentform">
  <table class="datalist">
    <tr>
      <th width="60" colspan="2">编号</th>
      <th width="150">订单号</th>
      <th width="100">下单日期</th>
      <th width="130">总金额 (元)</th>
      <th class="ta-l">收件人</th>
      <th width="130">订单状态</th>
    </tr>
    {@each list as v}
    <tr>
      <td width="20"><input name="id[]" type="checkbox" value="${v.order_id}" /></td>
      <td width="40">${v.id}</td>
      <td><a class="blue" href="<?php echo url(array('m'=>$MOD, 'c'=>'order', 'a'=>'view', 'id'=>'${v.order_id}', ));?>">${v.order_id}</a></td>
      <td>$${v.created_date}</td>
      <td><b class="red">${v.order_amount}</b></td>
      <td class="ta-l">
        <p>${v.receiver}<font class="c555 ml10">(<b>${v.mobile}</b>)</font></p>
        <p class="mt5">${v.province} ${v.city} ${v.borough} ${v.address}</p>
        {@if v.zip != ''}<p class="mt5">${v.zip}</p>{@/if}
      </td>
      <td>${v.order_status}</td>
    </tr>
    {@/each}
  </table>
</form>
</script>
<?php include $_view_obj->compile('backend/lib/paging.html'); ?>
<script type="text/javascript" src="public/script/juicer.js"></script>
<script type="text/javascript" src="public/theme/backend/js/datetimepicker.js"></script>
</body>
</html>