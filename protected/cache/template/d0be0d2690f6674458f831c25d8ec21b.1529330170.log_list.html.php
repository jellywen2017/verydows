<?php if(!class_exists("View", false)) exit("no direct access allowed");?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include $_view_obj->compile('backend/lib/meta.html'); ?>
<link rel="stylesheet" type="text/css" href="public/theme/backend/css/verydows.css" />
<link rel="stylesheet" type="text/css" href="public/theme/backend/css/main.css" />
<script type="text/javascript" src="public/script/jquery.js"></script>
<script type="text/javascript" src="public/theme/backend/js/verydows.js"></script>
<script type="text/javascript" src="public/theme/backend/js/list.js"></script>
<script type="text/javascript">
$(function(){searchRes(1);});

function searchRes(page_id){
  $.asynList("<?php echo url(array('m'=>$MOD, 'c'=>'order_log', 'a'=>'index', 'step'=>'search', ));?>", {kw: $('#kw').val()}, function(data){
    if(data.status == 'success'){
      $('#rows').append(juicer($('#row-tpl').html(), data));
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
  <div class="loc"><h2><i class="icon"></i>订单日志</h2></div>
  <div class="box">
    <div class="doacts"><a class="ae btn" onclick="domulent('<?php echo url(array('m'=>$MOD, 'c'=>'order_log', 'a'=>'delete', ));?>')"><i class="remove"></i><font>删除</font></a></div>
    <div class="stools mt5">
      <input type="text" class="w300 txt" id="kw" placeholder="输入订单号" />
      <button type="button" class="sbtn btn" onclick="searchRes(1)">搜 索</button>
    </div>
    <div class="module mt5" id="rows"></div>
  </div>
</div>
<script type="text/template" id="row-tpl">
<form method="post" id="mulentform">
  <table class="datalist">
    <tr>
      <th width="60" colspan="2">编号</th>
      <th width="150">订单号</th>
      <th class="ta-l" width="400">操作记录</th>
      <th class="ta-l">原因</th>
    </tr>
    {@each list as v}
    <tr>
      <td width="20"><input name="id[]" type="checkbox" value="${v.id}" /></td>
      <td width="40">${v.id}</td>
      <td><a class="blue" href="<?php echo url(array('m'=>$MOD, 'c'=>'order', 'a'=>'view', 'id'=>'${v.order_id}', ));?>">${v.order_id}</a></td>
      <td class="ta-l c666">管理员<b class="ml5 mr5">${v.username}</b>在<font class="ml5 mr5">${v.dateline}</font>${v.operate}</td>
      <td class="ta-l c666">${v.cause}</td>
    </tr>
    {@/each}
  </table>
</form>
</script>
<?php include $_view_obj->compile('backend/lib/paging.html'); ?>
<script type="text/javascript" src="public/script/juicer.js"></script>
</body>
</html>