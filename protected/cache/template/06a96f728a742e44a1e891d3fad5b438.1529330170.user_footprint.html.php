<?php if(!class_exists("View", false)) exit("no direct access allowed");?><!DOCTYPE HTML>
<html>
<head>
<?php include $_view_obj->compile('mobile/default/lib/meta.html'); ?>
<title>我的足迹 - <?php echo htmlspecialchars($GLOBALS['cfg']['site_name'], ENT_QUOTES, "UTF-8"); ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/css/general.css" />
<link rel="stylesheet" type="text/css" href="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/iconfont/iconfont.css">
<link rel="stylesheet" type="text/css" href="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/css/user.css" />
<script type="text/javascript" src="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/js/zepto.min.js"></script>
<script type="text/javascript" src="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/js/verydows.mobile.js"></script>
<script type="text/javascript">
$(function(){
  showFootprint();
});

function showFootprint(){
  var container = $('#fpli');
  $.asynInter("<?php echo url(array('c'=>'api/user', 'a'=>'footprint', ));?>", null, function(res){
    if(res.status == 'success'){
      container.append(juicer($('#fp-tpl').html(), res));
    }else{
      container.append($('#nodata-tpl').html());
    }
  }, 'get');
}

function clearFootprint(){
  $.vdsConfirm({
    content: '您确定要全部清空吗?',
    ok: function(){
      setCookie('FOOTPRINT', null, -9999);
      $('#fpli').empty().html($('#nodata-tpl').html());
    }
  });
}
</script>
</head>
<body>
<div class="wrapper">
  <div class="header">
    <div class="op lt"><a href="javascript:history.back(-1)"><i class="f20 iconfont">&#xe602;</i></a></div>
    <h2>我的足迹</h2>
    <div class="op rt"><a class="pointer" href="javascript:void(0)" onClick="clearFootprint()"><i class="f20 iconfont">&#xe62b;</i></a></div>
  </div>
  <div class="fpli cut" id="fpli"></div>
</div>
<script type="text/template" id="fp-tpl">
{@each list as v}
<dl>
  <dt><a href="<?php echo url(array('c'=>'mobile/goods', 'a'=>'index', 'id'=>'${v.goods_id}', ));?>"><img src="<?php echo htmlspecialchars($common['baseurl'], ENT_QUOTES, "UTF-8"); ?>/upload/goods/prime/150x150/${v.goods_image}" /></a></dt>
  <dd>
    <p><a href="<?php echo url(array('c'=>'mobile/goods', 'a'=>'index', 'id'=>'${v.goods_id}', ));?>">${v.goods_name}</a></p>
    <p class="price mt5"><i class="cny">¥</i><font class="f14">${v.now_price}</font></p>
  </dd>
</dl>
{@/each}
</script>
<script type="text/template" id="nodata-tpl">
<div class="nodata">
  <div class="th"><span><i class="iconfont">&#xe613;</i></span><div class="line"></div></div>
  <p>暂无商品浏览记录</p>
</div>
</script>
<script type="text/javascript" src="<?php echo htmlspecialchars($common['baseurl'], ENT_QUOTES, "UTF-8"); ?>/public/script/juicer.js"></script>
</body>
</html>