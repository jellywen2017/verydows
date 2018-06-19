<?php if(!class_exists("View", false)) exit("no direct access allowed");?><!DOCTYPE HTML>
<html>
<head>
<?php include $_view_obj->compile('mobile/default/lib/meta.html'); ?>
<meta name="keywords" content="用户注册" />
<meta name="description" content="用户注册" />
<title>用户注册 - <?php echo htmlspecialchars($GLOBALS['cfg']['site_name'], ENT_QUOTES, "UTF-8"); ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/css/general.css" />
<link rel="stylesheet" type="text/css" href="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/iconfont/iconfont.css">
<link rel="stylesheet" type="text/css" href="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/css/login.css" />
<script type="text/javascript" src="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/js/zepto.min.js"></script>
<script type="text/javascript" src="<?php echo htmlspecialchars($common['theme'], ENT_QUOTES, "UTF-8"); ?>/js/verydows.mobile.js"></script>
<script type="text/javascript">
$(function(){
  $('#reg-btn').on('click', function(){
    register();
  });
  $('#agreement').on('click', function(){
    if(!$(this).prop('checked')){
      $('#reg-btn').addClass('disabled').off('click');
    }else{
      $('#reg-btn').removeClass('disabled').on('click', function(){register();});
    }
  });
});

function register(){
  $('#username').vdsFieldChecker({rules: {required:[true, '请设置用户名']}});
  $('#email').vdsFieldChecker({rules: {required:[true, '请设置邮箱地址'], email:[true, '邮箱地址无效']}});
  $('#password').vdsFieldChecker({rules: {password:[true, '密码不符合要求，可包含字母、数字或特殊符号，长度须为6~32个字符']}});
  $('#repassword').vdsFieldChecker({rules: {equal:[$('#password').val(), '两次密码不一致']}});
  if($('#captcha')) $('#captcha input.field').vdsFieldChecker({rules: {required:[true, '请输入验证码']}});
  if($('#reg-form').vdsFormChecker({isSubmit:false}) == true){
    var dataset = {username:$('#username').val(), email:$('#email').val(), password:$('#password').val(), repassword:$('#repassword').val(), captcha:$('#captcha input.field').val()}
    $.asynInter("<?php echo url(array('c'=>'api/user', 'a'=>'register', ));?>", dataset, function(res){
      if(res.status == 'success'){
        $.vdsPrompt({
          content: '注册完成! 请牢记您的用户名和密码',
          clicked: function(){window.location.href = "<?php echo url(array('c'=>'mobile/user', 'a'=>'index', ));?>";}
        });
      }else{
        $.vdsPrompt({content:res.msg});
        return false;
      }
    });
  }
}
</script>
</head>
<body>
<div class="wrapper">
  <!-- header start -->
  <div class="header">
    <div class="op lt"><a href="javascript:history.back(-1);"><i class="f20 iconfont">&#xe602;</i></a></div>
    <h2>注册新用户</h2>
  </div>
  <!-- header end -->
  <form id="reg-form">
  <div class="eform">
    <div class="tr puff"><input class="field" type="text" name="username" id="username" placeholder="设置用户名" /></div>
    <div class="tr puff mt10"><input class="field" type="email" name="email" id="email" placeholder="设置邮箱" /></div>
    <div class="tr puff mt10"><input class="field" type="password" name="password" id="password" placeholder="设置登录密码" /><i class="vineyebtn iconfont">&#xe66e;</i></div>
    <div class="tr puff mt10"><input class="field" type="password" name="repassword" id="repassword" placeholder="确认登录密码" /><i class="vineyebtn iconfont">&#xe66e;</i></div>
    <?php if (!empty($GLOBALS['cfg']['captcha_user_register'])) : ?>
    <div class="captcha puff tr mt10" id="captcha">
      <a class="fr"><img onclick="resetCaptcha(this)" src="<?php echo url(array('c'=>'api/captcha', 'a'=>'image', ));?>" /></a>
      <input class="field" type="text" placeholder="请输入图形验证码" />
    </div>
    <?php endif; ?>
    <div class="slck mt10 cut">
      <div class="fl c888 f14">同意用户注册协议</div>
      <div class="fr"><input class="vswitch-1" name="agreement" id="agreement" type="checkbox" checked="checked" value="1" /><label for="agreement"></label></div>
    </div>
    <div class="submit mt20"><a href="javascript:void(0)" id="reg-btn">注 册</a></div>
    <div class="mt20 center c999">已有账号？<a class="blue" href="<?php echo url(array('c'=>'mobile/user', 'a'=>'login', ));?>">直接登录</a></div>
  </div>
  </form>
</div>
<?php include $_view_obj->compile('mobile/default/lib/footer.html'); ?>
</body>
</html>