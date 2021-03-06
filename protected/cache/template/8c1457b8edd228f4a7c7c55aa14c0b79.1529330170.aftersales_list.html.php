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
  var dataset = {type:$('#type').val(), status:$('#status').val(), sort_id:$('#sort_id').val(), order_id:$('#order_id').val(), page:page_id};
  
  $.asynList("<?php echo url(array('m'=>$MOD, 'c'=>'aftersales', 'a'=>'index', 'step'=>'search', ));?>", dataset, function(data){
    if(data.status == 'success'){
      $('#rows').append(juicer($('#table-tpl').html(), data));
      $('#rows tr').vdsRowHover();
      $('#rows tr:even').addClass('even');
      if(data.paging != null)$('#rows').append(juicer($('#paging-tpl').html(), data));
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
  <div class="loc"><h2><i class="icon"></i>售后服务</h2></div>
  <div class="box">
    <div class="doacts">
      <a class="ae btn" onclick="doslvent('<?php echo url(array('m'=>$MOD, 'c'=>'aftersales', 'a'=>'view', ));?>', 'id')"><i class="view"></i><font>查看详细</font></a>
      <a class="ae btn" onclick="doslvent('<?php echo url(array('m'=>$MOD, 'c'=>'aftersales', 'a'=>'delete', ));?>', 'id')"><i class="remove"></i><font>删除</font></a>
    </div>
    <div class="stools mt5">
      <select id="type" class="slt">
        <option value="" selected="selected">全部类型</option>
        <?php $_foreach_v_counter = 0; $_foreach_v_total = count($type_map);?><?php foreach( $type_map as $k => $v ) : ?><?php $_foreach_v_index = $_foreach_v_counter;$_foreach_v_iteration = $_foreach_v_counter + 1;$_foreach_v_first = ($_foreach_v_counter == 0);$_foreach_v_last = ($_foreach_v_counter == $_foreach_v_total - 1);$_foreach_v_counter++;?>
        <option value="<?php echo htmlspecialchars($k, ENT_QUOTES, "UTF-8"); ?>"><?php echo htmlspecialchars($v, ENT_QUOTES, "UTF-8"); ?></option>
        <?php endforeach; ?>
      </select>
      <select id="status" class="slt">
        <option value="">全部状态</option>
        <?php $_foreach_v_counter = 0; $_foreach_v_total = count($status_map);?><?php foreach( $status_map as $k => $v ) : ?><?php $_foreach_v_index = $_foreach_v_counter;$_foreach_v_iteration = $_foreach_v_counter + 1;$_foreach_v_first = ($_foreach_v_counter == 0);$_foreach_v_last = ($_foreach_v_counter == $_foreach_v_total - 1);$_foreach_v_counter++;?>
        <option value="<?php echo htmlspecialchars($k, ENT_QUOTES, "UTF-8"); ?>"><?php echo htmlspecialchars($v, ENT_QUOTES, "UTF-8"); ?></option>
        <?php endforeach; ?>
      </select>
      <select id="sort_id" class="slt">
        <option value="0">默认排序</option>
        <option value="1">时间升序</option>
        <option value="2">时间倒序</option>
      </select>
      <input type="text" class="w300 txt" name="order_id" id="order_id" placeholder="输入订单号" />
      <button type="button" class="sbtn btn" onclick="searchRes(1)">搜 索</button>
    </div>
    <div class="module mt5" id="rows"></div>
  </div>
</div>
<script type="text/template" id="table-tpl">
<table class="datalist">
  <tr>
    <th width="60" colspan="2">编号</th>
    <th width="130">订单号</th>
    <th class="ta-l">商品</th>
    <th width="90">申请数量</th>
    <th width="130">用户名</th>
    <th width="130">期望处理类型</th>
    <th width="120">日期</th>
    <th width="120">状态</th>
  </tr>
  {@each list as v}
  <tr>
    <td width="20"><input name="id" type="checkbox" value="${v.as_id}" /></td>
    <td width="40">${v.as_id}</td>
    <td><a class="blue" href="index.php?m=<?php echo htmlspecialchars($MOD, ENT_QUOTES, "UTF-8"); ?>&c=aftersales&a=view&id=${v.as_id}">${v.order_id}</a></td>
    <td class="ta-l">
      <p><a class="blue" href="index.php?c=goods&a=index&id=${v.goods_id}">${v.goods_name}</a></p>
      {@if v.goods_opts != null}<p class="c999 mt5">{@each v.goods_opts as o}<span class="mr5">[${o.opt_type}: <font class="c666">${o.opt_text}</font>]</span>{@/each}</p>{@/if}
    </td>
    <td>${v.goods_qty}</td>
    <td width="30"><a class="blue" href="index.php?m=<?php echo htmlspecialchars($MOD, ENT_QUOTES, "UTF-8"); ?>&c=user&a=view&id=${v.user_id}">${v.username}</a></td>
    <td>${v.type}</td>
    <td class="c666">$${v.created_date}</td>
    <td>${v.status}</td>
  </tr>
  {@/each}
</table>
</script>
<?php include $_view_obj->compile('backend/lib/paging.html'); ?>
<script type="text/javascript" src="public/script/juicer.js"></script>
</body>
</html>