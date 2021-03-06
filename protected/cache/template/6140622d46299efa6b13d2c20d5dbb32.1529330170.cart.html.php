<?php if(!class_exists("View", false)) exit("no direct access allowed");?><!DOCTYPE HTML>
<html>
<head>
<?php include $_view_obj->compile('mobile/default/lib/meta.html'); ?>
<meta name="keywords" content="购物车, 购物篮, 购物清单" />
<meta name="description" content="我的购物车" />
<title>我的购物车 - <?php echo htmlspecialchars($GLOBALS['cfg']['site_name'], ENT_QUOTES, "UTF-8"); ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/css/general.css" />
<link rel="stylesheet" type="text/css" href="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/iconfont/iconfont.css">
<link rel="stylesheet" type="text/css" href="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/css/order.css" />
<script type="text/javascript" src="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/js/zepto.min.js"></script>
<script type="text/javascript" src="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/js/verydows.mobile.js"></script>
<script type="text/javascript" src="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/js/cart.js"></script>
<script type="text/javascript">
$(function(){
  showCartList("<?php echo url(array('c'=>'api/cart', 'a'=>'list', ));?>");
  $('#showMenuBtn').vdsTapSwapper(
    function(){$('#topMenus').height(50);},
    function(){$('#topMenus').height(0);}
  );
});

function checkout(){
  var cart = {};
  $('#cart .cart-row').each(function(){
    var $item = $(this).data('json');
    $item.qty = $(this).find('.qty input').val();
    cart[$(this).data('key')] = $item;
  });
  setCookie('CARTS', JSON.stringify(cart), 604800);
  window.location.href = "<?php echo url(array('c'=>'mobile/order', 'a'=>'confirm', ));?>";
}
</script>
</head>
<body>
<div class="wrapper" id="wrapper">
  <!-- header start -->
  <div class="header">
    <div class="op lt"><a href="javascript:history.back(-1)"><i class="f20 iconfont">&#xe602;</i></a></div>
    <h2>我的购物车</h2>
    <div class="op rt"><a id="showMenuBtn"><i class="f28 iconfont">&#xe60e;</i></a></div>
  </div>
  <div class="absmu latent" id="topMenus">
    <a href="<?php echo url(array('c'=>'mobile/main', 'a'=>'index', ));?>"><i class="iconfont">&#xe606;</i><span>首页</span></a>
    <a href="<?php echo url(array('c'=>'mobile/category', 'a'=>'index', ));?>"><i class="iconfont">&#xe60b;</i><span>商品分类</span></a>
    <a class="cur"><i class="iconfont">&#xe603;</i><span>购物车</span></a>
    <a href="<?php echo url(array('c'=>'mobile/user', 'a'=>'index', ));?>"><i class="iconfont">&#xe632;</i><span>我的</span></a>
  </div>
  <!-- header end -->
  <div class="cart" id="cart"></div>
</div>
<script type="text/template" id="item-tpl">
<div class="gli cut">
  <ul>
    {@each items as v, k}
    <li class="cart-row" data-key="${k}" data-json='${v.json}'>
      <div class="im"><a href="<?php echo url(array('c'=>'mobile/goods', 'a'=>'index', 'id'=>'${v.goods_id}', ));?>"><img src="<?php echo htmlspecialchars($common['baseurl'], ENT_QUOTES, "UTF-8"); ?>/upload/goods/prime/100x100/${v.goods_image}" /></a></div>
      <div class="info">
        <p class="name"><a href="<?php echo url(array('c'=>'mobile/goods', 'a'=>'index', 'id'=>'${v.goods_id}', ));?>">${v.goods_name}</a></p>
        {@if v.opts}
        <p class="opts mt5">{@each v.opts as vv}<span class="mr5">[${vv.type}: <font>${vv.opt_text}</font>]</span>{@/each}</p>
        {@/if}
        <p class="price mt5"><i class="cny">¥</i><font class="unit-price f14">${v.now_price}</font></p>
        <div class="act">
          <div class="qty"><a class="minus">-</a><input type="text" value="${v.qty}" data-stock="${v.stock_qty}" readonly="readonly" /><a class="plus">+</a></div>
          <a class="remove"><i class="iconfont">&#xe610;</i></a>
        </div>
      </div>
    </li>
    {@/each}
  </ul>
</div>
</script>
<script type="text/template" id="nodata-tpl">
<div class="nodata">
  <div class="th"><span><i class="iconfont">&#xe603;</i></span><div class="line"></div></div>
  <p>您的购物车是空的！快去添点什么吧。</p>
  <a class="stroll xauto f14 mt20" href="<?php echo url(array('c'=>'mobile/main', 'a'=>'index', ));?>">去逛逛</a>
</div>
</script>
<script type="text/template" id="footact-tpl">
<div class="footact footfixed" id="footfixed">
  <div class="totals f14 c666" id="cart-totals">
    购物车中有<b id="cart-kinds" class="sep3">0</b>种商品，共计：<span class="red f16"><i class="cny">¥</i><font id="cart-amount">0.00</font></span>
  </div>
  <div class="act">
    <a class="clear"><i class="iconfont">&#xe610;</i><font class="f14 ml5">清空购物车</font></a>
    <a class="checkout" onclick="checkout()"><i class="iconfont">&#xe60f;</i><b class="f14 ml5">去结算</b></a>
  </div>
</div>
</script>
<script type="text/javascript" src="<?php echo htmlspecialchars($common['baseurl'], ENT_QUOTES, "UTF-8"); ?>/public/script/juicer.js"></script>
<?php include $_view_obj->compile('mobile/default/lib/footer.html'); ?>
</body>
</html>