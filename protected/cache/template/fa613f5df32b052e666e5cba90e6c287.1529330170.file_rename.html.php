<?php if(!class_exists("View", false)) exit("no direct access allowed");?><script type="text/javascript">
function doRename(s){
  var initform = function(){
    $.vdsMasker(false);
    $('#pop-rename').find('form')[0].reset();
    $('#pop-rename').find('span.vdsfielderr').remove();
  };
  switch(s){
    case 'pop':
      if(true == isChecked()){
        var checked = $('input[name="id"]:checked').eq(0), name = checked.data('name'), path = checked.data('path');	
        initform();
        $.vdsMasker(true);
        $('#pop-rename input[name="oldname"]').val(path);
        $('#pop-rename input[name="newname"]').val(name);
        $('#pop-rename').vdsMidst({wrapper:$(window)}).show();
      }
    break;	
    case 'submit':
      if(true == isChecked()){
        var newname = $('#pop-rename input[name="newname"]');
        newname.vdsFieldChecker({
          rules:{required:[true, '文件名不能为空'], format:[/^[^*\/|:<>?\\"]*$/.test(newname.val()), '文件名不能包含特殊字符']},
          tipsPos: 'cr'
        });
        $('#pop-rename form').vdsFormChecker();
      }
    break;	
    case 'close':
      initform();
      $('#pop-rename').hide();
    break;
  }
}
</script>
<div class="poper rename cut" id="pop-rename">
  <a class="close" onclick="doRename('close')"></a>
  <div class="poper-hd"><h3 class="f14 ta-c">重命名</h3></div>
  <form method="post" action="<?php echo url(array('m'=>$MOD, 'c'=>'file', 'a'=>'rename', ));?>">
    <input type="hidden" name="oldname" value="" />
    <div class="mt10 pad10 cut">
      <ul class="ta-c">
        <li><input class="w300 txt ta-c" name="newname" type="text" placeholder="请输入新文件名" /></li>
        <li class="mt10 c999">文件名中不能包含下列任何字符之一：<p class="c666 mt5">\ / : * ? " &lt; &gt;</p></li>
      </ul>
    </div>
  </form>
  <div class="poper-bom ta-c mt5">
    <button type="button" class="ubtn btn" onclick="doRename('submit')">确定</button>
    <span class="sep40"></span>
    <button type="button" class="fbtn btn" onclick="doRename('close')">取消</button>
  </div>
</div>